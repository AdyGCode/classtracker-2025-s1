<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClustersRequest;
use App\Http\Requests\UpdateClustersRequest;
use App\Models\Cluster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClusterApiController extends Controller
{
    /**
     * A Paginated List of (all) Clusters
     *
     * <ul>
     * <li>The clusters are searchable.</li>
     * <li>Filter clusters by SEARCH_TERM: <code>search=SEARCH_TERM</code></li>
     * <li>The clusters are paginated.</li>
     * <li>Jump to page PAGE_NUMBER: <pre>page=PAGE_NUMBER</pre></li>
     * <li>Provide CLUSTERS_PER_PAGE per page: <pre>perPage=CLUSTERS_PER_PAGE</pre></li>
     * <li>Example URI: <code>http:\/\/localhost:8000/api/v1/clusters?search=ICT&page=2&perPage=15</code></li>
     * </ul>
     *
     * @unauthenticated
     */
    public function index(Request $request): JsonResponse
    {

        $request->validate([
            'page' => ['nullable', 'integer'],
            'perPage' => ['nullable', 'integer'],
            'search' => ['nullable','string'],
        ]);

        $clusterNumber = $request->perPage;
        $search = $request->search;

        $query = Cluster::query();

        $searchableFields = ['cluster', 'code', 'title', 'qualification', 'qualification_code' ];

        if ($search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', '%' . $search . '%');
            }
        }

        $clusters = $query->paginate($clusterNumber ?? 6);

        if ($clusters->isNotEmpty()) {
            return ApiResponse::success($clusters, 'All Clusters Found', 201);
        }

        return ApiResponse::error([], 'No Clusters Found', 404);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreClustersRequest $request
     * @return JsonResponse
     */
    public function store(StoreClustersRequest $request): JsonResponse
    {

        $validated = $request->validated();

        $validated['qualification'] = $validated['qualification'] ?? null;
        $validated['qualification_code'] = $validated['qualification_code'] ?? null;

        $cluster = Cluster::create($validated);

        return ApiResponse::success($cluster, 'Cluster added', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     * @unauthenticated
     */
    public function show($id): JsonResponse
    {

        $cluster = Cluster::find($id);

        if ($cluster) {
            return ApiResponse::success($cluster, 'Cluster Found', 201);
        }

        return ApiResponse::error([], 'Specific Cluster Not Found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClustersRequest $request
     * @param Cluster $cluster
     * @return JsonResponse
     */
    public function update(UpdateClustersRequest $request, Cluster $cluster): JsonResponse
    {
        $validated = $request->validated();

        $validated['qualification'] = $validated['qualification'] ?? null;
        $validated['qualification_code'] = $validated['qualification_code'] ?? $validated['qualification'];

        $cluster->update($validated); // Why create, the cluster is updated not created

        return ApiResponse::success($cluster, 'Cluster Updated', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $clusterId
     * @return JsonResponse
     */
    public function destroy($clusterId): JsonResponse
    {
        $cluster = Cluster::find($clusterId);

        if (!$cluster) {
            return ApiResponse::error([], 'Specific Cluster Not Found', 404);
        }
        $cluster->delete();
        return ApiResponse::success([], 'Cluster deleted', 201);
    }
}
