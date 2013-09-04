<?php

namespace IMOControl\M3\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IMOControlM3UserExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin_services.yml');
        
        $this->initApplicationConfig($config, $container);
        $this->registerDoctrineMapping($config);
        
    }
    
    protected function initApplicationConfig($config, $container) 
	{
		$container->setParameter('imocontrol.user.admin.class', $config['admin']['user']['class']);
		$container->setParameter('imocontrol.user.admin.entity.class', $config['admin']['user']['entity']);
		$container->setParameter('imocontrol.user.admin.controller.class', $config['admin']['user']['controller']);
		$container->setParameter('imocontrol.user.admin.translation', $config['admin']['user']['translation']);
		
		$container->setParameter('imocontrol.user_group.admin.class', $config['admin']['user_group']['class']);
		$container->setParameter('imocontrol.user_group.admin.entity.class', $config['admin']['user_group']['entity']);
		$container->setParameter('imocontrol.user_group.admin.controller.class', $config['admin']['user_group']['controller']);
		$container->setParameter('imocontrol.user_group.admin.translation', $config['admin']['user_group']['translation']);
	}
	
	/**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['admin']['user']['entity'], 'mapManyToMany', array(
            'fieldName'       => 'groups',
            'targetEntity'    => $config['admin']['user_group']['entity'],
            'cascade'         => array( ),
            'joinTable'       => array(
                'name' => $config['table']['user_has_groups'],
                'joinColumns' => array(
                    array(
                        'name' => 'user_id',
                        'referencedColumnName' => 'id',
                        'onDelete' => 'CASCADE'
                    ),
                ),
                'inverseJoinColumns' => array( array(
                    'name' => 'group_id',
                    'referencedColumnName' => 'id',
                    'onDelete' => 'CASCADE'
                )),
            )
        ));
    }

	
	
}
