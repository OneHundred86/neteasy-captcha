<?php


namespace Oh86\NetEasy\Captcha\Facade;


use Illuminate\Support\Facades\Facade;

/**
 * Class CaptchaVerify
 * @package Oh86\NetEasy\Captcha\Facade
 * @method verify(string $validate, string $user = '')
 */
class CaptchaVerify extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'neteasy_captcha_verify';
    }
}