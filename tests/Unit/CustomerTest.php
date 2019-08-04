<?php

namespace Tests\Unit;

use App\Agreement;
use App\Customer;
use App\Delivery;
use App\Invoice;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerTest extends TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    public function setUp()
    {
        parent::setUp();

        $this->customer = factory(Customer::class)->create([
            'name' => 'Søren Petersen',
            'agreement_id' => factory(\App\Agreement::class)->create([
                'unit_price' => 12.00,
                'type' => Agreement::TYPE_WEEKLY,
            ])->id,
        ]);

        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(3),
            'count' => 5,
            'customer_id' => $this->customer->id,
        ]);
        factory(Delivery::class)->create([
            'delivered_at' => Carbon::now()->subDays(8),
            'count' => 2,
            'customer_id' => $this->customer->id,
        ]);

        $this->invoiceService = app(InvoiceService::class);
    }

    public function testCreateWeeklyInvoice()
    {
        $this->customer->agreement->type = Agreement::TYPE_WEEKLY;

        $invoice = $this->invoiceService->create($this->customer);

        $this->assertEquals(60,$invoice->amount);

        $this->assertDatabaseHas('deliveries', [
            'count' => 5,
            'payed' => 1,
        ]);

        $this->assertDatabaseHas('deliveries', [
            'count' => 2,
            'payed' => 0,
        ]);
    }

    public function testCreateMonthlyInvoice()
    {
        $this->customer->agreement->type = Agreement::TYPE_MONTHLY;

        $invoice = $this->invoiceService->create($this->customer);

        $this->assertEquals(84,$invoice->amount);

        $this->assertDatabaseHas('deliveries', [
            'count' => 5,
            'payed' => 1,
        ]);

        $this->assertDatabaseHas('deliveries', [
            'count' => 2,
            'payed' => 1,
        ]);
    }
}
