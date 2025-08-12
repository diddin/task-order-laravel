<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        //$customers = Customer::latest()->paginate(10);
        $customers = Customer::orderByRaw("id = 1 DESC")
                         ->orderBy('name', 'asc')
                         ->paginate(10);
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

        Log::info('Customer added', ['name' => $request->name, 'user' => Auth::user()?->id]);

        return redirect()->route($this->role.'.customers.index')
            ->with('success', 'Data Pelanggan '.$request->name.' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['tasks.assignedUsers']);
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

        Log::info('Customer updated', ['name' => $customer->name, 'user' => Auth::user()?->id]);

        return redirect()->route($this->role.'.customers.index')
            ->with('success', 'Data Pelanggan '.$customer->name.' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $name = $customer->name; // Simpan dulu sebelum dihapus
        $customer->delete();

        return redirect()->route($this->role . '.customers.index')
            ->with('success', 'Data Pelanggan ' . $name . ' berhasil dihapus.');
    }

    public function restore($id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()->route($this->role . '.customers.index')
            ->with('success', 'Data Pelanggan ' . $customer->name . ' berhasil dikembalikan.');
    }

    public function ajaxSearch(Request $request)
    {
        $search = strtolower($request->get('q'));

        $customers = Customer::whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
            ->orWhereRaw('LOWER(contact_person) LIKE ?', ["%{$search}%"])
            ->orWhereRaw('LOWER(address) LIKE ?', ["%{$search}%"])
            ->orWhereRaw('LOWER(network_number) LIKE ?', ["%{$search}%"])
            ->orWhereRaw('LOWER(technical_data) LIKE ?', ["%{$search}%"])
            ->orWhereRaw('LOWER(cluster) LIKE ?', ["%{$search}%"])
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'network_number']);

        return response()->json($customers);
    }
}
