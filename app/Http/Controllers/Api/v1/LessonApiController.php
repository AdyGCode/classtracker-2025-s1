<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * API Version 1 - LessonApiController
 */
class LessonApiController extends Controller
{
    /**
     *
     * A Paginated List of (all) Lessons
     *
     * <ul>
     * <li>The lessons are searchable.</li>
     * <li>Filter lessons by SEARCH_TERM: <code>?search=SEARCH_TERM</code></li>
     * <li>The lessons are paginated.</li>
     * <li>Jump to page PAGE_NUMBER per page: <code>page=PAGE_NUMBER</code></li>
     * <li>Provide LESSONS_PER_PAGE per page: <code>perPage=LESSONS_PER_PAGE</code></li>
     * <li>Example URI: <code>https://classtrack.screencraft.net.au/api/v1/lessons?search=ICT&page=2&perPage=15</code></li>
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

        $lessonNumber = $request->perPage;
        $search = $request->search;

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

        if ($data->isEmpty()) {
            return ApiResponse::error([], 'No Lessons Found', 404);
        }

        return ApiResponse::success($data, "All lessons found successfully.");
    }

    /**
     * Store a newly created resource in storage.
     * @param  StoreLessonRequest  $request
     * @return JsonResponse
     */
    public function store(StoreLessonRequest $request): JsonResponse
    {
//        $lesson = Lesson::create($request->validated());
        $input = $request->validated();
        // Create the lesson
        $lesson = Lesson::create($input);

        // Synchronizing staff and students with the lesson
        $staffIds = $request->input('staff_ids', []);
        $studentIds = $request->input('student_ids', []);
        $allUserIds = array_unique(array_merge($staffIds, $studentIds));

        // Sync the users (staff and students) with the lesson
        $lesson->users()->sync($allUserIds);
        $lesson->load('staff', 'students');
        return ApiResponse::success($lesson, "Lesson created successfully.", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     *
     * @unauthenticated
     */
    public function show(int $id): JsonResponse
    {
        $lesson = Lesson::with(['staff', 'students'])->findOrFail($id);

        return ApiResponse::success($lesson, "Lesson retrieved successfully.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLessonRequest  $request
     * @param  Lesson  $lesson
     * @return JsonResponse
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson): JsonResponse
    {
        $input = $request->validated();

        // Update the lesson
        $lesson->update($input);

        // Synchronizing staff and students with the lesson
        $staffIds = $request->input('staff_ids', []);
        $studentIds = $request->input('student_ids', []);
        $allUserIds = array_unique(array_merge($staffIds, $studentIds));

        // Sync the users (staff and students) with the lesson
        $lesson->users()->sync($allUserIds);

        return ApiResponse::success($lesson, "Lesson updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Lesson  $lesson
     * @return JsonResponse
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        $lesson->delete();
        return ApiResponse::success(null, "Lesson deleted successfully.");
    }
}
