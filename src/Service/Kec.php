<?php
/**
 * creator: maigoxin
 */
namespace Ksyun\Service;

use Ksyun\Base\V4Curl;
class Kec extends V4Curl
{
    protected function getConfig()
    {
        return [
            'host' => 'https://kec.{region}.api.ksyun.com',
            'timeout' => 5,
            'config' => [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'v4_credentials' => [
                    'service' => 'kec',
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
        'DescribeInstances' => [
            'url' => '/',
            'method' => 'get',
            'config' => [
                'query' => [
                    'Action' => 'DescribeInstances',
                    'Version' => '2016-03-04'
                ]
            ],
        ],
    ];
}
