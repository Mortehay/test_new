<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableAdditionalDomains extends Model
{
    protected $table = "table_additional_domains";
    protected $fillable = [
        'main_id',  'additional_domain'
    ];
}
