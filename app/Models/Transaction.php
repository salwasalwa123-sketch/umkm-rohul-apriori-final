<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = ['transaction_code', 'transaction_date'];

    protected function casts(): array
    {
        return ['transaction_date' => 'date'];
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'transaction_details')
            ->withPivot('qty')
            ->withTimestamps();
    }
}
