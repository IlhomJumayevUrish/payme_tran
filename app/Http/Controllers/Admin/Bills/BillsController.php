<?php

namespace App\Http\Controllers\Admin\Bills;

use App\Http\Controllers\Controller;
use App\Models\Api\Bills;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    public function index(){
        $response = Bills::all();
        return view('pages.Bills.index', compact('response'));
    }
}
