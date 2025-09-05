<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'provider_payment_method_id',
        'last_four',
        'brand',
        'exp_month',
        'exp_year',
        'nickname',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->nickname) {
            return $this->nickname;
        }

        if ($this->brand && $this->last_four) {
            return ucfirst($this->brand) . ' •••• ' . $this->last_four;
        }

        return 'Saved Payment Method';
    }

    public function getIsExpiredAttribute()
    {
        if (!$this->exp_month || !$this->exp_year) {
            return false;
        }

        $expiry = \Carbon\Carbon::createFromDate($this->exp_year, $this->exp_month, 1)->endOfMonth();
        return $expiry->isPast();
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('exp_month')
              ->orWhereNull('exp_year')
              ->orWhere(function ($subQ) {
                  $currentDate = now();
                  $subQ->where('exp_year', '>', $currentDate->year)
                       ->orWhere(function ($yearQ) use ($currentDate) {
                           $yearQ->where('exp_year', $currentDate->year)
                                 ->where('exp_month', '>=', $currentDate->month);
                       });
              });
        });
    }
}
