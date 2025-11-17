<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function coursePayments()
    {
        return $this->hasMany(CoursePayment::class, 'payment_method', 'name');
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class, 'payment_method', 'name');
    }
}
