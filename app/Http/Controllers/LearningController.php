<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingHR2;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LearningController extends Controller
{
    public function lms(){

        return view('auth.others.learning');
    }
    public function lmsemp(){

        return view('auth.others.learning-employee');
    }
    public function addlms(){
        return view('auth.others.learning_add');
    }
    public function storeTraining(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'instructor' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'goals' => 'required|string|max:255',
                'date' => 'required|date|after_or_equal:now',
                'dueDate' => 'required|date|after_or_equal:date',
                'budget' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Handle image upload if provided
            $imagePath = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Store with the original name in 'training-image' folder
                $imagePath = $image->storeAs(
                    'training-image', // Directory
                    $image->getClientOriginalName(), // Original file name
                    'public' // Storage disk
                );
            }


            // Create the training session
            $trainingSession = TrainingHR2::create([
                'title' => $request->title,
                'description' => $request->description,
                'instructor' => $request->instructor,
                'department' => $request->department,
                'goals' => $request->goals,
                'date' => $request->date,
                'dueDate' => $request->dueDate,
                'budget' => $request->budget,
                'image' => $imagePath, // Save the image path
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Training Session Created Successfully',
                'data' => $trainingSession,
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage() ?: 'An error occurred while creating the training session'
            ], 500);
        }
    }
    public function show()
    {
        $list = TrainingHR2::orderBy('created_at', 'desc')->paginate(10);

        return view('auth.others.learning_add', compact('list'));
    }

    public function edit($id)
{
    try {
        $training = TrainingHR2::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => [
                'title' => $training->title,
                'description' => $training->description,
                'instructor' => $training->instructor,
                'department' => $training->department,
                'goals' => $training->goals,
                'date' => $training->date ? $training->date->format('Y-m-d\TH:i') : null,
                'dueDate' => $training->dueDate ? $training->dueDate->format('Y-m-d\TH:i') : null,
                'budget' => $training->budget,
                'image' => $training->image ?? null
            ]
        ]);
    } catch (\Exception $e) {
        \Log::error('Error fetching training: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Training not found'
        ], 404);
    }
}

public function update(Request $request, $id)
{
    try {
        $validator = Validator::make($request->all(), [
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'Instructor' => 'required|string|max:255',
            'Department' => 'required|string|max:255',
            'goals' => 'required|string|max:500',
            'date' => 'required|date',
            'dueDate' => 'required|date|after_or_equal:date',
            'budget' => 'required|numeric|min:0',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $training = TrainingHR2::findOrFail($id);

        // Handle image upload (only if a new image is provided)
        if ($request->hasFile('image')) {
            // Optional: Delete old image if exists
            if ($training->image_path) {
                Storage::disk('public')->delete($training->image_path);
            }

            $imagePath = $request->file('image')->store('training_images', 'public');
            $training->image_path = $imagePath;
        }

        // Update training details
        $training->title = $request->input('Title');
        $training->description = $request->input('Description');
        $training->instructor = $request->input('Instructor');
        $training->department = $request->input('Department');
        $training->goals = $request->input('goals');
        $training->date = $request->input('date');
        $training->dueDate = $request->input('dueDate');
        $training->budget = $request->input('budget');

        $training->save();

        return response()->json([
            'status' => true,
            'message' => 'Training updated successfully'
        ]);
    } catch (\Exception $e) {
        \Log::error('Error updating training: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Error updating training: ' . $e->getMessage()
        ], 500);
    }
}

public function delete($id)
{
    try {
        $training = TrainingHR2::findOrFail($id);

        // Optional: Delete associated image if exists
        if ($training->image_path) {
            Storage::disk('public')->delete($training->image_path);
        }

        $training->delete();

        return response()->json([
            'status' => true,
            'message' => 'Training deleted successfully'
        ]);
    } catch (\Exception $e) {
        \Log::error('Error deleting training: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Failed to delete training: ' . $e->getMessage()
        ], 500);
    }
}

    public function index()
    {
        $perPage = 1;
        $courses = TrainingHR2::orderBy('created_at', 'desc')->paginate($perPage);
        return view('auth.others.learning', compact('courses'));

    }
    public function employee()
    {
        $perPage = 1;
        $courses = TrainingHR2::orderBy('created_at', 'desc')->paginate($perPage);
        return view('auth.others.learning-employee', compact('courses'));

    }
}
