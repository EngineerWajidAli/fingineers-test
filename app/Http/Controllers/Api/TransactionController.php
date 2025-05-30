<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('product')->paginate(10);
        return view('transactions', compact('transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'transaction_type' => 'required|in:sale,restock,adjustment',
        ]);
        DB::beginTransaction();
        try
        {
            $inventory = Inventory::where('product_id', $request->product_id)->lockForUpdate()->first();
            if (!$inventory)
            {
                throw new \Exception('Inventory not found');
            }
            $oldStock = $inventory->stock_level;
            if ($request->transaction_type === 'sale')
            {
                if ($inventory->stock_level < $request->quantity)
                {
                    throw new \Exception('Not enough stock');
                }
                $inventory->stock_level -= $request->quantity;
            }
            elseif ($request->transaction_type === 'restock')
            {
                $inventory->stock_level += $request->quantity;
            }
            elseif ($request->transaction_type === 'adjustment')
            {
                $inventory->stock_level = $request->quantity;
            }
            $inventory->save();
            $transaction = Transaction::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'transaction_type' => $request->transaction_type,
            ]);
            AuditLog::create([
                'transaction_id' => $transaction->id,
                'action' => $request->transaction_type,
                'details' => 'Stock changed from ' . $oldStock . ' to ' . $inventory->stock_level,
            ]);
            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaction processed!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('transactions.index')->with('error', $e->getMessage());
        }
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