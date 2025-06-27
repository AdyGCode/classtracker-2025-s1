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

use App\Models\Course;
use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreCoursesRequest;
use App\Http\Requests\v1\UpdateCoursesRequest;
use App\Http\Requests\v1\DeleteCoursesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * API Version 1 - CourseApiController
 */
class CourseApiController extends Controller
{

    /**
     *
     * A Paginated List of (all) Courses
     *
     * <ul>
     * <li>The courses are searchable.</li>
     * <li>Filter courses by SEARCH_TERM: <code>?search=SEARCH_TERM</code></li>
     * <li>The courses are paginated.</li>
     * <li>Jump to page PAGE_NUMBER per page: <code>page=PAGE_NUMBER</code></li>
     * <li>Provide COURSES_PER_PAGE per page: <code>perPage=COURSES_PER_PAGE</code></li>
     * <li>Example URI: <code>http://localhost:8000/api/v1/courses?search=ICT&page=2&perPage=15</code></li>
     * </ul>
     *
     * @param  Request  $request
     * @return JsonResponse
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
        $courseNumber = $request->perPage;
        // set search parameter
        $search = $request->search;

        $query = Course::query();

        $searchableFields = ['national_code', 'aqf_level', 'title', 'tga_status', 'state_code', 'nominal_hours', 'type', 'qa', 'nat_code', 'nat_title', 'nat_code_title'];

        if ($search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', '%' . $search . '%');
            }
        }

        //If there is no page, set to 6 items per page
        $courses = $query->paginate($courseNumber ?? 6);

        if ($courses->isNotEmpty()) {
            return ApiResponse::success($courses, "All Courses Found");
        }

        return ApiResponse::error([], "No Courses Found", 404);
    }

    /**
     * Display the specified Course.
     *
     * @param $id
     * @return JsonResponse
     * @unauthenticated
     */
    public function show($id): JsonResponse
    {
        $course = Course::find($id);

        if ($course) {
            return ApiResponse::success($course, "Specific Course Found");
        }

        return ApiResponse::error([], "Specific Course Not Found", 404);
    }


    /**
     * Create & Store a new Category resource.
     *
     * @param  StoreCoursesRequest  $request
     * @return JsonResponse
     */
    public function store(StoreCoursesRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['qa'] = $validated['qa'] ?? $validated['state_code'];
        $validated['nat_code'] = $validated['nat_code'] ?? $validated['national_code'];
        $validated['nat_title'] = $validated['nat_title'] ?? $validated['title'];
        $validated['nat_code_title'] = $validated['nat_code_title'] ?? "{$validated['nat_code']} {$validated['aqf_level']} {$validated['nat_title']}";

        $course = Course::create($validated);

        return ApiResponse::success($course, "Course added", 201);
    }

    /**
     * Update the specified Course resource.
     *
     * @param  UpdateCoursesRequest  $request
     * @param  Course  $course
     * @return JsonResponse
     */
    public function update(UpdateCoursesRequest $request, Course $course): JsonResponse
    {
        $validated = $request->validated();

        $validated['qa'] = $validated['qa'] ?? $validated['state_code'];
        $validated['nat_code'] = $validated['nat_code'] ?? $validated['national_code'];
        $validated['nat_title'] = $validated['nat_title'] ?? $validated['title'];
        $validated['nat_code_title'] = $validated['nat_code_title'] ?? "{$validated['nat_code']} {$validated['aqf_level']} {$validated['nat_title']}";

        $course->update($validated);

        return ApiResponse::success($course, "Course updated");
    }

    /**
     * Delete the specified Course from storage.
     *
     * @param  DeleteCoursesRequest  $request
     * @param $courseId
     * @return JsonResponse
     */
    public function destroy(DeleteCoursesRequest $request, $courseId): JsonResponse
    {
        $course = Course::find($courseId);

        if (!$course) {
            return ApiResponse::error($course, 'Specific Course Not Found', 404);
        }
        $course->delete();
        return ApiResponse::success($course, "Course deleted");
    }
}
