<?php

namespace W1p\LumenEasemob\Facades;

use Illuminate\Support\Facades\Facade;

class Easemob extends Facade
{

    /**
     *
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'easemob.user';
    }

    /**
     * @return User
     * @author Jasmine2
     */
    public static function user()
    {
        return app('easemob.user');
    }

    /**
     * @return Friend
     * @author Jasmine2
     */
    public static function friend()
    {
        return app('easemob.friend');
    }

    /**
     * @return Group
     * @author Jasmine2
     */
    public static function group()
    {
        return app('easemob.group');
    }

    /**
     * @return ChatRoom
     * @author Jasmine2
     */
    public static function chatRoom()
    {
        return app('easemob.chat-room');
    }

    /**
     * @return Conference
     * @author Jasmine2
     */
    public static function conference()
    {
        return app('easemob.conference');
    }

    /**
     * @return Message
     * @author Jasmine2
     */
    public static function message()
    {
        return app('easemob.message');
    }
}
