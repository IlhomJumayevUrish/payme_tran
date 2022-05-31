<?php

namespace App\Http\Controllers\Admin\Payme;

use App\Http\Controllers\Controller;
use App\Models\BillingSetting;
use Illuminate\Http\Request;
use App\Http\Requests\PaymeUpdateRequest;

class PaymeSettingController extends Controller
{
    public function index(){
        $user_settings = BillingSetting::getSettings('payme_user');
        $order_settings = BillingSetting::getSettings('payme_order');
        return view('pages.Payme.index', compact('order_settings', 'user_settings'));
    }

    public function edit($psystem){
        $response = BillingSetting::getSettings($psystem);
        return view('pages.Payme.edit', compact('response', 'psystem'));
    }

    public function update($psystem, PaymeUpdateRequest $request){
        BillingSetting::updateSettings($request->validated());
        return redirect(route('admin.payme.index'));
    }
}
