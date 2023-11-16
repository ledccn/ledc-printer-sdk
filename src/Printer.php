<?php

namespace Ledc\PrinterSdk;

/**
 * 云打印SDK
 * @author david
 * @email 367013672@qq.com
 * @date 2023年11月16日
 */
class Printer
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * 构造函数
     * @param array $config
     */
    final public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * @param string $method 请求方法
     * @param string $url 请求URL
     * @param array $params 请求参数
     * @param bool $isJsonRequest
     * @return bool|array|null
     */
    protected function request(string $method, string $url, array $params, bool $isJsonRequest = false)
    {
        $method = strtoupper($method);
        if ($isJsonRequest) {
            $header = ['Content-Type: application/json; charset=UTF-8'];
            $data = json_encode($params, JSON_UNESCAPED_UNICODE);
        } else {
            $header = ['Content-Type: application/x-www-form-urlencoded; charset=UTF-8'];
            $data = http_build_query($params);
        }
        $header[] = Config::Authorization . ': ' . $this->builderAuthorization();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ('GET' === $method) {
            if (0 < count($params)) {
                //分隔符
                $_separator = false !== strpos($url, '?') ? '&' : '?';
                //GET请求参数是算作requestPath，不算body
                $url .= $_separator . http_build_query($params);
            }
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if (0 === stripos($url, 'https://')) {
            //false 禁止 cURL 验证对等证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //0 时不检查名称（SSL 对等证书中的公用名称字段或主题备用名称（Subject Alternate Name，简称 SNA）字段是否与提供的主机名匹配）
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->getConfig()->getTimeout());
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->getConfig()->getTimeout());
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    // 自动跳转，跟随请求Location
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);         // 递归次数
        // 代理配置
        if (getenv('CURLOPT_PROXY')) {
            curl_setopt($ch, CURLOPT_PROXY, getenv('CURLOPT_PROXY'));
        }
        $response = curl_exec($ch);
        $curl_error_code = curl_errno($ch);
        $curl_error_message = curl_error($ch);
        $curl_error = $curl_error_code !== 0;
        $http_status_code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $http_error = $http_status_code >= 400 && $http_status_code < 600;
        if ($this->getConfig()->getDebug() && ($curl_error || $http_error)) {
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
            'appid' => $this->getConfig()->getAppId(),
            'time' => $now,
            'token' => $this->getConfig()->getAppSecret(),
        ];
        return sprintf('appid=%s&time=%s&md5=%s', $this->getConfig()->getAppId(), $now, md5(http_build_query($origin)));
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param string $path
     * @param array $params
     * @return bool|array
     */
    public function get(string $path, array $params = [])
    {
        return $this->request('GET', $this->getConfig()->getDomain() . $path, $params);
    }

    /**
     * @param string $path
     * @param array $params
     * @return bool|array
     */
    public function post(string $path, array $params = [])
    {
        return $this->request('POST', $this->getConfig()->getDomain() . $path, $params);
    }

    /**
     * 获取打印机配置
     * @return array|bool|null
     */
    public function config()
    {
        return $this->get($this->getConfig()->getRoutePrefix() . '/config');
    }

    /**
     * 立刻打印
     * @param string $origin_id 商户订单号
     * @param int $task_id 打印任务ID
     * @param bool $preview 是否预览
     * @param array|string $documents 待打印的文档
     * @return array|bool|null
     */
    public function print(string $origin_id, int $task_id, bool $preview, $documents)
    {
        $params = [
            'origin_id' => $origin_id,
            'task_id' => $task_id,
            'preview' => $preview,
            'documents' => $documents
        ];
        return $this->post($this->getConfig()->getRoutePrefix() . '/print', $params);
    }
}
