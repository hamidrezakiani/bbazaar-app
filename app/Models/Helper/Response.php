<?php

namespace App\Models\Helper;


class Response
{
   public $data;
   public $status;
    public $token;
   public $message;

   public function __construct($token = '', $data = [], $status = 200,  $message = ''){
       $this->data = $data;
       $this->status = $status;
       $this->token = $token;
       $this->message = $message;
   }
}
