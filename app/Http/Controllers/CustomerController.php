<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return View::make('customers', compact('customers'));
    }

    public function show(Customer $customer)
    {
        return View::make('customer', compact('customer'));
    }

    public function invoice(Request $request, Customer $customer, InvoiceService $invoiceService)
    {
        $invoiceService->create($customer);

        return Redirect::route('customer.show',['id' => $customer]);
    }
}
