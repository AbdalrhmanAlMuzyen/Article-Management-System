<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    public $success;
    public $message;
    public $code;

    public function __construct($data=null,$success,$message,$code)
    {
        parent::__construct($data);
        $this->success=$success;
        $this->message=$message;
        $this->code=$code;    
    }

    public function toArray(Request $request): array
    {
        return [
            "success"=>$this->success,
            "message"=>$this->message,
            "data"=>$this->resource,
            "code"=>$this->code,
        ];
    }
}
