<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'trainingObjectives' => 'required|string',
            'recipientEmail' => 'required|email',
            'targetCompletion' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $trainingObjectives = $request->trainingObjectives;
            $targetCompletion = $request->targetCompletion ? date('F j, Y', strtotime($request->targetCompletion)) : null;

            // Create HTML content
            $htmlContent = '<!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Growth Plan</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .logo {
                        font-size: 24px;
                        font-weight: bold;
                        color: #6B46C1;
                    }
                    h2 {
                        color: #4A5568;
                    }
                    .content {
                        background-color: #f9f9f9;
                        padding: 20px;
                        border-radius: 8px;
                    }
                    .footer {
                        margin-top: 20px;
                        text-align: center;
                        font-size: 12px;
                        color: #718096;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <div class="logo">JVD TRAVEL AND TOURS</div>
                    </div>

                    <div class="content">
                        <h2>Growth Plan Details</h2>

                        <p><strong>Training Objectives:</strong><br>
                            ' . nl2br(htmlspecialchars($trainingObjectives)) . '
                        </p>';

            if ($targetCompletion) {
                $htmlContent .= '<p><strong>Target Completion Date:</strong> ' . $targetCompletion . '</p>';
            }

            $htmlContent .= '</div>

                    <div class="footer">
                        <p>This email was sent from JVD TRAVEL AND TOURS.</p>
                    </div>
                </div>
            </body>
            </html>';

            // Cleaner way to send raw HTML emails in Laravel
            Mail::raw('', function ($message) use ($request, $htmlContent) {
                $message->to($request->recipientEmail)
                       ->subject('Growth Plan - Training Objectives')
                       ->html($htmlContent);
            });

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendCongratulatoryEmail(Request $request)
    {
        \Log::info('Request data:', $request->all());
        \Log::info('Files:', $request->files->all());
        // Validate input
        $validator = Validator::make($request->all(), [
            'recipientEmail' => 'required|email',
            'certificateFile' => 'required|file|mimes:pdf|max:51200', // 50MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $recipientEmail = $request->recipientEmail;

            // Store the uploaded certificate file
            $certificatePath = $request->file('certificateFile')->store('certificates', 'public');

            // Get absolute path
            $certificateFullPath = storage_path('app/public/' . $certificatePath);

            // HTML Content
            $htmlContent = '<!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Certificate of Completion</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; text-align: center; }
                    .header { font-size: 24px; font-weight: bold; color: #2D3748; }
                    .content { background-color: #f9f9f9; padding: 20px; border-radius: 8px; }
                    .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #718096; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">🎉 Congratulations!</div>
                    <div class="content">
                        <p>We are proud to present your certificate of completion.</p>
                        <p>Attached is your certificate. Keep up the great work!</p>
                    </div>
                    <div class="footer">
                        <p>Best regards, <br> JVD TRAVEL AND TOURS</p>
                    </div>
                </div>
            </body>
            </html>';

            // Cleaner way to send email with attachment in Laravel
            Mail::raw('', function ($message) use ($recipientEmail, $htmlContent, $certificateFullPath) {
                $message->to($recipientEmail)
                        ->subject('🎓 Certificate of Completion')
                        ->html($htmlContent)
                        ->attach($certificateFullPath);
            });

            return response()->json([
                'success' => true,
                'message' => 'Congratulatory email sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
