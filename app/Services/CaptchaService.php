<?php

namespace App\Services;

class CaptchaService
{
    public function generate()
    {
        $num1 = rand(1,1);;
        $num2 = rand(1,1);
        session(['captcha_answer' => $num1 + $num2]); // Простая примерная проверка, логику и механизм можно усложнить
        return "Сколько будет $num1 + $num2?";  
    }

    public function verify($answer)
    {
        return $answer == session('captcha_answer');
    }
}