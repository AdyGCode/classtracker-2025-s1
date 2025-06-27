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
use App\Models\Package;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class PackageController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function index()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff')) {
            return redirect('/')->with('error', 'Unauthorised to access this page.');
        }

        $packages = Package::paginate(10);

        return view('packages.index', compact(['packages']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function create()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to create package!');
        }

        // This is to display in the package creation form, allowing the user to associate courses with the new package.
        $courses = Course::all();

        return view('packages.create',compact(['courses']));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}$/', 'unique:packages,national_code,'],
            'title' => ['required', 'min:2', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
        ]);

        $package = Package::create($validated);

        //Loop each course id and find specific course, and then update the course's package id field.
        foreach ($request->course_ids as $course_id) {
            $course = Course::whereId($course_id);
            $course->update(['package_id' => $package->id]);
        }

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully');
    }

    /**
     * Search resources in storage.
     * @param  Request  $request
     * @return Factory|View|Application|object
     */
    public function search(Request $request)
    {
        // set search parameter
        $search = $request->input('keywords');

        $query = Package::with('courses');

        $searchableFields = ['national_code', 'title', 'tga_status'];

        if ($search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', '%' . $search . '%')
                    ->orWhereHas('courses', function($query) use ($search) {
                    $query->where('national_code', 'like', '%' . $search . '%');
                    });
            }
        }

        //If there is no page, set to 6 items per page
        $packages = $query->paginate($packageNumber ?? 6);

        return view('packages.index', compact('packages'));
    }

    /**
     * Display the specified resource.
     * @param  Package  $package
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function show(Package $package)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff')) {
            return redirect('/')->with('error', 'Unauthorised to view package!');
        }

        // the method retrieves the courses associated with the specified package:
        // This leverages Laravel's Eloquent relationships to access the related courses for the given package.
        $courses = $package->courses;

            if ($package) {
                return view('packages.show', compact(['package', 'courses']))
                    ->with('success', 'Package found');
            }

            return redirect(route('packages.index'))
                ->with('warning', 'Package not found');
    }


    /**
     * Show the form for editing the specified resource.
     * @param  Package  $package
     * @return Factory|View|Application|RedirectResponse|Redirector|object
     */
    public function edit(Package $package)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to edit package!');
        }

        $courses = Course::all();
        return view('packages.edit', compact('package', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request  $request
     * @param  string  $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $package = Package::findOrFail($id);

        $validated = $request->validate([
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}$/', 'unique:packages,national_code,' . $package->id],
            'title' => ['required', 'min:2', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
        ]);

        // This retrieves all Course instances currently associated with the package:
        $oldCourses = Course::where('package_id', $package->id)->get();
        // and remove old ones that have been set previously.
        foreach ($oldCourses as $oldCourse) {
            $oldCourse->update(['package_id' => null]);
        }

        //Loop each course id and find specific course, and then update the course's package id field.
        foreach ($request->course_ids as $course_id) {
            $course = Course::whereId($course_id);
            $course->update(['package_id' => $package->id]);
        }

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param  Package  $package
     * @return Application|RedirectResponse|Redirector|object
     */
    public function destroy(Package $package)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to delete package!');
        }

        $package->delete();
        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully');
    }
}
