<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->search;
        $customers = Customer::search($searchQuery)->paginate(10);
        return view('customers.list', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        Customer::create($request->validated());
        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $customer->update($request->validated());
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully!');
    }

    public function recycleBin()
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $customers = Customer::onlyTrashed()->paginate(10);
        return view('customers.recycleBin', compact('customers'));
    }

    public function restore($id)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $customer = Customer::withTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()->route('customers.recycleBin')->with('success', 'Customer restored successfully!');
    }

    public function forceDelete($id)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $customer = Customer::withTrashed()->findOrFail($id);
        $customer->forceDelete();

        return redirect()->route('customers.recycleBin')->with('success', 'Customer permanently deleted!');
    }

    public function exportImportCustomers()
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        return view('customers.import-export');
    }

    public function importCustomers(Request $request)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max file size
        ]);

        $file = $request->file('file');
        Excel::import(new CustomerImport, $file);

        return back()->with('success', 'Customers imported successfully!');
    }

    public function exportCustomers(Request $request)
    {
        if (Auth::user()->role == 'sales_manager') {
            abort(403, 'Unauthorized action.');
        }
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new CustomerExport($startDate, $endDate), 'customers.xlsx');
    }
}
