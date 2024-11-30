<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Sale extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    protected $fillable = ['customer_id', 'product_name', 'amount'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function toSearchableArray()
    {
        return array_merge($this->toArray(), [
            'product_name' => (string) $this->product_name,
            'amount' => (string) $this->amount,
        ]);
    }
}
