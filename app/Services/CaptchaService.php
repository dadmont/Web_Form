<?php

namespace App\Services;

class CaptchaService
{
    private $sessionKey = 'captcha_answer';

    public function generate(): string
    {
        if (session()->has($this->sessionKey)) {
            $answer = session($this->sessionKey);
            return "Сколько будет {$answer['a']} + {$answer['b']}?";
        }

        $a = rand(1, 10);
        $b = rand(1, 10);
        $answer = $a + $b;

        session([$this->sessionKey => ['a' => $a, 'b' => $b, 'answer' => $answer]]);

        return "Сколько будет {$a} + {$b}?";
    }

    public function verify(string $userInput): bool
    {
        if (!session()->has($this->sessionKey)) {
            return false;
        }

        $captcha = session($this->sessionKey);
        $isValid = (int)$userInput === $captcha['answer'];
        
        session()->forget($this->sessionKey);

        return $isValid;
    }
}
