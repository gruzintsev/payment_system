<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @package App\Models
 *
 * @property int $id
 * @property int $user_from_id
 * @property int $user_to_id
 * @property string $currency_iso
 * @property float $amount
 */
class Transaction extends Model
{
    use HasFactory;

    public const STATUS_NEW = 1;
    public const STATUS_COMPLETE = 2;
    public const STATUS_FAIL = 3;

    public static $statusNames =[
        self::STATUS_NEW => 'New',
        self::STATUS_COMPLETE => 'Complete',
        self::STATUS_FAIL => 'Fail',
    ];

    protected $fillable = ['user_from_id', 'user_to_id', 'currency_iso', 'amount', 'status'];

    /**
     * Получить название статуса
     * @param int $status
     * @return string
     */
    public static function getStatusName(int $status): string
    {
        return self::$statusNames[$status] ?? '';
    }

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_from_id');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_to_id');
    }
}
