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

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\DeletePackagesRequest;
use App\Http\Requests\v1\StorePackagesRequest;
use App\Http\Requests\v1\UpdatePackagesRequest;
use App\Models\Course;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * API Version 1 - PackageApiController
 */
class PackageApiController extends Controller
{

    /**
     *
     * A Paginated List of (all) Packages
     *
     * <ul>
     * <li>The packages are searchable.</li>
     * <li>Filter packages by SEARCH_TERM: <code>?search=SEARCH_TERM</code></li>
     * <li>The packages are paginated.</li>
     * <li>Jump to page PAGE_NUMBER per page: <code>page=PAGE_NUMBER</code></li>
     * <li>Provide PACKAGES_PER_PAGE per page: <code>perPage=PACKAGES_PER_PAGE</code></li>
     * <li>Example URI: <code>http://localhost:8000/api/v1/packages?search=ICT&page=1&perPage=15</code></li>
     * </ul>
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @unauthenticated
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'page' => ['nullable', 'integer'],
            'perPage' => ['nullable', 'integer'],
            'search' => ['nullable', 'string'],
        ]);

        // set perPage parameter and specific number per page
        $packageNumber = $request->perPage;
        // set search parameter
        $search = $request->search;

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

        if ($packages->isNotEmpty()) {
            return ApiResponse::success($packages, "All Packages Found");
        }

        return ApiResponse::error([], "No Packages Found", 404);
    }


    /**
     * Display the specified Package.
     * @param $id
     * @return JsonResponse
     *
     * @unauthenticated
     */
    public function show($id): JsonResponse
    {
        $package = Package::with('courses')->find($id);
        if ($package) {
            return ApiResponse::success($package, "Specific Package Found");
        }

        return ApiResponse::error([], "Specific Package Not Found", 404);
    }


    /**
     * Create & Store a new Package resource.
     *
     * @param  StorePackagesRequest  $request
     * @return JsonResponse
     */
    public function store(StorePackagesRequest $request): JsonResponse
    {
        $package = Package::create($request->validated());

        //Loop each course id and find specific course, and then update the course's package id field.
        if ($request->filled('course_ids')) {
            foreach ($request->course_ids as $course_id) {
                $course = Course::find($course_id);
                $course->update(['package_id' => $package->id]);
            }
        }
        //Load the courses relationship
        $package->load('courses');

        return ApiResponse::success($package, "Package Added", 201);
    }

    /**
     * Update the specified Package resource.
     *
     * @param  UpdatePackagesRequest  $request
     * @param  Package  $package
     * @return JsonResponse
     */
    public function update(UpdatePackagesRequest $request, Package $package): JsonResponse
    {
        $package->update($request->validated());

        // Get the specific package id field and remove old ones that have been set previously.
        $oldCourses = Course::where('package_id', $package->id)->get();
        foreach ($oldCourses as $oldCourse) {
            $oldCourse->update(['package_id' => null]);
        }
        //Loop each course id and find specific course, and then update the course's package id field.
        if ($request->filled('course_ids')) {
            foreach ($request->course_ids as $course_id) {
                $course = Course::find($course_id);
                $course->update(['package_id' => $package->id]);
            }
        }

        //Load the courses relationship
        $package->load('courses');

        return ApiResponse::success($package, "Package Updated");
    }

    /**
     * Delete the specified Package from storage.
     * @param  DeletePackagesRequest  $request
     * @param $packageId
     * @return JsonResponse
     */
    public function destroy(DeletePackagesRequest $request, $packageId): JsonResponse
    {
        $package = Package::find($packageId);

        if (!$package) {
            return ApiResponse::error($package, 'Specific Package Not Found', 404);
        }
        $package->delete();
        return ApiResponse::success($package, "Package Deleted");
    }

}
