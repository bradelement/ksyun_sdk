<?php
/**
 * creator: maigohuang
 */ 
namespace Ksyun\Base;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class BaseCurl extends Singleton
{
    const DEFAULT_TIMEOUT = 5;
    protected $apiList = [];

    protected $client = null;
    protected $stack = null;

    protected function __construct()
    {
        $this->stack = new HandlerStack();
        $this->stack->setHandler(new CurlHandler());

        $config = $this->getConfig();
        $env = $config['host'] . 'Host';

        $this->client = new Client([
            'handler' => $this->stack,
            'base_uri' => $this->$env,
        ]);
    }

    abstract protected function getConfig();

    public function request($api, array $config = [])
    {
        $config_api = isset($this->apiList[$api]) ? $this->apiList[$api] : false;

        $defaultConfig = $this->getConfig();
        $config = $this->configMerge($defaultConfig['config'], $config_api['config'], $config);
        $info = array_merge($defaultConfig, $config_api);
        $info['config'] = $config;
        $this->replace($info);

        $method = $info['method'];
        try {
            $response = $this->client->request($method, $info['url'], $info['config']);
            //$result = (string)$response->getBody();
            //$httpCode = $response->getStatusCode();
            return $response;
        }catch(ClientException $exception) {
            //$result = (string)$exception->getResponse()->getBody();
            //$httpCode = $exception->getResponse()->getStatusCode();
            return $exception->getResponse();
        }
    }

    private function configMerge($c1, $c2, $c3)
    {
        $result = $c1;
        foreach ($c2 as $k=>$v) {
            if (isset($result[$k]) && is_array($result[$k]) && is_array($v)) {
                $result[$k] = array_merge($result[$k], $v);
            }else {
                $result[$k] = $v;
            }
        }

        foreach ($c3 as $k=>$v) {
            if (is_array($result[$k]) && is_array($v)) {
                $result[$k] = array_merge($result[$k], $v);
            }else {
                $result[$k] = $v;
            }
        }
        return $result;
    }

    private function replace(&$options)
    {
        if (isset($options['config']['replace']) && is_array($options['config']['replace'])) {
            $url = $options['url'];
            $params = $options['replace'];
            $url = preg_replace_callback('({[0-9a-zA-Z-_]+})', function($matched) use($params) {
                $key = substr($matched[0], 1, strlen($matched[0]) - 2);
                if (isset($params[$key])) {
                    $ret = $params[$key];
                    unset($params[$key]);
                    return $ret;
                }else {
                    return '';
                }
            }, $url);
            $options['url'] = $url;
        }
    }
}
