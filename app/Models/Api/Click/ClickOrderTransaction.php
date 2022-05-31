<?php

namespace App\Models\Api\Click;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickOrderTransaction extends Model
{
    use HasFactory;

    protected $table = 'click_transactions';

    protected $guarded = [];
}
