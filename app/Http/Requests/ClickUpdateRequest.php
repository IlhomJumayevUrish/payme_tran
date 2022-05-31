<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClickUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            $this->request->get('psystem').'_service_id' => 'required',
            $this->request->get('psystem').'_merchant_id' => 'required',
            $this->request->get('psystem').'_key' => 'required',
            $this->request->get('psystem').'_min_amount' => 'required|integer|min:500',
            $this->request->get('psystem').'_max_amount' => 'required|integer|min:1000',
        ];
    }
}
