<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'request_content' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'request_content.required' => '回复内容不能为空'
        ];
    }
}
