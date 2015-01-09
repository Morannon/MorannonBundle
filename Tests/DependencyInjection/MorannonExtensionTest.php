<?php

namespace Morannon\Bundle\MorannonBundle\Tests\DependencyInjection;

use Morannon\Bundle\MorannonBundle\DependencyInjection\MorannonExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MorannonExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MorannonExtension
     */
    private $extension;

    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    private $config = array(
        0 => array(
            'gateways' => array(
                'nexmo' => array(
                    'api_base_url' => 'http://base.url/api/',
                    'api_user' => 'thisismyapiuser',
                    'api_token' => 'thisismyapitoken',
                ),
                'whatever_mobile' => array(
                    'api_base_url' => 'http://base.url/api/',
                    'api_user' => 'thisismyapiuser',
                    'api_token' => 'thisismyapitoken',
                )
            )
        )
    );

    public function setUp()
    {
        $this->extension = new MorannonExtension();
        $this->containerBuilder = new ContainerBuilder();
    }

    public function testServicesAreCreated()
    {
        $this->extension->load($this->config, $this->containerBuilder);

        $definitions = $this->containerBuilder->getDefinitions();
        $this->assertEquals(6, count($definitions));

        $this->assertTrue($this->containerBuilder->hasDefinition('morannon.gateways.nexmo'));
        $this->assertTrue($this->containerBuilder->hasDefinition('morannon.gateways.whatever_mobile'));
    }

    public function testParametersAreCreated()
    {
        $this->extension->load($this->config, $this->containerBuilder);

        $parameters = $this->containerBuilder->getParameterBag();

        $this->assertTrue($parameters->has('morannon.gateways.all'));

        $this->assertTrue($parameters->has('morannon.gateways.nexmo.api_base_url'));
        $this->assertTrue($parameters->has('morannon.gateways.nexmo.api_user'));
        $this->assertTrue($parameters->has('morannon.gateways.nexmo.api_token'));

        $this->assertTrue($parameters->has('morannon.gateways.whatever_mobile.api_base_url'));
        $this->assertTrue($parameters->has('morannon.gateways.whatever_mobile.api_user'));
        $this->assertTrue($parameters->has('morannon.gateways.whatever_mobile.api_token'));
    }
}
