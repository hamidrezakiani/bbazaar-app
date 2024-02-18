<?php

namespace App\Models\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ControllerHelper extends Controller
{
    protected $user;
    protected $isVendor = false;
    protected $isSuperAdmin = false;
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->user = Auth::guard('admin')->user();
            if(!is_null($this->user)){
                foreach ($this->user->roles->pluck('name') as $i){
                    if($i == 'vendor') {
                        $this->isVendor = true;
                        break;
                    } else if($i == 'superadmin') {
                        $this->isSuperAdmin = true;
                        break;
                    }
                }
            }

            return $next($request);
        });
    }
}
