<?php

namespace App\Http\Controllers;

use App\Models\AbandonedCart;
use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    // Display a listing of abandoned carts
    public function index()
    {
        // Retrieve all abandoned carts
        $abandonedCarts = AbandonedCart::latest()->paginate(10);

        return view('backend.abandoned_carts.index', compact('abandonedCarts'));
    }

    // Display a specific abandoned cart
    public function show($id)
    {
        // Retrieve abandoned cart by uniqid or ID
        $abandonedCart = AbandonedCart::findOrFail($id);

        return view('backend.abandoned_carts.show', compact('abandonedCart'));
    }

    // Delete a specific abandoned cart
    public function destroy($id)
    {
        // Retrieve and delete the abandoned cart
        $abandonedCart = AbandonedCart::findOrFail($id);
        $abandonedCart->delete();

        // Redirect with a success message
        flash('Abandoned cart deleted successfully!')->success();
        return redirect()->route('abandoned_cart.index');
    }
}
