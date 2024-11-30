<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCustomerSale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $row;

    /**
     * Create a new job instance.
     */
    public function __construct(array $row)
    {
        $this->row = $row;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $row = $this->row;

        // Skip header row
        if ($row[0] == 'Name' && $row[1] == 'Email' && $row[2] == 'Phone' && $row[3] == 'Product' && $row[4] == 'Amount') {
            return;
        }

        // Find or create the customer
        $customer = Customer::where('email', $row[1])->first();

        if (!$customer) {
            $customer = new Customer([
                'name' => $row[0],
                'email' => $row[1],
                'phone' => $row[2]
            ]);
            $customer->save();
        }

        // Create a new sale record
        Sale::create([
            'customer_id' => $customer->id,
            'product_name' => $row[3],
            'amount' => $row[4],
        ]);
    
    }
}
