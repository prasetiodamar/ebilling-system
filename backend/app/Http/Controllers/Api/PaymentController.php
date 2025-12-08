<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display all payments (paginated)
     */
    public function index(Request $request)
    {
        $payments = Payment::query()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->customer_id, fn($q) => $q->where('customer_id', $request->customer_id))
            ->when($request->payment_gateway, fn($q) => $q->where('payment_gateway', $request->payment_gateway))
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return $this->paginatedResponse($payments);
    }

    /**
     * Store a new payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_number' => 'required|unique:payments',
            'payment_method' => 'required|in:bank_transfer,credit_card,debit_card,e_wallet,cash,check',
            'payment_gateway' => 'nullable|string',
            'gateway_reference_id' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($validated['invoice_id']);
        $validated['customer_id'] = $invoice->customer_id;
        $validated['status'] = 'pending';

        $payment = Payment::create($validated);

        return $this->successResponse($payment, 'Payment created successfully', 201);
    }

    /**
     * Display a payment
     */
    public function show(Payment $payment)
    {
        return $this->successResponse($payment->load(['invoice', 'customer']));
    }

    /**
     * Delete a payment
     */
    public function destroy(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return $this->errorResponse('Only pending payments can be deleted', 422);
        }

        $payment->delete();

        return $this->successResponse(null, 'Payment deleted successfully');
    }

    /**
     * Get payments by gateway
     */
    public function byGateway($gateway)
    {
        $payments = Payment::where('payment_gateway', $gateway)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return $this->paginatedResponse($payments);
    }

    /**
     * Mark payment as completed
     */
    public function complete(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return $this->errorResponse('Only pending payments can be completed', 422);
        }

        $payment->markAsCompleted();

        return $this->successResponse($payment, 'Payment completed successfully');
    }

    /**
     * Refund a payment
     */
    public function refund(Payment $payment)
    {
        if ($payment->status !== 'completed') {
            return $this->errorResponse('Only completed payments can be refunded', 422);
        }

        $payment->refund();

        return $this->successResponse($payment, 'Payment refunded successfully');
    }

    /**
     * Webhook for Xendit
     */
    public function webhookXendit(Request $request)
    {
        // Verify webhook signature
        $signature = $request->header('X-Callback-Token');
        $expectedSignature = env('XENDIT_WEBHOOK_KEY');

        if ($signature !== $expectedSignature) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = $request->all();

        // Find payment by external ID
        $payment = Payment::where('gateway_reference_id', $data['external_id'] ?? null)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Update payment status
        if ($data['status'] === 'COMPLETED') {
            $payment->markAsCompleted();
        } elseif ($data['status'] === 'FAILED') {
            $payment->markAsFailed($data);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Webhook for Tripay
     */
    public function webhookTripay(Request $request)
    {
        // Verify webhook signature
        $signature = $request->header('X-Signature');
        $payload = file_get_contents('php://input');
        $expectedSignature = hash_hmac('sha256', $payload, env('TRIPAY_WEBHOOK_KEY'));

        if ($signature !== $expectedSignature) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);

        // Find payment by external ID
        $payment = Payment::where('gateway_reference_id', $data['reference'] ?? null)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Update payment status
        if ($data['status'] === 'success') {
            $payment->markAsCompleted();
        } elseif ($data['status'] === 'failed') {
            $payment->markAsFailed($data);
        }

        return response()->json(['success' => true]);
    }
}
