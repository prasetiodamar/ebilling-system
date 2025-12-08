<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display all invoices (paginated)
     */
    public function index(Request $request)
    {
        $invoices = Invoice::query()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->customer_id, fn($q) => $q->where('customer_id', $request->customer_id))
            ->when($request->search, fn($q) => $q->where('invoice_number', 'like', "%{$request->search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return $this->paginatedResponse($invoices);
    }

    /**
     * Store a new invoice
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:invoices',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Calculate total_amount
        $subtotal = $validated['subtotal'];
        $tax = $validated['tax'] ?? 0;
        $discount = $validated['discount'] ?? 0;
        $validated['total_amount'] = $subtotal + $tax - $discount;

        $invoice = Invoice::create($validated);

        return $this->successResponse($invoice, 'Invoice created successfully', 201);
    }

    /**
     * Display an invoice
     */
    public function show(Invoice $invoice)
    {
        return $this->successResponse($invoice->load(['customer', 'payments']));
    }

    /**
     * Update an invoice
     */
    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return $this->errorResponse('Only draft invoices can be updated', 422);
        }

        $validated = $request->validate([
            'due_date' => 'date',
            'subtotal' => 'numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Recalculate total if amounts changed
        if (isset($validated['subtotal']) || isset($validated['tax']) || isset($validated['discount'])) {
            $subtotal = $validated['subtotal'] ?? $invoice->subtotal;
            $tax = $validated['tax'] ?? $invoice->tax ?? 0;
            $discount = $validated['discount'] ?? $invoice->discount ?? 0;
            $validated['total_amount'] = $subtotal + $tax - $discount;
        }

        $invoice->update($validated);

        return $this->successResponse($invoice, 'Invoice updated successfully');
    }

    /**
     * Delete an invoice
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return $this->errorResponse('Only draft invoices can be deleted', 422);
        }

        $invoice->delete();

        return $this->successResponse(null, 'Invoice deleted successfully');
    }

    /**
     * Get invoices by customer
     */
    public function byCustomer($customer)
    {
        $invoices = Invoice::where('customer_id', $customer)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return $this->paginatedResponse($invoices);
    }

    /**
     * Send invoice
     */
    public function send(Invoice $invoice)
    {
        if ($invoice->status === 'sent' || $invoice->status === 'paid') {
            return $this->errorResponse('Invoice already sent', 422);
        }

        $invoice->markAsSent();

        return $this->successResponse($invoice, 'Invoice sent successfully');
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($invoice->status === 'paid') {
            return $this->errorResponse('Invoice already paid', 422);
        }

        $invoice->markAsPaid($validated['amount']);

        return $this->successResponse($invoice, 'Invoice payment recorded successfully');
    }

    /**
     * Cancel invoice
     */
    public function cancel(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return $this->errorResponse('Cannot cancel paid invoice', 422);
        }

        $invoice->cancel();

        return $this->successResponse($invoice, 'Invoice cancelled successfully');
    }
}
