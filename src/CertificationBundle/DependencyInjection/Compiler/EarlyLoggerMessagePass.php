<?php


namespace CertificationBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EarlyLoggerMessagePass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $loggerDefinition = $container->findDefinition('logger');
        $loggerDefinition->addMethodCall('debug', ['Logger Created by MALU']);
    }

}