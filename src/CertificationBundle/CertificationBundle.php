<?php


namespace CertificationBundle;


use CertificationBundle\DependencyInjection\Compiler\EarlyLoggerMessagePass;
use CertificationBundle\DependencyInjection\Compiler\LogFromDirectServicePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CertificationBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new EarlyLoggerMessagePass());
        $container->addCompilerPass(new LogFromDirectServicePass());
    }

}