<?php

namespace App\Models\db_tbs;

use Illuminate\Database\Eloquent\Model;

class GohinYamahaEntry extends Model
{
    protected $connection = 'db_tbs';
    protected $table = 'gohin_yamaha';
    protected $fillable = [
        'part_no', 'part_name', 'quantity', 'dn_no', 'order_no', 'depo_no', 'customer_process', 'delivery_date', 'delivery_time', 'created_by', 'creation_date', 'updated_by',
        'updated_date'
    ];
    protected $primaryKey = 'id_gohin';
    public $timestamps = false;
}
