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

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return View::make('customer', compact('customer'));
    }

    public function invoice(Request $request, Customer $customer, InvoiceService $invoiceService)
    {
        /** @var Customer $customer */
        $customer = Customer::findOrFail($customer);

        $invoiceService->create($customer);

        return Redirect::action(self::class.'@show',['id' => $customer]);
    }
}
