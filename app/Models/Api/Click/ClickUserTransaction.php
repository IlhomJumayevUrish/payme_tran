<?php

namespace App\Models\Api\Click;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickUserTransaction extends Model
{
    use HasFactory;

    protected $table = 'click_transactions';

    protected $guarded = [];
}
