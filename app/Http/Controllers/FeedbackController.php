<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
{
    $orders = Order::where('user_id', auth()->id())->get();

    return view('myorders.index', compact('orders'));
}
    public function create(Order $order)
    {
        return view('feedback.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
            'product_id' => $order->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('myorders.index')->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
