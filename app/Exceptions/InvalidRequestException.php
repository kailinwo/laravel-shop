<?php

namespace App\Exceptions;

use Exception;

class InvalidRequestException extends Exception
{
    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render(\Illuminate\Http\Request $request)
    {
        if ($request->expectsJson()) {
            //json()方法的第二个参数就是Http 返回码
            return response()->json(['msg' => $this->message], $this->code);
        }
        return view('pages.error', ['msg' => $this->message]);
    }
}
