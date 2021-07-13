<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|min:21',
            'bandName' => 'required',
            'ticketPrice' => 'required|min:1',
            'startDate' => 'required|date|after:now',
            'endDate' => 'required|date|after:startDate',
            'status' => 'required|digits:0, 1, 2, 3'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên even.',
            'bandName.required' => 'Vui lòng nhập tên ban nhạc.',
            'name.min' => 'Tên phải lớn hơn 20 ký tự.',
            'startDate.required' => 'Vui lòng nhập ngày bắt đầu.',
            'endDate.required' => 'Vui lòng nhập ngày kết thúc.',
            'status.required' => 'Vui lòng nhập trạng thái.',
            'startDate.after' => 'Phải sau ngày hiện tại.',
            'endDate.after' => 'Phải sau ngày bắt đầu.',
            'ticketPrice.required' => 'Giá vé phải lớn hơn 0.',
            'status.digits' => 'Có giá trị là 0, 1, 2, 3.'
        ];
    }

    // validate theo business riêng.
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->get('name') == 'xuanhung'){
                $validator->errors()->add('name', 'Tao không chơi với thằng Hùng.');
            }
        });
    }
}
