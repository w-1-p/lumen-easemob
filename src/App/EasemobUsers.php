<?php

namespace W1p\LumenEasemob\App;

trait EasemobUsers
{
    /***********************   注册   **********************************/

    /**
     * 开放注册用户
     *
     * @param        $name      [用户名]
     * @param string $password  [密码]
     * @param string $nick_name [昵称]
     *
     * @return mixed
     */
    public function publicRegistration($name, $password = '', $nick_name = "")
    {
        $url    = $this->url.'users';
        $option = [
            'username' => $name,
            'password' => $password,
            'nickname' => $nick_name,
        ];

        return Http::postCurl($url, $option, 0);
    }


    /**
     * 授权注册用户
     *
     * @param        $name      [用户名]
     * @param string $password  [密码]
     * @param string $nick_name [昵称]
     *
     * @return mixed
     */
    public function authorizationRegistration($name, $password = '123456')
    {
        $url          = $this->url.'users';
        $option       = [
            'username' => $name,
            'password' => $password,
        ];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header);
    }


    /**
     * 授权注册用户——批量
     * 密码不为空
     *
     * @param    array $users [用户名 包含 username,password的数组]
     *
     * @return mixed
     */
    public function authorizationRegistrations($users)
    {
        $url          = $this->url.'users';
        $option       = $users;
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header);
    }

    /***********************   用户操作   **********************************/

    /**
     * 获取单个用户
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function getUser($user_name)
    {
        $url          = $this->url.'users/'.$user_name;
        $option       = [];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'GET');
    }


    /**
     * 获取所有用户
     *
     * @param int    $limit  [显示条数]
     * @param string $cursor [光标，在此之后的数据]
     *
     * @return mixed
     */
    public function getUserAll($limit = 10, $cursor = '')
    {
        $url          = $this->url.'users';
        $option       = [
            'limit'  => $limit,
            'cursor' => $cursor
        ];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'GET');
    }


    /**
     * 删除用户
     * 删除一个用户会删除以该用户为群主的所有群组和聊天室
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function delUser($user_name)
    {
        $url          = $this->url.'users/'.$user_name;
        $option       = [];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'DELETE');
    }


    /**
     * 修改密码
     *
     * @param $user_name
     * @param $new_password [新密码]
     *
     * @return mixed
     */
    public function editUserPassword($user_name, $new_password)
    {
        $url          = $this->url.'users/'.$user_name.'/password';
        $option       = [
            'newpassword' => $password
        ];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'PUT');
    }


    /**
     * 修改用户昵称
     * 只能在后台看到，前端无法看见这个昵称
     *
     * @param $user_name
     * @param $nickname
     *
     * @return mixed
     */
    public function editUserNickName($user_name, $nickname)
    {
        $url          = $this->url.'users/'.$user_name;
        $option       = [
            'nickname' => $nickname
        ];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'PUT');
    }


    /**
     * 强制用户下线
     *
     * @param $user_name
     *
     * @return mixed
     */
    public function disconnect($user_name)
    {
        $url          = $this->url.'users/'.$user_name.'/disconnect';
        $option       = [];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'GET');
    }
}
