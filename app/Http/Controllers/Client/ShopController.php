<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\PricingRule;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('shop.index', compact('products'));
    }

    public function show(Product $product)
    {
        $inventory = Inventory::where('product_id', $product->id)->first();
        $pricing = PricingRule::where('product_id', $product->id)->first();
        $today = Carbon::now()->format('l');
        return view('shop.show', compact('product', 'inventory', 'pricing', 'today'));
    }

    public function buy(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $inventory = Inventory::where('product_id', $product->id)->lockForUpdate()->first();
        $pricing = PricingRule::where('product_id', $product->id)->first();
        $today = Carbon::now()->format('l');
        $quantity = $request->input('quantity');
        $basePrice = $inventory->cost;
        $discount = 0;
        // Day-based discount
        if ($pricing && is_array($pricing->days) && in_array($today, $pricing->days))
        {
            $discount += floatval($pricing->discounts[$today] ?? 0);
        }
        // Quantity-based discount
        if ($pricing && $pricing->min_quantity && $quantity >= $pricing->min_quantity)
        {
            $discount += floatval($pricing->quantity_discount ?? 0);
        }
        $finalPrice = $basePrice * $quantity * (1 - $discount / 100);
        DB::beginTransaction();
        try
        {
            if ($inventory->stock_level < $quantity)
            {
                throw new \Exception('Not enough stock');
            }
            $inventory->stock_level -= $quantity;
            $inventory->save();
            Transaction::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'transaction_type' => 'sale',
            ]);
            DB::commit();
            return redirect()->route('shop.sales')->with('success', 'Purchase successful! Final price: ' . number_format($finalPrice, 2));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function sales()
    {
        $sales = Transaction::where('transaction_type', 'sale')->where('product_id', '!=', null)->paginate(10);
        return view('shop.sales', compact('sales'));
    }
}