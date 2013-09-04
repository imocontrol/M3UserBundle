<?php

namespace IMOControl\M3\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IMOControl\M3\UserBundle\DependencyInjection\Compiler\ModifyCompilerPass;

class IMOControlM3UserBundle extends Bundle
{

	/**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ModifyCompilerPass());
    }
}
