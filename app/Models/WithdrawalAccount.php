<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number','account_name','bank_name', 'branch_name', 'title', 'admin_id', 'default'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
