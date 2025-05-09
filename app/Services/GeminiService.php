<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-2.0-flash');
        $this->baseUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    public function generateQuestion(array $params)
    {
        try {
            $prompt = $this->constructPrompt($params);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("{$this->baseUrl}?key=" . urlencode($this->apiKey), [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API Error Response:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception('Gemini API request failed.');
            }

            $body = $response->json();

            if (!isset($body['candidates']) || empty($body['candidates'])) {
                throw new Exception('No candidates found in Gemini API response.');
            }

            $generatedContent = $body['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$generatedContent) {
                throw new Exception('No generated content found in API response.');
            }

            return [
                'success' => true,
                'question' => $generatedContent
            ];
        } catch (Exception $e) {
            Log::error('Gemini API Generation Error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    protected function constructPrompt(array $params)
    {
        $topic = $params['topic'] ?? 'General Knowledge';
        $difficulty = $params['difficulty'] ?? 'medium';
        $questionType = $params['questionType'] ?? 'multiple-choice';
        $additionalContext = $params['additionalContext'] ?? '';

        return "Generate a {$difficulty} difficulty {$questionType} question about {$topic}.
                {$additionalContext}

                For a {$questionType} question:
                - Provide a clear question
                - Include answer choices if multiple choice
                - Clearly mark the correct answer
                - Add a brief explanation

                Format:
                Question: [Question Text]

                A) [Option 1]
                B) [Option 2]
                C) [Option 3]
                D) [Option 4]

                Correct Answer: [Correct Option Letter]

                Explanation: [Brief explanation of the answer]";
    }

    public function parseGeneratedQuestion(string $questionText, array $params)
    {
        $lines = explode("\n", trim($questionText));

        $question = '';
        $options = [];
        $answer = '';
        $explanation = '';

        foreach ($lines as $line) {
            if (preg_match('/^Question:\s*(.+)/i', $line, $matches)) {
                $question = trim($matches[1]);
            } elseif (preg_match('/^[A-D]\)\s*(.+)/', $line, $matches)) {
                $options[] = trim($matches[1]);
            } elseif (preg_match('/^Correct Answer:\s*([A-D])/', $line, $matches)) {
                $answer = $matches[1];
            } elseif (preg_match('/^Explanation:\s*(.+)/i', $line, $matches)) {
                $explanation = trim($matches[1]);
            }
        }

        return [
            'text' => $question,
            'options' => json_encode($options),
            'answer' => $answer,
            'explanation' => $explanation
        ];
    }
}
