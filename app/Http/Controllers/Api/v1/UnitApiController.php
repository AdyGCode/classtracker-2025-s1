<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Requests\StoreUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $unitNumber = $request->PerPage ?? 10;
        $search = $request->search;

        $query = Unit::query();

        $searchableFields = [
            'unit', 'national_code', 'aqf_level', 'title',
            'tga_status', 'state_code', 'nominal_hours', 'type', 'qa'
        ];

        if ($search) {
            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', '%' . $search . '%');
                }
            });
        }

        $units = $query->paginate($unitNumber);

        if ($units->isEmpty()) {
            return ApiResponse::error([], "No units found", 404);
        }

        return ApiResponse::success($units, "All units found");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitsRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['tga_status'] = $validated['tga_status'] ?? null;
        $validated['state_code'] = $validated['state_code'] ?? null;
        $validated['nominal_hours'] = $validated['nominal_hours'] ?? null;
        $validated['title'] = $validated['title'] ?? null;
        $validated['unit'] = $validated['unit'] ?? null;

        $unit = Unit::create($validated);

        return ApiResponse::success($unit, "Unit created", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $unit = Unit::find($id);

        if ($unit) {
            return ApiResponse::success($unit, "Unit found");
        }

        return ApiResponse::error([], "No unit found", 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitsRequest $request, Unit $unit): JsonResponse
    {
        $validated = $request->validated();

        $validated['tga_status'] = $validated['tga_status'] ?? null;
        $validated['state_code'] = $validated['state_code'] ?? null;
        $validated['nominal_hours'] = $validated['nominal_hours'] ?? null;
        $validated['title'] = $validated['title'] ?? null;
        $validated['unit'] = $validated['unit'] ?? null;

        $unit->update($validated);

        return ApiResponse::success($unit, "Unit updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return ApiResponse::error([], "Unit not found", 404);
        }

        $unit->delete();

        return ApiResponse::success([], "Unit deleted");
    }
}
