<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory, Notifiable, Searchable, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone'];


    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function toSearchableArray()
    {
        return array_merge($this->toArray(), [
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            'phone' => (string) $this->phone,
            // 'created_at' => $this->created_at->timestamp,
        ]);
    }
}
