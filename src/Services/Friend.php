<?php

namespace W1p\LumenEasemob\Services;

use Illuminate\Support\Arr;
use W1p\LumenEasemob\Http\Client as Http;

class Friend extends BaseService
{
    /**
     * 给用户添加好友
     *
     * @param $owner_username [主人]
     * @param $friend_username [朋友]
     *
     * @return mixed
     */
    public function addFriend($owner_username, $friend_username)
    {
        $url = $this->url.'users/'.$owner_username.'/contacts/users/'.$friend_username;

        return Http::auth('POST', $url);
    }

    /**
     * 给用户删除好友
     *
     * @param $owner_username [主人]
     * @param $friend_username [朋友]
     *
     * @return mixed
     */
    public function delFriend($owner_username, $friend_username)
    {
        $url = $this->url.'users/'.$owner_username.'/contacts/users/'.$friend_username;

        return Http::auth('DELETE', $url);
    }

    /**
     * 查看用户所以好友
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function showFriends($user_name)
    {
        $url = $this->url.'users/'.$user_name.'/contacts/users';
        return Http::auth('GET', $url);
    }

    /**
     * 查看用户所有的群
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function showGroups($user_name)
    {
        $url = $this->url.'users/'.$user_name.'/joined_chatgroups';
        return Http::auth('GET', $url);
    }

    public function blocks($user)
    {
        $url = $this->url."users/{$user}/blocks/users";
        return Http::auth('get', $url);
    }

    public function removeBlocks($user, $users)
    {
        $users = Arr::wrap($users);
        $url = $this->url."users/{$user}/blocks/users/".join('/', $users);
        return Http::auth('delete', $url);
    }
}
