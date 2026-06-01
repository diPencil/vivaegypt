<?php

namespace Modules\PaymentGateway\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymobRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'currency_id' => 'required',
            'api_key' => 'required',
            'iframe_id' => 'required',
            'integration_id' => 'required',
            'hmac' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'currency_id.required' => trans('translate.Currency is required'),
            'api_key.required' => trans('translate.API Key is required'),
            'iframe_id.required' => trans('translate.Iframe ID is required'),
            'integration_id.required' => trans('translate.Integration ID is required'),
            'hmac.required' => trans('translate.HMAC is required'),
        ];
    }
}
