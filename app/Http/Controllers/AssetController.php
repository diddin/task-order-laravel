<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Asset::all();
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'validation_date' => 'nullable|date',
            'data_collection_time' => 'nullable|date',
            'location' => 'nullable|string',
            'code' => 'required|string|unique:assets,code',
            'name' => 'required|string',
            'label' => 'required|string',
            'object_type' => 'nullable|string',
            'construction_location' => 'nullable|string',
            'potential_problem' => 'nullable|string',
            'improvement_recomendation' => 'nullable|string',
            'detail_improvement_recomendation' => 'nullable|string',
            'pop' => 'nullable|string',
            'olt' => 'nullable|string',
            'number_of_ports' => 'integer|min:0',
            'number_of_registered_ports' => 'integer|min:0',
            'number_of_registered_labels' => 'integer|min:0',
        ]);

        $asset = Asset::create($validated);

        DB::transaction(function () use ($validated, $request, $asset) {
        
            if ($request->hasFile('images')) {
                foreach ((array) $request->file('images') as $image) {
                    if ($image) {
                        $path = $image->store('assets', 'public');
                        $asset->images()->create(['file_path' => $path]);
                    }
                }
            }
        });

        return redirect()->route('assets.show', $asset->id)
            ->with('success', 'Asset created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    { //dd($asset);
        //$asset = Asset::findOrFail($id);

        if(Auth::user()->role->name === 'technician') {
            return view('technician.assets.detail', compact('asset'));
        }

        return view('assets.detail', compact('asset'));
        //return Asset::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    { //dd('huhu', $request->all(), $request->file('images'));
        //$asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'validation_date' => 'sometimes|nullable|date',
            'data_collection_time' => 'sometimes|nullable|date',
            'location' => 'sometimes|nullable|string',
            'code' => 'sometimes|required|string|unique:assets,code,' . $asset->id,
            'name' => 'sometimes|required|string',
            'label' => 'sometimes|required|string',
            'object_type' => 'nullable|string',
            'construction_location' => 'nullable|string',
            'potential_problem' => 'nullable|string',
            'improvement_recomendation' => 'nullable|string',
            'detail_improvement_recomendation' => 'nullable|string',
            'pop' => 'nullable|string',
            'olt' => 'nullable|string',
            'number_of_ports' => 'integer|min:0',
            'number_of_registered_ports' => 'integer|min:0',
            'number_of_registered_labels' => 'integer|min:0',
        ]);

        // $asset->update($validated);

        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $image) {
        //         $path = $image->store('assets', 'public');

        //         $asset->images()->create([
        //             'file_path' => $path
        //         ]);
        //     }
        // }

        DB::transaction(function () use ($validated, $request, $asset) {
            $asset->update($validated); // atau create()
        
            if ($request->hasFile('images')) {
                foreach ((array) $request->file('images') as $image) {
                    if ($image) {
                        $path = $image->store('assets', 'public');
                        $asset->images()->create(['file_path' => $path]);
                    }
                }
            }

            if ($request->has('delete_images')) {
                $imageIdsToDelete = $request->input('delete_images');
                foreach ($asset->images()->whereIn('id', $imageIdsToDelete)->get() as $image) {
                    Storage::disk('public')->delete($image->file_path);
                    $image->delete();
                }
            }

        });

        return redirect()->route('assets.show', $asset->id)
            ->with('success', 'Asset updated successfully');

        //return $asset;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return response()->json(['message' => 'Asset deleted']);
    }
}
