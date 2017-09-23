<?php


namespace CertificationBundle\DependencyInjection;


use CertificationBundle\MaluService\DirectServiceDefinitionService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class CertificationExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loggerReference = new Reference('logger');

        $maluService = new Definition(
            DirectServiceDefinitionService::class,
            [$loggerReference, $config['sub']['scalarValue']]
        );

        $container->addDefinitions(
            [DirectServiceDefinitionService::class => $maluService]
        );
    }

}