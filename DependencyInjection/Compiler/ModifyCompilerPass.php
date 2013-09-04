<?php
namespace IMOControl\M3\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ModifyCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->removeDefinition('sonata.user.admin.user');
        $container->removeDefinition('sonata.user.admin.group');
        $container->setAlias('sonata.user.admin.user', 'imocontrol.system_user');
		$container->setAlias('sonata.user.admin.group', 'imocontrol.system_user_group');
    }
}
