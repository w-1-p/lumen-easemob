<?php

namespace W1p\LumenEasemob;

use Illuminate\Support\ServiceProvider;
use W1p\LumenEasemob\App\Easemob;

class LumenEasemobServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false; // 延迟加载服务

    /**
     * 引导程序
     *
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * 默认包位置
     *
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // 将给定配置文件合现配置文件接合
        $this->mergeConfigFrom(
            __DIR__.'/config/easemob.php', 'easemob'
        );

        // 容器绑定
        $this->app->bind('Easemob', function () {
            return new Easemob();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
