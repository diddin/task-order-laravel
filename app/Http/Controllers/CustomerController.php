<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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
        $customers = Customer::latest()->paginate(10);
        return view($this->role.'.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->role.'.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        Customer::create($request->validated());
        return redirect()->route($this->role.'.customers.index')
            ->with('success', 'Data Pelanggan '.$request->name.' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['networks.tasks.assignedUsers']);
        return view($this->role.'.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view($this->role.'.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return redirect()->route($this->role.'.customers.index')
            ->with('success', 'Data Pelanggan '.$customer->name.' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route($this->role.'.customers.index')
            ->with('success', 'Data Pelanggan '.$customer->name.' berhasil dihapus.');
    }
}
