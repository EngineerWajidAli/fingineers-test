<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingRule;
use App\Models\Product;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pricingRules = PricingRule::with('product')->paginate(10);
        $products = Product::all();
        return view('pricing', compact('pricingRules', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rule_type' => 'required|in:time,quantity',
            'min_quantity' => 'nullable|integer|min:0',
            'discount_amount' => 'nullable|numeric',
            'markup_amount' => 'nullable|numeric',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
            'precedence' => 'required|integer',
        ]);
        PricingRule::create($request->all());
        return redirect()->route('pricing.index')->with('success', 'Pricing rule added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}