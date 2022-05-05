<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon;

class AsteroidRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $date = Carbon\Carbon::parse($this->start_date);
        $seven_days = $date->addDays(7);
        return [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|before:' . $seven_days . '|date_format:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            'end_date.before' => 'End date must be 7 days from start date.'
        ];
    }
}
