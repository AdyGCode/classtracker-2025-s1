<?php
/**
 * Assessment Title: Portfolio Part 1
 * Cluster:          SaaS - BED: APIs & NoSQL - 2025 S1
 * Qualification:    ICT50220 (Advanced Programming)
 * Name:             Yui Migaki
 * Student ID:       20098757
 * Year/Semester:    2025/S1
 *
 * YOUR SUMMARY OF PORTFOLIO ACTIVITY
 * This portfolio work was conducted within a team called classTracker with 4 people.
 * I contributed by adding features for courses and packages as well as APIs for those features.
 * This project includes implementing a REST API and a management interface to create a new “Student Tracking” system.
 */

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function index()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff|Student')) {
            return redirect('/')->with('error', 'Unauthorised to access this page.');
        }

        $courses = Course::paginate(6);
        return view('courses.index', compact(['courses', ]));
    }


    /**
     * Show the form for creating a new resource.
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function create()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to create courses.');
        }
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}\d{5}$/', 'unique:courses'],
            'aqf_level' => ['required', 'min:5', 'max:255', 'string',],
            'title' => ['required', 'min:2', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
            'state_code' => ['required', 'string', 'size:4', 'unique:courses'],
            'nominal_hours' => ['required', 'min:1', 'max:2000', 'numeric',],
            'type' => ['required', 'min:5', 'max:255', 'string',],
            'qa' => ['sometimes', 'nullable','string', 'size:4', 'unique:courses'],
            'nat_code' => ['sometimes', 'nullable','string', 'regex:/^[A-Z]{3}\d{5}$/', 'unique:courses'],
            'nat_title' => ['sometimes', 'nullable','min:2', 'max:255', 'string',],
            'nat_code_title' => ['sometimes','nullable','min:5', 'max:255', 'string',],
        ]);


        $validated['qa'] = $validated['qa'] ?? $validated['state_code'];
        $validated['nat_code'] = $validated['nat_code'] ?? $validated['national_code'];
        $validated['nat_title'] = $validated['nat_title'] ?? $validated['title'];
        $validated['nat_code_title'] = $validated['nat_code_title'] ?? "{$validated['nat_code']} {$validated['aqf_level']} {$validated['nat_title']}";


        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully');
    }
    public function search(Request $request)
    {
        $request->validate([
            'page' => ['nullable', 'integer'],
            'perPage' => ['nullable', 'integer'],
            'search' => ['nullable', 'string'],
        ]);

        // set perPage parameter and specific number per page
        $courseNumber = $request->perPage;
        // set search parameter
        $search = $request->input('keywords');

        $query = Course::query();

        $searchableFields = ['national_code', 'aqf_level', 'title', 'tga_status', 'state_code', 'nominal_hours', 'type', 'qa', 'nat_code', 'nat_title', 'nat_code_title'];

        if ($search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', '%' . $search . '%');
            }
        }

        //If there is no page, set to 6 items per page
        $courses = $query->paginate($courseNumber ?? 6);

        return view('courses.index', compact('courses'));
    }

    /**
     * Display the specified resource.
     * @param  string  $id
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function show(string $id)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff|Student')) {
            return redirect('/')->with('error', 'Unauthorised to view course details.');
        }

        $course = Course::whereId($id)->get()->first();

        if ($course) {
            return view('courses.show', compact(['course',]))
                ->with('success', 'Course found')
                ;
        }

        return redirect(route('courses.index'))
            ->with('warning', 'Course not found');
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Course  $course
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function edit(Course $course)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to edit courses.');
        }

        return view('courses.edit', compact('course'));

    }

    /**
     * Update the specified resource in storage.
     * @param  Request  $request
     * @param  string  $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}\d{5}$/', 'unique:courses,national_code,' . $course->id],
            'aqf_level' => ['required', 'min:5', 'max:255', 'string',],
            'title' => ['required', 'min:2', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
            'state_code' => ['required', 'string', 'size:4', 'unique:courses,state_code,' . $course->id],
            'nominal_hours' => ['required', 'min:1', 'max:2000', 'numeric',],
            'type' => ['required', 'min:5', 'max:255', 'string',],
            'qa' => ['sometimes', 'nullable','string', 'size:4', 'unique:courses,qa,' . $course->id],
            'nat_code' => ['sometimes', 'nullable','string', 'regex:/^[A-Z]{3}\d{5}$/', 'unique:courses,nat_code,' . $course->id],
            'nat_title' => ['sometimes', 'nullable','min:2', 'max:255', 'string',],
            'nat_code_title' => ['sometimes','nullable','min:5', 'max:255', 'string',],
        ]);

        $validated['qa'] = $validated['qa'] ?? $validated['state_code'];
        $validated['nat_code'] = $validated['nat_code'] ?? $validated['national_code'];
        $validated['nat_title'] = $validated['nat_title'] ?? $validated['title'];
        $validated['nat_code_title'] = $validated['nat_code_title'] ?? "{$validated['nat_code']} {$validated['aqf_level']} {$validated['nat_title']}";


        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param  Course  $course
     * @return Application|RedirectResponse|Redirector|object
     */
    public function destroy(Course $course)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to delete courses.');
        }

        $course->delete();
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
