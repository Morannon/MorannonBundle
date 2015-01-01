<?php

namespace Morannon\Bundle\MorannonBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MorannonExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $gateways = array();
        foreach ($config['gateways'] as $name => $options) {
            $gateways[] = $name;

            // build definition
            $definition = new DefinitionDecorator('morannon.gateways.abstract');
            $definition->setClass('%morannon.gateways.' . $name . '.class%');
            $definition->addArgument('%morannon.gateways.' . $name . '.api_base_url%');
            $definition->addArgument('%morannon.gateways.' . $name . '.api_user%');
            $definition->addArgument('%morannon.gateways.' . $name . '.api_token%');

            // add definition to container
            $container->setDefinition('morannon.gateways.' . $name, $definition);

            // add config as params to container
            foreach ($options as $key => $value) {
                $container->setParameter('morannon.gateways.' . $name . '.' . $key, $value);
            }
        }
        $container->setParameter('morannon.gateways.all', $gateways);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
