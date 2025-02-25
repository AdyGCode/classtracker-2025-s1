<?php

namespace App\Http\Controllers;

use App\Models\Clusters;
use App\Http\Requests\StoreClustersRequest;
use App\Http\Requests\UpdateClustersRequest;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clusters = Clusters::paginate(6);
        return view('clusters.index', compact(['clusters', ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClustersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

        public function show(string $id)
        {

            $cluster = Clusters::whereId($id)->get()->first();

            if ($cluster) {
                return view('clusters.show', compact(['cluster',]))
                    ->with('success', 'Cluster found')
            ;
            }

            return redirect(route('clusters.index'))
                ->with('warning', 'Cluster not found');
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clusters $clusters)
    {
        return view('clusters.edit', compact('clusters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClustersRequest $request, Clusters $clusters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clusters $clusters)
    {
        //
    }
}
