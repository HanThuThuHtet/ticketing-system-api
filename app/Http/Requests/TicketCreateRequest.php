<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketCreateRequest extends FormRequest
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
            "subject" => "required|max:20",
            "description" => "required|max:100",
            "status_id" => "required|exists:statuses,id",
            "customer_id" => "required|exists:customers,id",
            "queue_id" => "required|exists:queues,id"
        ];
    }
}
