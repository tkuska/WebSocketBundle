<?php

namespace Gos\Bundle\WebSocketBundle\Tests;

use Gos\Bundle\WebSocketBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    public function testContextConfigurationIsOptional()
    {
        /* Config:
         *
         * server:
         *   host: "127.0.0.1"
         *   port: "8080"
         */
        $configs = [
            [
                'server' => [
                    'host' => "127.0.0.1",
                    'port' => "8080",
                ],
            ],
        ];

        $config = $this->process($configs);

        $this->assertEquals('127.0.0.1', $config['server']['host']);
        $this->assertEquals('8080', $config['server']['port']);
    }

    /**
     * Processes an array of configurations and returns a compiled version.
     *
     * @param array $configs An array of raw configurations
     *
     * @return array A normalized array
     */
    protected function process($configs)
    {
        return (new Processor())->processConfiguration(new Configuration(), $configs);
    }

    public function testTokenSeparatorIsSet()
    {
        /*
         * Config:
         *
         * server:
         *   host: "127.0.0.1"
         *   port: "8080"
         *   router:
         *     context:
         *       tokenSeparator: "-"
         */
        $configs = [
            [
                'server' => [
                    'host' => "127.0.0.1",
                    'port' => "8080",
                    'router' => [
                        'context' => [
                            "tokenSeparator" => "/",
                        ],
                    ],
                ],
            ],
        ];

        $config = $this->process($configs);

        $this->assertEquals(
            '/',
            $config['server']['router']['context']['tokenSeparator']
        );
    }
}
