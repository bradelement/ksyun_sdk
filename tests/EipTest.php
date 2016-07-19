<?php
namespace Ksyun\Tests;
use Ksyun\Service\Eip;

class EipTest extends \PHPUnit_Framework_TestCase
{
    public function testDescribeAddresses()
    {
        $response = Eip::getInstance()->request('DescribeAddresses', [], 'cn-beijing-6');
        echo (string)$response->getBody();
        return $this->assertEquals($response->getStatusCode(), 200);
    }
}
