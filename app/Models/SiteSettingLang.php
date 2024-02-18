<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettingLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_setting_id', 'site_name', 'copyright_text', 'meta_title', 'meta_description', 'lang'
    ];
}
