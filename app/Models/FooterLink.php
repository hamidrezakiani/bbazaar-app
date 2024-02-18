<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id', 'type','admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];


    public function page(){
        return $this->hasOne(Page::class, 'id', 'page_id');
    }
}
