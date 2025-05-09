<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoHR2;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TrainingController extends Controller
{
    public function tms(){

        return view('auth.others.training');
    }
    public function addtms(){

        return view('auth.others.training_add');
    }
    public function registerVideo(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'vidTitle' => 'required|string|max:255',
                'vidDesc' => 'required|string',
                'vidIns' => 'required|string|max:255',
                'vidDep' => 'required|string|max:255',
                'vidLoc' => 'required|string|max:255',
                'vidDate' => 'required|date',
                'vidBud' => 'required|numeric|min:0',
                'video' => 'required|file|mimes:mp4,avi,mov|max:50000' // 50MB max
            ]);

            // Check validation
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Handle file upload
            if ($request->hasFile('video')) {
                $videoFile = $request->file('video');
                $videoPath = $videoFile->store('seminar_videos', 'public');

                // Save to database
                $video = new VideoHR2();
                $video->title = $request->input('vidTitle');
                $video->description = $request->input('vidDesc');
                $video->instructor = $request->input('vidIns');
                $video->department = $request->input('vidDep');
                $video->location = $request->input('vidLoc');
                $video->date_time = $request->input('vidDate');
                $video->estimated_budget = $request->input('vidBud');
                $video->video_path = $videoPath;
                $video->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Seminar Presentation added successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No video file uploaded.'
            ], 400);

        } catch (\Exception $e) {
            // Log the full error for server-side debugging
            Log::error('Video Upload Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function show()
    {
        $list = VideoHR2::all(); 
        return view('auth.others.training_add', compact('list'));
    }
    public function edit($id)
{
    $item = VideoHR2::findOrFail($id);

    return response()->json([
        'id' => $item->id,
        'title' => $item->title,
        'instructor' => $item->instructor,
        'description' => $item->description,
        'department' => $item->department,
        'location' => $item->location,
        'date' => $item->date,
        'estimated_budget' => $item->estimated_budget,
        'video_filename' => $item->video ? $item->video->filename : null
    ]);
}

        public function update(Request $request, $id)
        {
            $validatedData = $request->validate([
                'vidTitle' => 'required|string|max:255',
                'vidIns' => 'required|string|max:255',
                'vidDesc' => 'required|string',
                'vidDep' => 'required|string|max:255',
                'vidLoc' => 'required|string|max:255',
                'vidDate' => 'required|date',
                'vidBud' => 'required|numeric',
                'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240' // Optional video upload
            ]);

            $item = VideoHR2::findOrFail($id);

            // Update item details
            $item->title = $validatedData['vidTitle'];
            $item->instructor = $validatedData['vidIns'];
            $item->description = $validatedData['vidDesc'];
            $item->department = $validatedData['vidDep'];
            $item->location = $validatedData['vidLoc'];
            $item->date_time = $validatedData['vidDate']; // Note: changed from 'date' to 'date_time'
            $item->estimated_budget = $validatedData['vidBud'];

            // Handle video upload if present
            if ($request->hasFile('video')) {
                $videoFile = $request->file('video');
                $filename = time() . '_' . $videoFile->getClientOriginalName();
                $path = $videoFile->storeAs('seminar_videos', $filename, 'public');

                // Delete old video file if exists
                if ($item->video_path) {
                    Storage::disk('public')->delete($item->video_path);
                }

                // Update video path
                $item->video_path = $path;
            }

            $item->save();

            return response()->json([
                'message' => 'Training item updated successfully',
                'item' => $item
            ]);
        }
       
        public function destroy($id)
        {
            try {
                $item = VideoHR2::findOrFail($id);
                $item->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Seminar soft deleted successfully'
                ]);
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Soft Delete Error: ' . $e->getMessage());
        
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to soft delete the seminar'
                ], 500);
            }
        }
        
    public function index()
    {
        $seminars = VideoHR2::orderBy('date_time', 'desc')->get();

        return view('auth.others.training', compact('seminars'));
    }
}
