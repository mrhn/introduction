<?php

namespace App\Services;

use App\Customer;
use App\Invoice;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class InvoiceService
{
    public function create(Customer $customer): Invoice
    {
        $agreement = $customer->agreement;

        $deliveries = $customer
            ->deliveries()
            ->notPayed()
            ->withinAgreement($agreement->invoiceInterval())
        ;

        $invoice = new Invoice([
            'invoice_no' => Uuid::uuid4(), // assuming something random is needed
            'invoice_due_at' => Carbon::now()->addDays(14), // assume this is the payment interval
            'amount' => $deliveries->sum('count') * $agreement->unit_price,
        ]);

        // to avoid double payments for the same delivery
        $deliveries->update(['payed' => true]);

        $invoice->agreement()->associate($agreement);
        $invoice->save();

        return $invoice;
    }
}
