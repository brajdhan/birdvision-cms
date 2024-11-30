<?php

namespace App\Http\Controllers;

use App\Exports\SaleExport;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Imports\SaleImport;
use App\Models\Customer;
use App\Models\Sale;
use App\Notifications\SaleAdded;
use App\Notifications\SaleAddedTwilio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->search;
        $sales = Sale::search($searchQuery)->paginate(10);
        return view('sales.list', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::select('id', 'name')->get();
        return view('sales.create',compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
       $sale= Sale::create($request->validated());
        $customer = $sale->customer;
        $customer->notify(new SaleAdded($sale));
        return redirect()->route('sales.index')->with('success', 'Sale created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $customers = Customer::select('id', 'name')->get();
        return view('sales.edit', compact('sale','customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $sale->update($request->validated());
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }

        $sale->delete();
        return redirect()->back()->with('success', 'Sale deleted successfully!');
    }

    public function recycleBin()
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }

        $sales = Sale::onlyTrashed()->paginate(10);
        return view('sales.recycleBin', compact('sales'));
    }

    public function restore($id)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }

        $sale = Sale::withTrashed()->findOrFail($id);
        $sale->restore();

        return redirect()->route('sales.recycleBin')->with('success', 'Sale restored successfully!');
    }

    public function forceDelete($id)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }

        $sale = Sale::withTrashed()->findOrFail($id);
        $sale->forceDelete();

        return redirect()->route('sales.recycleBin')->with('success', 'Sale permanently deleted!');
    }

    public function exportImportSales()
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }

        return view('sales.import-export');
    }

    public function importSales(Request $request)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max file size
        ]);

        $file = $request->file('file');
        Excel::import(new SaleImport, $file);

        return back()->with('success', 'Sales imported successfully!');
    }

    public function exportSales(Request $request)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new SaleExport($startDate, $endDate), 'sales.xlsx');
    }
}

