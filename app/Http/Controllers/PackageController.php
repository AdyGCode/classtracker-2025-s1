<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use App\Http\Requests\StorePackagesRequest;
use App\Http\Requests\UpdatePackagesRequest;
use Illuminate\Http\Request;

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
        return view('packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(StorePackagesRequest $request)
    public function store(Request $request)

            {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'size:3'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',]
        ]);

        Packages::create($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully');
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
    public function edit(Packages $package)
    {
        return view('packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'size:3'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',]
        ]);

        Packages::whereId($id)->update($validated);

//        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Packages $package)
    {
        $package->delete();
        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully');
    }
}
