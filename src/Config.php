<?php

namespace Ledc\PrinterSdk;

use Exception;
use RuntimeException;

/**
 * 配置管理类
 */
class Config
{
    /**
     * 附加的请求头验证字段
     */
    const Authorization = 'Authorization';
    /**
     * 包含协议、域名、端口的完整地址
     * @var string
     */
    protected $domain;
    /**
     * 应用凭证
     * @var int
     */
    protected $app_id;
    /**
     * 应用密钥
     * @var string
     */
    protected $app_secret;
    /**
     * 超时，单位：秒
     * @var int
     */
    protected $timeout = 5;
    /**
     * 路由前缀，接入点
     * @var string
     */
    protected $route_prefix = '/app/printer';
    /**
     * 调试模式
     * @var bool
     */
    protected $debug = false;

    /**
     * 构造函数
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        $this->checkRequire();
    }

    /**
     * 生成app.config配置文件
     * @param array $config
     * @return string
     * @throws Exception
     */
    public static function generateAppConfig(array $config): string
    {
        $config = new static($config);
        $search = [
            '{{gethost_url}}' => rtrim($config->getDomain(), '/') . $config->getRoutePrefix() . '/config',
            '{{app_id}}' => $config->app_id,
            '{{app_secret}}' => $config->app_secret,
        ];
        return strtr(file_get_contents(__DIR__ . '/app.config'), $search);
    }

    /**
     * 检查必须的属性
     * @return void
     * @throws Exception
     */
    protected function checkRequire()
    {
        foreach (get_object_vars($this) as $key => $value) {
            if (null === $value || '' === $value) {
                throw new RuntimeException('缺少配置：' . $key);
            }
        }
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * 应用凭证
     * @return int
     */
    public function getAppId(): int
    {
        return $this->app_id;
    }

    /**
     * 应用密钥
     * @return string
     */
    public function getAppSecret(): string
    {
        return $this->app_secret;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @return string
     */
    public function getRoutePrefix(): string
    {
        return $this->route_prefix;
    }

    /**
     * @return bool
     */
    public function getDebug(): bool
    {
        return $this->debug;
    }
}