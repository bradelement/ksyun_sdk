<?php
/**
 * creator: maigoxin
 */
namespace Ksyun\Service;

use Ksyun\Base\V4Curl;
class Vpc extends V4Curl
{
    protected function getConfig()
    {
        return [
            'host' => 'https://vpc.{region}.api.ksyun.com',
            'timeout' => 5,
            'config' => [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'v4_credentials' => [
                    'service' => 'vpc',
                ],
            ],
        ];
    }

    public function request($api, array $config = [], $region = 'cn-beijing-6')
    {
        $config['v4_credentials']['region'] = $region;
        $config['replace']['region'] = $region;
        return parent::request($api, $config);
    }

    protected $apiList = [
        '' => [
            'url' => '/',
            'method' => 'get',
            'config' => [
                'query' => [
                    'Action' => '',
                    'Version' => '2016-03-04'
                ]
            ],
        ],
    ];
}
