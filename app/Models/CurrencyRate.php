<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyRate
 * @package App\Models
 *
 * @property string $currency_iso
 * @property float $rate
 */
class CurrencyRate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['currency_iso', 'rate', 'date'];
}
