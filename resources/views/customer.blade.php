@extends('layout')
<?php /** @var $customer \App\Customer  */ ?>
@section('content')
    <h2>{{$customer->name}}</h2>
    <div>DKK{{$customer->agreement->amount}} {{$customer->agreement->type}}</div>
    <form method="post" action="/customer/invoice/{{$customer->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" value="Invoice customer" />
    </form>

    <h2>Invoices</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Due</th>
                <th>Amount</th>
                <th>Customer</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->agreement->invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_no}}</td>
                    <td>{{ $invoice->invoice_due_at }}</td>
                    <td>{{ $invoice->amount}}</td>
                    <td> {{-- TODO: insert name of customer and link to customer --}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
