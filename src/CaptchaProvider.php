<?php


namespace Oh86\NetEasy\Captcha;


use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;

class CaptchaProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/../config/neteasy-captcha.php') ?: $raw;
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('neteasy-captcha.php')]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('neteasy_captcha_verify', function($app) {
            $config = $app->get('config')['neteasy-captcha'];
            return new CaptchaVerify($config['secret_id'], $config['secret_key'], $config['captcha_id']);
        });
    }
}