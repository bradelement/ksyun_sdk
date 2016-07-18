<?php
namespace Ksyun\Tests;
use Ksyun\Service\Iam;

class IamTest extends \PHPUnit_Framework_TestCase
{
    public function testListIamUsers()
    {
        $response = Iam::getInstance()->request('ListUsers');
        $result = (string)$response->getBody();
        echo $result;
    }
}
