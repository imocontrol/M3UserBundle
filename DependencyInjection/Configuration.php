<?php

namespace IMOControl\M3\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('imo_control_m3_user');
        
        $rootNode
			->children()
				->arrayNode('table')
            		->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('user_has_groups')->cannotBeEmpty()->defaultValue('%imoc_user_table.user_has_groups%')->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('user')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('IMOControl\M3\UserBundle\Admin\SystemUserAdmin')->end()
                                ->scalarNode('entity')->cannotBeEmpty()->defaultValue('Application\IMOControl\M3\UserBundle\Entity\SystemUser')->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('IMOControlM3UserBundle:Backend')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('default')->end()
                            ->end()
                        ->end()
                        ->arrayNode('user_group')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('IMOControl\M3\UserBundle\Admin\SystemUserGroupAdmin')->end()
                                ->scalarNode('entity')->cannotBeEmpty()->defaultValue('Application\IMOControl\M3\UserBundle\Entity\SystemGroup')->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('IMOControlM3UserBundle:Backend')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('default')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
