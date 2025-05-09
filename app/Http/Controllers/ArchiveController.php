<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingSchedule;
use App\Models\TrainingHR2;
use App\Models\VideoHR2;


class ArchiveController extends Controller
{
    // public function archive(){
    //     return view('auth.others.archive');
    // }
    public function archive()
    {
        // Get archived (soft-deleted) records with pagination
        $archivedSchedules = TrainingSchedule::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10, ['*'], 'schedules_page');

        $archivedHR2Trainings = TrainingHR2::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10, ['*'], 'hr2_page');

            $archivedVideoHR2s = VideoHR2::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('auth.others.archive', compact('archivedSchedules', 'archivedHR2Trainings','archivedVideoHR2s'));
    }
    public function restoreSchedule($id)
    {
        $schedule = TrainingSchedule::onlyTrashed()->findOrFail($id);
        $schedule->restore();

        return redirect()->route('auth.others.archive')
            ->with('toast', 'Restored Successfully');
    }

    /**
     * Restore a soft-deleted HR2 training
     */
    public function restoreHR2($id)
    {
        $training = TrainingHR2::onlyTrashed()->findOrFail($id);
        $training->restore();

        return redirect()->route('auth.others.archive')
            ->with('toast', 'Restored Successfully');
    }

    /**
     * Permanently delete a training schedule
     */
    public function destroySchedulePermanent($id)
    {
        $schedule = TrainingSchedule::onlyTrashed()->findOrFail($id);
        $schedule->forceDelete();

        return redirect()->route('auth.others.archive')
            ->with('toast', 'Permanently Deleted');
    }

    /**
     * Permanently delete an HR2 training
     */
    public function destroyHR2Permanent($id)
    {
        $training = TrainingHR2::onlyTrashed()->findOrFail($id);
        $training->forceDelete();

        return redirect()->route('auth.others.archive')
            ->with('toast', 'Permanently Deleted');
    }

    public function restoreVideoHR2($id)
    {
        $training = VideoHR2::withTrashed()->findOrFail($id);
        $training->restore();
        
        return redirect()->back()->with('toast', 'Training video restored successfully.');
    }
    public function destroyVideoHR2Permanent($id)
    {
        $training = VideoHR2::withTrashed()->findOrFail($id);
        $training->forceDelete();
        
        return redirect()->back()->with('toast', 'Training video permanently deleted.');
    }
}
