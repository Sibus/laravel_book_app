<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
