<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use OwenIt\Auditing\Contracts\Auditable;

class FlashSale extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    

    protected $fillable = [
        'title', 'start_time', 'end_time', 'status', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];


    public function public_products()
    {
        return $this->hasMany(FlashSaleProduct::class, 'flash_sale_id', 'id')
            ->join('products as p', function($join) {
                $join->on('p.id', '=', 'flash_sale_products.product_id');
                $join->where('p.status', Config::get('constants.status.PUBLIC'));
            })
            ->groupBy('p.id')
            ->select('flash_sale_products.*', 'p.id', 'p.slug', 'p.title',  'p.badge', 'p.selling', 'p.offered',
                'p.image', 'p.review_count', 'p.rating')
            ->offset(0)
            ->limit(Config::get('constants.pagination.FRONTEND_SEARCH'));
    }


    public function products()
    {
        return $this->hasMany(FlashSaleProduct::class, 'flash_sale_id', 'id');
    }
}
