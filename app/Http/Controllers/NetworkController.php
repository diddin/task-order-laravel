<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Customer;
use App\Http\Requests\Network\NetworkStoreRequest;
use App\Http\Requests\Network\NetworkUpdateRequest;
use Illuminate\Support\Facades\Auth;

class NetworkController extends Controller
{
    private $role;

    public function __construct(Auth $auth)
    {
        $this->role = $auth::user()->role->name;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $networks = Network::with('customer')->latest()->paginate(10);
        return view($this->role.'.networks.index', compact('networks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all(); // Untuk dropdown customer
        return view($this->role.'.networks.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NetworkStoreRequest $request)
    {
        Network::create($request->validated());
        return redirect()->route($this->role.'.networks.index')
            ->with('success', 'Jaringan '.$request->network_number .' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Network $network)
    {
        return view($this->role.'.networks.show', compact('network'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Network $network)
    {
        $customers = Customer::all();
        return view($this->role.'.networks.edit', compact('network', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NetworkUpdateRequest $request, Network $network)
    {
        $network->update($request->validated());
        return redirect()->route($this->role.'.networks.index')
            ->with('success', 'Jaringan '.$network->network_number .' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Network $network)
    {
        $network->delete();
        return redirect()->route($this->role.'.networks.index')
            ->with('success', 'Jaringan '.$network->network_number .' berhasil dihapus.');
    }
}
