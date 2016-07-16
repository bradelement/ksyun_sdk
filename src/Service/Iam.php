<?php
namespace Ksyun\Service;

use Ksyun\Base\V4Curl;
class Iam extends V4Curl 
{
    protected function getConfig()
    {
        return [
            'host' => 'https://iam.api.ksyun.com',
            'timeout' => 5,
            'config' => [
                'headers' => [
                ],
                /*
                'v4_credentials' => [
                    'ak' => 'AKLT2mjX47yFSp2leXlY8h0dVA',
                    'sk' => 'ODFsox160Mo4Qz3PX5zyYmIbmxFx4qhfbRBxtBH7urMolwxLxUdUoN+oPt5lRaMt8w==',
                    'region' => 'cn-beijing-1',
                    'service' => 'iam',
                ],
                 */
            ],
        ];
    }

    protected $apiList = [
        'temp' => [
            'url' => '/',
            'method' => 'get',
            'config' => [
                'query' => [
                    'Action' => 'CreateTempAK',
                ],
            ],
        ],
    ];
}

