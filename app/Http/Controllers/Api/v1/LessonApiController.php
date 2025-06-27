<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LessonApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     *
     * @unauthenticated
     */
    public function index(): JsonResponse
    {
        $data = Lesson::with(['staff', 'students'])
            ->orderBy('name', 'asc')
            ->paginate(6);

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
     * @param  Lesson  $lesson
     * @return JsonResponse
     *
     * @unauthenticated
     */
    public function show(Lesson $lesson): JsonResponse
    {
        $lesson = Lesson::with(['staff', 'students'])->findOrFail($lesson->id);
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
