<?php

namespace W1p\LumenEasemob;

use GuzzleHttp\Client;
use W1p\LumenEasemob\Services\User;
use W1p\LumenEasemob\Services\Group;
use W1p\LumenEasemob\Services\Friend;
use W1p\LumenEasemob\Services\Message;
use W1p\LumenEasemob\Services\ChatRoom;
use Illuminate\Support\ServiceProvider;
use W1p\LumenEasemob\Services\Conference;

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
        $apps = [
            'user' => User::class,
            'friend' => Friend::class,
            'chat-room' => ChatRoom::class,
            'group' => Group::class,
            'conference' => Conference::class,
            'message' => Message::class,
        ];

        foreach ($apps as $name => $class) {
            $this->app->singleton("easemob.{$name}", function () use ($class) {
                return new $class(config('easemob'));
            });
        }

        $this->app->singleton('easemob.http', function () {
            $baseHost = config('easemob.domain_name');
            return new Client([
                'base_uri' => $baseHost,
                'headers' => [
                    'accept' => 'application/json',
                ],
            ]);
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
