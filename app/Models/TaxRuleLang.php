<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRuleLang extends Model
{
    use HasFactory;


    protected $fillable = [
        'tax_rule_id', 'title', 'lang'
    ];
}
