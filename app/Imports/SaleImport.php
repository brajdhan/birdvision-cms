<?php

namespace App\Imports;

use App\Jobs\ProcessCustomerSale;
use App\Models\Customer;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;

class SaleImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] == 'Name' && $row[1] == 'Email' && $row[2] == 'Phone' && $row[3] == 'Product' && $row[4] == 'Amount') {
            return null;
        }

      //  ProcessCustomerSale::dispatch($row);

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
        return new Sale([
            'customer_id' => $customer->id,
            'product_name' => $row[3],
            'amount' => $row[4],
        ]);
    }
}
