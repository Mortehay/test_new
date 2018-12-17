<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TableHostAccess extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'main_name' =>$this->main_name,
            'main_name_link' =>$this->main_name_link,
            'hosting_name' =>$this->hosting_name,
            'hosting_link' =>$this->hosting_link,
            'hosting_type' =>$this->hosting_type,
            'hosting_login' =>$this->hosting_login,
            'hosting_pass' =>$this->hosting_pass,
            'comment' =>$this->comment,
        ];
    }
}
