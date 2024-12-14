<?php

namespace App\Http\Controllers;

use App\Models\ManualPaymentMethod;
use Illuminate\Http\Request;

class LinkPaymentMethodController extends Controller
{
    public function create()
    {
        return view('link_payment_methods.create');
    }

    public function edit($id)
    {
        $manual_payment_method = ManualPaymentMethod::findOrFail(decrypt($id));

        return view('link_payment_methods.edit', compact('manual_payment_method'));
    }
}
