<?php


namespace Oh86\NetEasy\Captcha;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CaptchaVerify
{
    private $secret_id;
    private $secret_key;
    private $captcha_id;

    public function __construct($secret_id, $secret_key, $captcha_id)
    {
        $this->secret_id = $secret_id;
        $this->secret_key = $secret_key;
        $this->captcha_id = $captcha_id;
    }

    /**
     * @param string $validate
     * @param string $user
     * @return bool
     */
    public function verify(string $validate, string $user = ''): bool
    {
        $params = array();
        $params["captchaId"] = $this->captcha_id;
        $params["validate"] = $validate;
        $params["user"] = $user;
        // 公共参数
        $params["version"] = 'v2';
        $params["nonce"] = uniqid();
        $params["timestamp"] = sprintf("%d", round(microtime(true) * 1000));// time in milliseconds
        $params["secretId"] = $this->secret_id;
        $params["signature"] = $this->sign($this->secret_key, $params);

        $url = 'https://c.dun.163.com/api/v2/verify';

        $http = new Client(['timeout' => 10]);

        try {
            $response = $http->post($url, [
                'form_params' => $params,
            ]);

            $res = (string)$response->getBody();
        } catch (\Exception $e) {
            Log::error(__METHOD__, [
                'url' => $url,
                'params' => $params,
                'error' => $e->getMessage(),
            ]);

            // throw $e;
            return false;
        }

        /**
         * {
         * "result": true,
         * "error": 0,
         * "msg": "ok",
         * "phone": "",
         * "extraData": "",
         * "captchaType": 2,
         * "token": "xxx",
         * "sdkReduce": false
         * }
         */
        $arr = json_decode($res, true);

        if (!isset($arr['result']) || !isset($arr['error']) || $arr['error'] != 0) {
            Log::error(__METHOD__, [
                'error' => 'captcha verify error',
                'params' => $params,
                'response' => $res,
            ]);

            return false;
        }

        return $arr['result'];
    }

    /**
     * 生成签名信息
     * $secret_key 产品私钥
     * $params 接口请求参数，不包括signature参数
     * @return string
     */
    private function sign($secret_key, $params)
    {
        ksort($params); // 参数排序
        $buff = "";
        foreach ($params as $key => $value) {
            $buff .= $key;
            $buff .= $value;
        }
        $buff .= $secret_key;
        return md5(mb_convert_encoding($buff, "utf8", "auto"));
    }
}