<?php

namespace App\Http\Controllers;

use App\Models\Clusters;
use App\Http\Requests\StoreClustersRequest;
use App\Http\Requests\UpdateClustersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        return view('clusters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'min:5', 'max:9', 'string',],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'qualification' => ['nullable', 'string', 'size:8'],
            'qualification_code' => ['nullable', 'string', 'size:4'],
            'unit_1' =>['nullable', 'string', 'size:9'],
            'unit_2' => ['nullable', 'string', 'size:9'],
            'unit_3' => ['nullable', 'string', 'size:9'],
            'unit_4' => ['nullable', 'string', 'size:9'],
            'unit_5' => ['nullable', 'string', 'size:9'],
            'unit_6' => ['nullable', 'string', 'size:9'],
            'unit_7' => ['nullable', 'string', 'size:9'],
            'unit_8' => ['nullable', 'string', 'size:9'],
        ]);


        Clusters::create($validated);

        return redirect()->route('clusters.index')
            ->with('success', 'Cluster created successfully');
    }


    /**
     * Display the specified resource.
     */

        public function show(string $id)
        {

            $cluster = Clusters::find($id);

            if ($cluster) {
                return view('clusters.show', compact(['cluster',]))
                    ->with('success', 'Cluster found');
            }

            return redirect(route('clusters.index'))
                ->with('warning', 'Cluster not found');
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clusters $cluster)
    {
        return view('clusters.edit', compact('cluster'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'code' => ['required', 'min:5', 'max:9', 'string',],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'qualification' => ['nullable', 'string', 'size:8'],
            'qualification_code' => ['nullable', 'string', 'size:4'],
            'unit_1' =>['nullable', 'string', 'size:9'],
            'unit_2' => ['nullable', 'string', 'size:9'],
            'unit_3' => ['nullable', 'string', 'size:9'],
            'unit_4' => ['nullable', 'string', 'size:9'],
            'unit_5' => ['nullable', 'string', 'size:9'],
            'unit_6' => ['nullable', 'string', 'size:9'],
            'unit_7' => ['nullable', 'string', 'size:9'],
            'unit_8' => ['nullable', 'string', 'size:9'],
        ]);

        Clusters::whereId($id)->update($validated);

        return redirect()->route('clusters.index')
            ->with('success', 'Cluster updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clusters $cluster)
    {
        $cluster->delete();
        return redirect()->route('clusters.index')
            ->with('success', 'Cluster deleted successfully');
    }

}
