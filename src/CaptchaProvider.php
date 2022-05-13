<?php


namespace Oh86\NetEasy\Captcha;


use Illuminate\Support\ServiceProvider;

class CaptchaProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('neteasy_captcha_verify', function($app) {
            $config = $app->get('config')['neteasy']['captcha'];
            return new CaptchaVerify($config['secret_id'], $config['secret_key'], $config['captcha_id']);
        });
    }
}