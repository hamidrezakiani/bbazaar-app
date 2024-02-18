<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'withdrawal_account_id', 'status','admin_id', 'approved_by', 'message'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function approved_admin()
    {
        return $this->hasOne(Admin::class, 'id', 'approved_by');
    }

    public function withdrawal_account()
    {
        return $this->hasOne(WithdrawalAccount::class, 'id', 'withdrawal_account_id');
    }
}
