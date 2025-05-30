<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::with('product');
        if ($request->has('search'))
        {
            $search = $request->input('search');
            $query->whereHas('product', function ($q) use ($search)
            {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('sku', 'like', "%$search%");
            });
        }
        $inventories = $query->paginate(10);
        return view('inventory', compact('inventories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $request->validate([
            'stock_level' => 'required|integer|min:0',
        ]);
        $inventory = Inventory::findOrFail($id);
        $inventory->stock_level = $request->input('stock_level');
        $inventory->save();
        return redirect()->route('inventory.index')->with('success', 'Stock updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}