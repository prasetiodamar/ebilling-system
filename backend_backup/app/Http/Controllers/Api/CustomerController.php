<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display all customers (paginated)
     */
    public function index(Request $request)
    {
        $customers = Customer::query()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->payment_status, fn($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->search, fn($q) => $q->where('full_name', 'like', "%{$request->search}%")
                ->orWhere('customer_number', 'like', "%{$request->search}%"))
            ->paginate($request->per_page ?? 15);

        return $this->paginatedResponse($customers);
    }

    /**
     * Store a new customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_number' => 'required|unique:customers',
            'full_name' => 'required|string',
            'package_type' => 'required|in:basic,standard,premium',
            'monthly_fee' => 'required|numeric|min:0',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $customer = Customer::create($validated);

        return $this->successResponse($customer, 'Customer created successfully', 201);
    }

    /**
     * Display a customer
     */
    public function show(Customer $customer)
    {
        return $this->successResponse($customer->load(['user', 'invoices', 'payments']));
    }

    /**
     * Update a customer
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'full_name' => 'string',
            'package_type' => 'in:basic,standard,premium',
            'monthly_fee' => 'numeric|min:0',
            'phone' => 'string',
            'address' => 'string',
            'city' => 'string',
            'province' => 'string',
            'postal_code' => 'string',
            'status' => 'in:active,inactive,suspended,disconnected',
            'payment_status' => 'in:paid,pending,overdue',
        ]);

        $customer->update($validated);

        return $this->successResponse($customer, 'Customer updated successfully');
    }

    /**
     * Delete a customer
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return $this->successResponse(null, 'Customer deleted successfully');
    }

    /**
     * Get customer invoices
     */
    public function invoices(Customer $customer)
    {
        $invoices = $customer->invoices()->paginate(15);

        return $this->paginatedResponse($invoices, 'Customer invoices retrieved');
    }

    /**
     * Get customer payments
     */
    public function payments(Customer $customer)
    {
        $payments = $customer->payments()->paginate(15);

        return $this->paginatedResponse($payments, 'Customer payments retrieved');
    }

    /**
     * Suspend a customer
     */
    public function suspend(Customer $customer)
    {
        $customer->update(['status' => 'suspended']);

        return $this->successResponse($customer, 'Customer suspended successfully');
    }

    /**
     * Activate a customer
     */
    public function activate(Customer $customer)
    {
        $customer->update(['status' => 'active']);

        return $this->successResponse($customer, 'Customer activated successfully');
    }
}
