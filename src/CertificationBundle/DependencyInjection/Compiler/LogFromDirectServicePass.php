<?php


namespace CertificationBundle\DependencyInjection\Compiler;


use CertificationBundle\MaluService\DirectServiceDefinitionService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LogFromDirectServicePass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $myService = $container->findDefinition(DirectServiceDefinitionService::class);
        $myService->addMethodCall('logEarly');
    }

}