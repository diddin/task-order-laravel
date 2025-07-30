<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Task;
use App\Models\Network;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Asset\AssetStoreRequest;
use App\Http\Requests\Asset\AssetUpdateRequest;


class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::all();

        return response()->json([
            'status' => 'success',
            'data' => $assets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $networkId = $request->query('network');
        $network = Network::findOrFail($networkId);
        $asset = new Asset();

        $portGroups = [
            ['start' => 1, 'end' => 12],
            ['start' => 13, 'end' => 24],
            ['start' => 25, 'end' => 44],
            ['start' => 45, 'end' => 48],
            ['start' => 49, 'end' => 96],
        ];

        return view('assets.create', compact('network', 'asset', 'portGroups'));

        //return view(Auth::user()->role->name.'.assets.create', compact('network', 'asset', 'portGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssetStoreRequest $request)
    {
        $validated = $request->validated();

        $assetId = null;

        DB::transaction(function () use ($validated, $request, &$assetId) {

            $asset = Asset::create($validated);
            $assetId = $asset->id;
        
            if ($request->hasFile('images')) {
                foreach ((array) $request->file('images') as $image) {
                    if ($image) {
                        $path = $image->store('asset_images', 'public');
                        $asset->images()->create(['image_path' => $path]);
                    }
                }
            }

            // Simpan data port dan jumper (asumsi array input)
            $dataPorts = $request->input('data_port', []);
            $jumpers = $request->input('jumper', []);

            foreach ($dataPorts as $index => $port) {
                $jumper = $jumpers[$index] ?? null; // cek kalau ada jumper di index ini

                if ($port && $jumper) {
                    $asset->ports()->create([
                        'port' => $port,
                        'jumper_id' => $jumper,
                    ]);
                }
            }
        });

        return redirect()->route('assets.edit', $assetId)
            ->with('success', 'Data Aset Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset, Task $task)
    {
        $portGroups = [
            ['start' => 1, 'end' => 12],
            ['start' => 13, 'end' => 24],
            ['start' => 25, 'end' => 44],
            ['start' => 45, 'end' => 48],
            ['start' => 49, 'end' => 96],
        ]; // echo "<pre>"; print_r($asset->images->toArray()); echo "</pre>"; die();

        return response()->json([
            'status' => 'success',
            'data' => [ 
                'asset' => $asset,
                'task' => $task,
                'portGroups' => $portGroups,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $portGroups = [
            ['start' => 1, 'end' => 12],
            ['start' => 13, 'end' => 24],
            ['start' => 25, 'end' => 44],
            ['start' => 45, 'end' => 48],
            ['start' => 49, 'end' => 96],
        ]; //echo "<pre>"; print_r($portsWithJumper->toArray()); echo "</pre>"; die();
        
        return view('assets.edit', compact('asset', 'portGroups'));
    }

    /**
     * Update the specified resource in storage. Request 
     */
    public function update(AssetUpdateRequest $request, Asset $asset)
    {
        //echo "<pre>"; print_r($request->all()); echo "</pre>"; die();

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $asset) {
        
            if ($request->hasFile('images')) {
                foreach ((array) $request->file('images') as $image) {
                    if ($image) {
                        $path = $image->store('asset_images', 'public');
                        $asset->images()->create(['image_path' => $path]);
                    }
                }
            }

            $asset->update($validated); // atau create()

            if ($request->has('delete_images')) {
                $imageIdsToDelete = $request->input('delete_images');
                foreach ($asset->images()->whereIn('id', $imageIdsToDelete)->get() as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            // Update ports dan jumpers
            $dataPorts = $request->input('data_port', []);
            $jumpers = $request->input('jumper', []);

            // Hapus dulu semua port terkait asset
            $asset->ports()->delete();

            foreach ($dataPorts as $index => $port) {
                $jumper = $jumpers[$index] ?? 0;
                if ($port != 0 && $jumper != 0) {
                    $asset->ports()->create([
                        'port' => $port,
                        'jumper_id' => $jumper,
                    ]);
                }
            }
        });

        return redirect()->route('assets.edit', $asset->id)
            ->with('success', 'Aset '.$asset->name.' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return response()->json(['message' => 'Asset berhasil dihapus']);
    }
}
