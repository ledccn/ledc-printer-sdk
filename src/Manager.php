<?php

namespace Ledc\PrinterSdk;

use Exception;

/**
 * 云打印管理器
 */
class Manager
{
    /**
     * 包含协议、域名、端口的完整地址
     * @var string
     */
    protected $domain;
    /**
     * 路由前缀，接入点
     * @var string
     */
    protected $route_prefix = '/app/printer/manager';
    /**
     * 管理者身份ID
     * @var int
     */
    protected $id_number;
    /**
     * 管理者密钥
     * @var string
     */
    protected $passphrase;
    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * 构造函数
     * @param array $config
     */
    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * 创建打印机应用
     * @param string $title 打印机标题
     * @param string $description 打印机描述
     * @param string $callback_url 打印机回调URL
     * @return array|false
     * @throws Exception
     */
    public function create(string $title, string $description, string $callback_url)
    {
        $response = $this->post($this->domain . $this->route_prefix . '/printer/create', compact('title', 'description', 'callback_url'));
        if ($this->isSuccess($response)) {
            return $response['data'];
        }

        if ($this->debug) {
            var_dump($response);
            $code = $response['code'] ?? 'code空';
            $msg = $response['msg'] ?? 'msg空';
            throw new Exception($msg, $code);
        }
        return false;
    }

    /**
     * 删除打印机应用
     * @return void
     */
    public function delete(int $app_id)
    {
    }

    /**
     * 判断响应结果是否为成功
     * @param bool|array|null $response
     * @return bool
     */
    public function isSuccess($response): bool
    {
        return isset($response['code']) && isset($response['data']) && 0 === $response['code'] && is_array($response['data']);
    }

    /**
     * POST请求
     * @param string $url 请求URL
     * @param array $params 请求参数
     * @param bool $isJsonRequest
     * @return bool|array|null
     */
    protected function post(string $url, array $params, bool $isJsonRequest = false)
    {
        echo $url . PHP_EOL;
        ksort($params);
        $params['hash'] = hash_hmac('sha1', http_build_query($params), $this->passphrase);
        if ($isJsonRequest) {
            $header = ['Content-Type: application/json; charset=UTF-8'];
            $data = json_encode($params, JSON_UNESCAPED_UNICODE);
        } else {
            $header = ['Content-Type: application/x-www-form-urlencoded; charset=UTF-8'];
            $data = http_build_query($params);
        }
        $ch = curl_init();
        $header[] = Config::Authorization . ': ' . $this->builderAuthorization();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        if (0 === stripos($url, 'https://')) {
            //false 禁止 cURL 验证对等证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //0 时不检查名称（SSL 对等证书中的公用名称字段或主题备用名称（Subject Alternate Name，简称 SNA）字段是否与提供的主机名匹配）
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $response = curl_exec($ch);
        $curl_error_code = curl_errno($ch);
        $curl_error_message = curl_error($ch);
        $curl_error = $curl_error_code !== 0;
        $http_status_code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $http_error = $http_status_code >= 400 && $http_status_code < 600;
        if ($this->debug && ($curl_error || $http_error)) {
            $header_out = curl_getinfo($ch, CURLINFO_HEADER_OUT);
            var_dump(compact('curl_error_code', 'curl_error_message', 'http_status_code', 'header_out', 'response'));
        }
        curl_close($ch);
        return is_string($response) ? json_decode($response, true) : $response;
    }

    /**
     * 构造请求头
     * @return string
     */
    protected function builderAuthorization(): string
    {
        $now = time();
        $origin = [
            'id_number' => $this->id_number,
            'time' => $now,
            'passphrase' => $this->passphrase,
        ];
        return sprintf('id_number=%s&time=%s&md5=%s', $this->id_number, $now, md5(http_build_query($origin)));
    }
}
