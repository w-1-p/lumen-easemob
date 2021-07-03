<?php

namespace W1p\LumenEasemob\Services;

use W1p\LumenEasemob\Http\Client as Http;

use Cache;

class User extends BaseService
{
    public function getAccessToken()
    {
        $url = $this->url.'token';
        if (Cache::has(self::CACHE_NAME)) {
            return Cache::get(self::CACHE_NAME);
        }

        $data = \GuzzleHttp\json_decode(app('easemob.http')->post($url, [
            'json' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
            ],
        ])->getBody()->getContents(), true);

        $expires_in = (int)$data['expires_in'];
        Cache::put(self::CACHE_NAME, $data['access_token'], $expires_in);
        return $data;
    }

    /**
     * 开放注册用户
     *
     * @param        $name [用户名]
     * @param string $password [密码]
     * @param string $nick_name [昵称]
     *
     * @return mixed
     */
    public function publicRegister($name, $password = '', $nick_name = "")
    {
        $url = $this->url.'users';
        $option = [
            'username' => $name,
            'password' => $password,
            'nickname' => $nick_name,
        ];
        return Http::json($url, $option);
    }

    /**
     * 授权注册用户
     *
     * @param        $name [用户名]
     * @param string $password [密码]
     *
     * @return mixed
     */
    public function authorizationRegister($name, $password = 'v7Alto')
    {
        $url = $this->url.'users';
        $option = [
            'username' => $name,
            'password' => $password,
        ];
        return Http::json($url, $option);
    }

    /**
     * 获取单个用户
     *
     * @param $username
     *
     * @return mixed
     * @throws
     */
    public function getUser($username)
    {
        $url = $this->url.'users/'.$username;
        return Http::auth('GET', $url);
    }

    /**
     * 获取所有用户
     *
     * @param int $limit [显示条数]
     * @param string $cursor [光标，在此之后的数据]
     *
     * @return mixed
     * @throws
     */
    public function getUsers($limit = 10, $cursor = '')
    {
        $url = $this->url.'users';
        $option = [
            'limit' => $limit,
            'cursor' => $cursor,
        ];
        return Http::auth('GET', $url, $option);
    }

    /**
     * 删除用户
     * 删除一个用户会删除以该用户为群主的所有群组和聊天室
     *
     * @param $username
     *
     * @return mixed
     */
    public function delUser($username)
    {
        $url = $this->url.'users/'.$username;
        return Http::auth('DELETE', $url);
    }

    /**
     * 修改密码
     *
     * @param $username
     * @param $new_password [新密码]
     *
     * @return mixed
     */
    public function editUserPassword($username, $new_password)
    {
        $url = $this->url.'users/'.$username.'/password';
        $option = [
            'newpassword' => $new_password,
        ];

        return Http::auth('PUT', $url, $option);
    }

    /**
     * 修改用户昵称
     * 只能在后台看到，前端无法看见这个昵称
     *
     * @param $username
     * @param $nickname
     *
     * @return mixed
     */
    public function editUserNickName($username, $nickname)
    {
        $url = $this->url.'users/'.$username;
        $option = [
            'nickname' => $nickname,
        ];

        return Http::auth('PUT', $url, $option);
    }

    /**
     * 强制用户下线
     *
     * @param $username
     *
     * @return mixed
     */
    public function disconnect($username)
    {
        $url = $this->url.'users/'.$username.'/disconnect';

        return Http::auth('GET', $url);
    }

    public function status($username)
    {
        $url = $this->url."users/{$username}/status";
        return Http::auth('GET', $url);
    }

    public function batchStatus(array $users)
    {
        $url = $this->url."users/batch/status";
        return Http::auth('post', $url, [
            'usernames' => $users,
        ]);
    }

    public function deactivate($user)
    {
        $url = $this->url."users/{$user}/deactivate";
        return Http::auth('post', $url);
    }

    public function activate($user)
    {
        $url = $this->url."users/{$user}/activate";
        return Http::auth('post', $url);
    }

    /**
     * @see https://docs-im.easemob.com/im/server/ready/usermetadata#%E8%AE%BE%E7%BD%AE%E7%94%A8%E6%88%B7%E5%B1%9E%E6%80%A7
     *
     * @param string $accid 用户名
     * @param array $options
     *
     * @return array|bool|float|int|object|string|null
     */
    public function updateUserInfo(string $accid, array $options)
    {
        $url = $this->url.'metadata/user/'.$accid;

        return Http::auth('PUT', $url, $options);
    }

    /**
     * @see https://docs-im.easemob.com/im/server/ready/usermetadata#%E8%8E%B7%E5%8F%96%E7%94%A8%E6%88%B7%E5%B1%9E%E6%80%A7
     *
     * 获取用户属性
     *
     * @param string $accid 用户名
     *
     * @return array|bool|float|int|object|string|null
     */
    public function getUserInfo(string $accid)
    {
        $url = $this->url."metadata/user/$accid";
        return Http::auth('GET', $url);
    }
}
