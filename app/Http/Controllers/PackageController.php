<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use App\Http\Requests\StorePackagesRequest;
use App\Http\Requests\UpdatePackagesRequest;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Packages::paginate(10);
        return view('packages.index', compact(['packages', ]));
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
    public function store(StorePackagesRequest $request)
    {
      //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        {

            $package = Packages::whereId($id)->get()->first();

            if ($package) {
                return view('packages.show', compact(['package',]))
                    ->with('success', 'Package found')
                    ;
            }

            return redirect(route('packages.index'))
                ->with('warning', 'Package not found');
        }    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Packages $packages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackagesRequest $request, Packages $packages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Packages $packages)
    {
        //
    }
}
