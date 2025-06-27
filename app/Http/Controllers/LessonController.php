<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff|Student')) {
            return redirect('/')->with('error', 'Unauthorised to access this page.');
        }
        $data = Lesson::orderBy('name', 'asc')->paginate(6);
        return view('lessons.index', compact(['data']));
    }

    public function search(Request $request)
    {
        $request->validate([
            'page' => ['nullable', 'integer'],
            'perPage' => ['nullable', 'integer'],
            'search' => ['nullable', 'string'],
        ]);

        $lessonNumber = $request->input('perPage', 6);
        $search = $request->input('keywords');

        $query = Lesson::query();

        $searchableFields = ['course_id', 'cluster_id', 'name', 'start_date', 'end_date', 'weekday', 'duration'];

        if ($search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', '%' . $search . '%');
            }
        }

        $data = $query
            ->with(['staff', 'students'])
            ->orderBy('name', 'asc')
            ->paginate($lessonNumber ?? 6);

        return view('lessons.index', compact(['data']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Lesson $lesson)
    {
        $clusters = Cluster::all();
        $staffs = User::whereHas('staff')->get();
        $students = User::whereHas('student')->get();

         if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to create lesson.');
        }
        return view('lessons.create', compact(['clusters', 'staffs', 'students', 'lesson']));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, Lesson $lesson)
    {
        $input = $request->validated();

        if (!empty($input['start_time'])) {
            $input['start_time'] = Carbon::createFromFormat('H:i', $input['start_time'])->format('H:i');
        }

        $lesson = Lesson::create($input);

        // Synchronising associated users
        $staffIds = $request->input('staff_ids', []);
        $studentIds = $request->input('student_ids', []);
        $allUserIds = array_unique(array_merge($staffIds, $studentIds));

        $lesson->users()->sync($allUserIds);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff|Student')) {
            return redirect('/')->with('error', 'Unauthorised to view lesson.');
        }

        $lesson = Lesson::with(['staff','students',])->where('id',$lesson->id)->first();
//        dd($lesson);
     return view('lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $clusters = Cluster::all();
        $staffs = User::whereHas('staff')->get();
        $students = User::whereHas('student')->get();

        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to edit lesson.');
        }

        return view('lessons.edit', compact(['lesson', 'clusters', 'students', 'staffs']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $input = $request->validated();
        if (!empty($input['start_time'])) {
            $input['start_time'] = Carbon::createFromFormat('H:i', $input['start_time'])->format('H:i');
        }

        $lesson->update($input);

        // Synchronising associated users
        $staffIds = $request->input('staff_ids', []);
        $studentIds = $request->input('student_ids', []);
        $allUserIds = array_unique(array_merge($staffIds, $studentIds));

        $lesson->users()->sync($allUserIds);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to delete lesson.');
        }
        $lesson->delete();
        return redirect()->route('lessons.index')
            ->with('success', 'Lesson deleted successfully');
    }
}
