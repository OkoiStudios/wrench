<?php

namespace Wrench;

use Wrench\Application\EchoApplication;
use Wrench\Test\BaseTest;

/**
 * Tests the ConnectionManager class
 */
class ConnectionManagerTest extends BaseTest
{
    /**
     * Tests the constructor
     *
     * @dataProvider getValidConstructorArguments
     */
    public function testValidConstructorArguments($server, array $options)
    {
        $this->assertInstanceOfClass(
            $instance = $this->getInstance(
                $server,
                $options
            ),
            'Valid constructor arguments'
        );
    }

    /**
     * Tests the constructor
     */
    public function testConstructor()
    {
        $this->assertInstanceOfClass(
            $instance = $this->getInstance(
                $this->getMockServer(),
                []
            ),
            'Constructor'
        );
        return $instance;
    }

    /**
     * Gets a mock server
     */
    protected function getMockServer()
    {
        $server = $this->createMock('\Wrench\Server');

        $server->registerApplication('/echo', $this->getMockApplication());

        $server->expects($this->any())
            ->method('getUri')
            ->will($this->returnValue('ws://localhost:8000/'));

        return $server;
    }

    /**
     * Gets a mock application
     *
     * @return EchoApplication
     */
    protected function getMockApplication()
    {
        return new EchoApplication();
    }

    /**
     * @depends testConstructor
     * @param ConnectionManager $instance
     */
    public function testCount($instance)
    {
        $this->assertTrue(is_numeric($instance->count()));
    }

    /**
     * Data provider
     */
    public function getValidConstructorArguments()
    {
        return [
            [$this->getMockServer(), []],
        ];
    }
}
