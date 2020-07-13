<?php

namespace Blazer\WorkWechatRobot;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        //
    }

    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/config.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('work_wechat_robot.php')], 'laravel-work-wechat-robot');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('work_wechat_robot');
        }

        $this->mergeConfigFrom($source, 'work_wechat_robot');
    }

    public function register()
    {
        $this->setupConfig();

        $this->app->singleton('work-wechat-robot', function ($app) {
            $config = $app['config']->get('work_wechat_robot');
            $url = $config['clients'][$config['default']];
            $config = [
                'url' => $url,
                'async' => $config['async'],
                'queue' => $config['queue'],
                'app' => $app,
            ];

            return (new WorkWechatRobot($config));
        });

        $this->app->alias('work-wechat-robot', WorkWechatRobot::class);

    }
}
