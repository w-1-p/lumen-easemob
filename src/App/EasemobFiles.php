<?php
// +----------------------------------------------------------------------
// | Author: wyp. Date:2021/6/18 Time:20:31
// +----------------------------------------------------------------------

namespace W1p\LumenEasemob\App;

trait EasemobFiles
{
    /***********************   文件上传下载   **********************************/

    /**
     * 上传文件
     *
     * @param $file_path
     *
     * @return mixed
     * @throws EasemobError
     */
    public function uploadFile($file_path)
    {
        if ( ! is_file($file_path)) {
            throw new EasemobError('文件不存在', 404);
        }
        $url = $this->url.'chatfiles';

        $curl_file    = curl_file_create($file_path);
        $option       = [
            'file' => $curl_file,
        ];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;

        return Http::postCurl($url, $option, $header, 'POST');
    }


    /**
     * 下载文件
     *
     * @param $uuid         [uuid]
     * @param $share_secret [秘钥]
     *
     * @return mixed
     */
    public function downloadFile($uuid, $share_secret)
    {
        $url = $this->url.'chatfiles/'.$uuid;

        $option       = [];
        $access_token = $this->getToken();
        $header []    = 'Authorization: Bearer '.$access_token;
        $header []    = 'share-secret: '.$share_secret;

        return Http::postCurl($url, $option, $header, 'GET', 10, false);
    }
}
