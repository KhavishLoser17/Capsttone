<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingSchedule;

class SeminarController extends Controller
{
    public function seminar(Request $request)
{
 // Get month from request or use current month
    $selectedDate = $request->month ?
        \Carbon\Carbon::createFromFormat('Y-m', $request->month) :
        now();

    $trainings = TrainingSchedule::orderBy('start_date', 'asc')->get();

    $calendarEvents = TrainingSchedule::whereMonth('start_date', $selectedDate->month)
        ->whereYear('start_date', $selectedDate->year)
        ->select('id', 'training_title', 'training_type', 'start_date', 'start_time', 'end_time', 'facility')
        ->get()
        ->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->training_title,
                'date' => $event->start_date->format('Y-m-d'),
                'day' => $event->start_date->day,
                'type' => $event->training_type,
                'time' => $event->start_time->format('H:i') . ' - ' . $event->end_time->format('H:i'),
                'color' => $this->getEventColor($event->training_type),
            ];
        });
    $calendarEventsByDay = $calendarEvents->groupBy(function ($event) {
        return $event['day'];
    });

    // Current month information
    $currentMonth = [
        'name' => $selectedDate->format('F Y'),
        'days' => $selectedDate->daysInMonth,
        'firstDayOfWeek' => $selectedDate->copy()->startOfMonth()->dayOfWeek,
        'previousMonth' => $selectedDate->copy()->subMonth()->format('Y-m'),
        'nextMonth' => $selectedDate->copy()->addMonth()->format('Y-m'),
    ];

    return view('auth.others.seminar', compact('trainings', 'calendarEventsByDay', 'currentMonth'));
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainingTitle' => 'required|string|max:255',
            'trainingType' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'startDate' => 'required|date',
            'startTime' => 'required',
            'endTime' => 'required|after:startTime',
            'trainer' => 'required|string|max:255',
            'facility' => 'required|string|max:255',
            'outsideCampusLocation' => 'required_if:facility,outside-campus|nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $schedule = new TrainingSchedule();
        $schedule->training_title = $validated['trainingTitle'];
        $schedule->training_type = $validated['trainingType'];
        $schedule->department = $validated['department'];
        $schedule->start_date = $validated['startDate'];
        $schedule->start_time = $validated['startTime'];
        $schedule->end_time = $validated['endTime'];
        $schedule->trainer = $validated['trainer'];
        $schedule->facility = $validated['facility'];
        $schedule->outside_campus_location = ($validated['facility'] === 'outside-campus') ?
            $validated['outsideCampusLocation'] : null;
        $schedule->description = $validated['description'] ?? null;
        $schedule->save();

        return redirect()->route('auth.others.seminar')
            ->with('success', 'Training schedule created successfully.');
    }
    private function getEventColor($trainingType)
    {
        $colors = [
            'Physical Training' => 'green',
            'Seminar' => 'blue',
            'Workshop' => 'red',
            'Conference' => 'yellow',
            'Assessment' => 'purple',
            // Add more types based on your actual training types
        ];

        return $colors[$trainingType] ?? 'gray';
    }
        public function edit($id)
    {
        $training = TrainingSchedule::findOrFail($id);
        return response()->json($training);
    }
            public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'trainingTitle' => 'required|string|max:255',
                'trainingType' => 'required|string|max:255',
                'startDate' => 'required|date',
                'startTime' => 'required',
                'endTime' => 'required|after:startTime',
                'trainer' => 'required|string|max:255',
                'facility' => 'required|string|max:255',
                'outsideCampusLocation' => 'required_if:facility,outside-campus|nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            $training = TrainingSchedule::findOrFail($id);

            // Save the old date to check if it was changed
            $oldDate = $training->start_date;

            $training->training_title = $validated['trainingTitle'];
            $training->training_type = $validated['trainingType'];
            $training->start_date = $validated['startDate'];
            $training->start_time = $validated['startTime'];
            $training->end_time = $validated['endTime'];
            $training->trainer = $validated['trainer'];
            $training->facility = $validated['facility'];
            $training->outside_campus_location = ($validated['facility'] === 'outside-campus') ?
                $validated['outsideCampusLocation'] : null;
            $training->description = $validated['description'] ?? null;
            $training->save();

            // Determine the redirect based on date change
            if ($oldDate !== $validated['startDate']) {
                // If date changed, redirect to the month view of the new date
                $newMonth = date('Y-m', strtotime($validated['startDate']));
                return redirect()->route('auth.others.seminar', ['month' => $newMonth])
                    ->with('success', 'Training schedule updated successfully.');
            }

            return redirect()->route('auth.others.seminar')
                ->with('success', 'Training schedule updated successfully.');
        }

        public function destroy($id)
    {
        try {
            $training = TrainingSchedule::findOrFail($id);
            $training->delete();

            return redirect()->route('trainings.index')
                ->with('success', 'Training schedule archived successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to archive training schedule: ' . $e->getMessage());
        }
}
    public function training_fetch_api()
    {
        $trainingSchedule = TrainingSchedule::all();
        return response()->json($trainingSchedule);
    }

    public function training_fetch_api_id($id)
{
    $trainingSchedule = TrainingSchedule::findOrFail($id);
    return response()->json($trainingSchedule);
}

}
