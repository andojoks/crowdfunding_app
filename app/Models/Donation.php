<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'target_amount', 'status', 'title', 'description', 'due_date', 'details'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userDonations()
    {
        return $this->hasMany(UserDonation::class);
    }

    public function getAmountReceivedAttribute()
    {
        return $this->userDonations()->sum('amount');
    }
}
