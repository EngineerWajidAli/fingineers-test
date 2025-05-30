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
        $usedProductIds = PricingRule::pluck('product_id')->toArray();
        $products = Product::whereNotIn('id', $usedProductIds)->get();
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('pricing', compact('pricingRules', 'products', 'daysOfWeek'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'precedence' => 'nullable|integer',
        ]);
        $data = $request->only(['product_id', 'precedence']);
        $data['days'] = $request->input('days', []);
        $data['discounts'] = $request->input('discounts', []);
        $data['min_quantity'] = $request->input('min_quantity');
        $data['quantity_discount'] = $request->input('quantity_discount');
        PricingRule::create($data);
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rule = PricingRule::findOrFail($id);
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('pricing_edit', compact('rule', 'daysOfWeek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rule = PricingRule::findOrFail($id);
        $request->validate([
            'precedence' => 'nullable|integer',
        ]);
        $data = $request->only(['precedence']);
        $data['days'] = $request->input('days', []);
        $data['discounts'] = $request->input('discounts', []);
        $data['min_quantity'] = $request->input('min_quantity');
        $data['quantity_discount'] = $request->input('quantity_discount');
        $rule->update($data);
        return redirect()->route('pricing.index')->with('success', 'Pricing rule updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rule = PricingRule::findOrFail($id);
        $rule->delete();
        return redirect()->route('pricing.index')->with('success', 'Pricing rule deleted!');
    }
}