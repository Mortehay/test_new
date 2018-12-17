<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableHostAccess extends Model
{
    protected $table = "table_host_access";
    protected $fillable = [
        'main_name',  'main_name_link', 'hosting_name', 'hosting_link', 'hosting_type', 'hosting_login', 'hosting_pass', 'comment'
    ];
}
