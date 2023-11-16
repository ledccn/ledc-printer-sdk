<?php

namespace Ledc\PrinterSdk;

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
    protected $route_prefix = '/printer';
    /**
     * 调试模式
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
        $this->checkRequire();
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