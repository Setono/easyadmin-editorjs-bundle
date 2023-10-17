<?php

declare(strict_types=1);

namespace Setono\EasyadminEditorjsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_easyadmin_editorjs');
        $rootNode = $treeBuilder->getRootNode();

        /** @psalm-suppress PossiblyNullReference,MixedMethodCall,UndefinedInterfaceMethod */
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('tools')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('image')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('upload_directory')
                                    ->info('The directory where images are uploaded. Make sure this directory is writable.')
                                    ->defaultValue('%kernel.project_dir%/public/images/uploaded')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('upload_path')
                                    ->info('The public path where images are uploaded.')
                                    ->defaultValue('/images/uploaded')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('upload_image_by_file_route')
                                    ->defaultValue('setono_easyadmin_editorjs_upload_image_by_file')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('upload_image_by_url_route')
                                    ->defaultValue('setono_easyadmin_editorjs_upload_image_by_url')
                                    ->cannotBeEmpty()
        ;

        return $treeBuilder;
    }
}
