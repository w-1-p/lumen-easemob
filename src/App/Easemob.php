<?php

namespace W1p\LumenEasemob\App;

use Cache;

class Easemob
{
    // 缓存的名称
    const CACHE_NAME = 'easemob';

    // 接口地址域名
    public $domain_name = null;

    // 企业的唯一标识
    public $org_name = null;

    // “APP”唯一标识
    public $app_name = null;

    // 客户ID
    public $client_id = null;

    // 客户秘钥
    public $client_secret = null;

    // token缓存时间
    public $token_cache_time = null;

    // url地址
    public $url = null;

    // 目标数组 用户，群，聊天室
    public $target_array = ['users', 'chatgroups', 'chatrooms'];

    /***********************   用户   **********************************/
    use EasemobUsers;

    /***********************   好友   **********************************/
    use EasemobFriends;

    /***********************   发送消息   **********************************/
    use EasemobMessages;

    /***********************   群管理   **********************************/
    use EasemobGroups;

    /***********************   聊天室管理   **********************************/
    use EasemobRooms;

    /***********************   文件操作   **********************************/
    use EasemobFiles;

    public function __construct()
    {
        $this->domain_name = config('easemob.domain_name');
        $this->org_name = config('easemob.org_name');
        $this->app_name = config('easemob.app_name');
        $this->client_id = config('easemob.client_id');
        $this->client_secret = config('easemob.client_secret');
        $this->token_cache_time = config('easemob.token_cache_time');
        $this->url = sprintf('%s/%s/%s/', $this->domain_name, $this->org_name, $this->app_name);
    }

    /***********************   token操作   **********************************/

    /**
     * 返回token
     *
     * @return mixed
     */
    public function getToken()
    {
        if (Cache::has(self::CACHE_NAME)) {
            return Cache::get(self::CACHE_NAME);
        } else {
            $url = $this->url."token";
            $option = [
                'grant_type' => 'client_credentials',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
            ];
            $return = Http::postCurl($url, $option);
            Cache::put(self::CACHE_NAME, $return['access_token'], (int)($return['expires_in'] / 60));

            return $return['access_token'];

        }
    }

    /**
     * 字符串替换
     *
     * @param $string
     *
     * @return mixed
     */
    protected static function stringReplace($string)
    {
        $string = str_replace('\\', '', $string);
        $string = str_replace(' ', '+', $string);

        return $string;
    }
}
