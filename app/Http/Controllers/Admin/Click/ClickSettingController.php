<?php

namespace App\Http\Controllers\Admin\Click;

use App\Http\Controllers\Controller;
use App\Models\BillingSetting;
use Illuminate\Http\Request;
use App\Http\Requests\ClickUpdateRequest;

class ClickSettingController extends Controller
{
    public function index(){
        $user_settings = BillingSetting::getSettings('click_user');
        $order_settings = BillingSetting::getSettings('click_order');
        return view('pages.Click.index', compact('order_settings', 'user_settings'));
    }

    public function edit($psystem){
        $response = BillingSetting::getSettings($psystem);
        return view('pages.Click.edit', compact('response', 'psystem'));
    }

    public function update($psystem, ClickUpdateRequest $request){
        BillingSetting::updateSettings($request->validated());
        return redirect(route('admin.click.index'));
    }
}
