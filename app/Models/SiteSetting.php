<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name', 'meta_title', 'meta_description', 'email_logo', 'site_url',
        'header_logo', 'footer_logo', 'copyright_text', 'admin_id',
        'primary_color', 'primary_hover_color', 'styling'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
