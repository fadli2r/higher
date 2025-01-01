<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CustomRequest;
use App\Models\CustomItem;
use App\Models\CustomRequestItem;
use App\Models\CustomSize;
use Illuminate\Http\Request;

class CustomDesignController extends Controller
{
    public function index()
    {
        $customItems = CustomItem::all();
        $customSizes = CustomSize::all();

        return view('custom-design.index', compact('customItems', 'customSizes'));
    }

    public function create(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login untuk membuat custom design.');
    }
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'size_id' => 'required|exists:custom_sizes,id',
        'custom_item_id' => 'required|exists:custom_items,id',
        'custom_item_id' => 'required|exists:custom_items,id',
    'whatsapp' => 'required|string|max:15',
    'brand_name' => 'nullable|string|max:255',
    'color_recommendation' => 'nullable|string|max:255',
    'direction' => 'nullable|string',
    'design_reference' => 'nullable|file|mimes:jpg,png,pdf,ai,eps,cdr|max:2048',
    ]);

    // Cari ukuran dan item kustom
    $size = CustomSize::find($validated['size_id']);
    $customItem = CustomItem::find($validated['custom_item_id']);

    // Hitung total harga
    $price = $size->additional_price + $customItem->base_price;

    if ($request->hasFile('design_reference')) {
        $filePath = $request->file('design_reference')->store('design-references', 'public');
        $validated['design_reference'] = $filePath;
    }
    // Buat CustomRequest dengan harga yang dihitung
    $customRequest = CustomRequest::create([
        'user_id' => auth()->id(),
        'name' => $validated['name'],
        'description' => $validated['description'],
        'size_id' => $validated['size_id'],
        'custom_item_id' => $validated['custom_item_id'],
        'price' => $price, // Update harga yang benar
        'status' => 'pending',
'whatsapp' => $validated['whatsapp'],
    'brand_name' => $validated['brand_name'],
    'color_recommendation' => $validated['color_recommendation'],
    'direction' => $validated['direction'],
    'design_reference' => $validated['design_reference'] ?? null,
    ]);

    return redirect()->route('custom-design.index')->with('success', 'Custom Design Created Successfully!');
}
    public function addToCart($customRequestId)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $customRequest = CustomRequest::find($customRequestId);

    if (!$customRequest || $customRequest->price <= 0) {
        session()->flash('error', 'Desain kustom tidak valid atau tidak memiliki harga.');
        return redirect()->route('customDesign.index');
    }

    Cart::updateOrCreate(
        [
            'user_id' => auth()->id(),
            'custom_request_id' => $customRequestId,
        ],
        [
            'quantity' => 1,
        ]
    );

    session()->flash('success', 'Desain kustom berhasil ditambahkan ke keranjang.');
    return redirect()->route('customDesign.index');
}
public function store(Request $request)
{
    $size = CustomSize::find($request->size_id);
    $customItem = CustomItem::find($request->custom_item_id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'size_id' => 'required|exists:custom_sizes,id',
        'description' => 'required|string|max:500',
        'whatsapp' => 'required|string|max:15',
        'brand_name' => 'nullable|string|max:255',
        'color_recommendation' => 'nullable|string|max:255',
        'direction' => 'nullable|string',
        'design_reference' => 'nullable|file|mimes:jpg,png,pdf,ai,eps,cdr|max:2048',
    ]);

    // Simpan file jika ada
    if ($request->hasFile('design_reference')) {
        $filePath = $request->file('design_reference')->store('design-references', 'public');
        $validated['design_reference'] = $filePath;
    }

    // Hitung harga total
    $price = $size->additional_price + $customItem->base_price;

    // Buat Custom Request
    $customRequest = CustomRequest::create([
        'user_id' => auth()->id(),
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $price,
        'status' => 'pending',
        'whatsapp' => $validated['whatsapp'],
        'direction' => $validated['direction'],
        'brand_name' => $validated['brand_name'],
        'color_recommendation' => $validated['color_recommendation'],
        'design_reference' => $validated['design_reference'] ?? null,
    ]);

    // Tambahkan item custom request
    $customRequestItem = CustomRequestItem::create([
        'custom_request_id' => $customRequest->id,
        'custom_size_id' => $request->size_id,
        'custom_item_id' => $request->custom_item_id,
        'quantity' => 1,
    ]);

    // Hitung total harga
    $totalPrice = $size->additional_price;

    // Tambahkan ke keranjang
    Cart::create([
        'user_id' => auth()->id(),
        'custom_request_id' => $customRequest->id,
        'quantity' => 1,
        'total_price' => $totalPrice,
    ]);

    flash()->success('Custom request berhasil ditambahkan ke keranjang.');
    return redirect()->route('cart.index');
}


}
