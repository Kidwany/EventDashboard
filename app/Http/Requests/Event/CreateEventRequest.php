<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'title'         => 'required',
            'description'   => 'required',
            'floors'        => 'required|int',
            'address'       => 'required|max:191',
            'city_id'       => 'required|int',
            'category_id'   => 'required|int',
            'start'         => 'required',
            'end'           => 'required',
            'gate_id.*'     => 'required',
            'gate_name.*'   => 'required',
        ];
    }
}
