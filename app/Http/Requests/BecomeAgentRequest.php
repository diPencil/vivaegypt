<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BecomeAgentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_agent_logo' => 'nullable',
            'agent_logo' => 'required_without:old_agent_logo|mimes:jpg,jpeg,png|max:2048',
            'agent_name' => 'required',
            'agent_slug' => 'required|unique:users,agent_slug,' . auth()->user()->id,
            'about_me' => 'required',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'address' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'agent_logo.required' => trans('translate.Logo is required'),
            'agent_name.required' => trans('translate.Agent Name is required'),
            'agent_slug.required' => trans('translate.Agent Slug is required'),
            'agent_slug.unique' => trans('translate.Agent Slug already exist'),
            'about_me.required' => trans('translate.Agent Description is required'),
            'country.required' => trans('translate.Country is required'),
            'state.required' => trans('translate.State is required'),
            'city.required' => trans('translate.City is required'),
            'address.required' => trans('translate.Address is required'),
        ];
    }
}
