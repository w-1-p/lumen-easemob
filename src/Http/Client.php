<?php

namespace W1p\LumenEasemob\Http;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use W1p\LumenEasemob\Services\BaseService;
use GuzzleHttp\Client as GuzzleClient;
use W1p\LumenEasemob\Facades\Easemob;

class Client
{
    /**
     * @param string $method
     * @param $url
     * @param array $data
     * @param int $second
     * @param array $header
     *
     * @return array|bool|float|int|object|string|null
     */
    public static function auth($method, $url, $data = [], $second = 30, $header = [])
    {
        $method = strtoupper($method);
        $token = Easemob::user()->getAccessToken();
        $header['Authorization'] = 'Bearer '.$token;
        $header['Content-Type'] = 'application/x-www-form-urlencoded';
        $header['Accept'] = 'application/json';

        /**
         * @var Client $client
         */
        $client = app('easemob.http');
        $options = [
            'headers' => $header,
            'timeout' => $second,
        ];

        if ($method == 'GET' && !empty($data)) {
            $url .= (stripos($url, '?') === false ? '?' : '&');
            $url .= (is_array($data) ? http_build_query($data) : $data);
        }
        if ($method != 'GET' && !empty($data)) {
            $options['form_params'] = $data;
        }

        if (config('app.debug')) {
            Log::info(str_repeat('-', 120));
            Log::debug('环信请求信息:', $options);
        }

        $response = $client->request($method, $url, $options);
        if ($response->getStatusCode() == 401) {
            Cache::pull(BaseService::CACHE_NAME);
        }
        $content = $response->getBody()->getContents();
        if (config('app.debug')) {
            Log::debug($url);
            Log::debug($content);
            Log::info(str_repeat('-', 120));
        }
        return $response->getStatusCode() == 200 ? \GuzzleHttp\json_decode($content, 1) : $response;
    }

    public static function json($url, $data = [], $second = 30, $header = [])
    {
        /**
         * @var GuzzleClient $client
         */
        $client = app('easemob.http');
        $response = $client->post($url, [
            'headers' => $header,
            'timeout' => $second,
            'json' => $data,
        ]);
        return $response->getStatusCode() == 200 ? $response->getBody()->getContents() : false;
    }
}
