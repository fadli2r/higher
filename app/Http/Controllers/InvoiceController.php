<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
{
    $invoice = Invoice::with(['transaction.orders'])->findOrFail($id);

    // Pastikan relasi 'orders' tersedia dari transaksi
    $orders = $invoice->transaction->orders ?? [];

    return view('invoices.show', compact('invoice', 'orders'));
}

    /**
     * Generate PDF dari invoice dan unduh.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generatePdf($id)
    {
        $invoice = Invoice::with(['transaction.orders'])->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('Invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * List semua invoice untuk user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $invoices = Invoice::where('user_id', auth()->id())->latest()->get();

        return view('invoices.index', compact('invoices', 'orders'));
    }

}
