<?php

namespace W1p\LumenEasemob\App;

trait EasemobFriends
{
    /***********************   好友操作   **********************************/

    /**
     * 给用户添加好友
     *
     * @param $owner_username  [主人]
     * @param $friend_username [朋友]
     *
     * @return mixed
     */
    public function addFriend($owner_username, $friend_username)
    {
        $url          = $this->url.'users/'.$owner_username.'/contacts/users/'.$friend_username;
        $option       = [];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'POST');
    }


    /**
     * 给用户删除好友
     *
     * @param $owner_username  [主人]
     * @param $friend_username [朋友]
     *
     * @return mixed
     */
    public function delFriend($owner_username, $friend_username)
    {
        $url          = $this->url.'users/'.$owner_username.'/contacts/users/'.$friend_username;
        $option       = [];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'DELETE');
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
        $url          = $this->url.'users/'.$user_name.'/contacts/users/';
        $option       = [];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'GET');
    }
}
