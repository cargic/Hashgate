<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMill extends Model
{
    use SoftDeletes;

    CONST SHUTDOWN = 0;         // 关机
    CONST ONLINE = 1;           // 在线
    CONST ANOMALY = 2;          // 异常
    CONST WORK_ORDER = 3;       // 工单中

    protected $fillable = [
        'user_id','mill_group_id','mill_number','vga_type','vga_number','ip','power','status','24h_anomaly','24h_online',
        'remark',
    ];
}
