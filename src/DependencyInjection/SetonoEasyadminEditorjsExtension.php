<?php

declare(strict_types=1);

namespace Setono\EasyadminEditorjsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoEasyadminEditorjsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         *
         * @var array{tools: array{image: array{upload_directory: string, upload_path: string, upload_image_by_file_route: string, upload_image_by_url_route: string}}} $config
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('setono_easyadmin_editorjs.tools', $config['tools']);
        $container->setParameter('setono_easyadmin_editorjs.tools.image.upload_directory', $config['tools']['image']['upload_directory']);
        $container->setParameter('setono_easyadmin_editorjs.tools.image.upload_path', $config['tools']['image']['upload_path']);
        $container->setParameter('setono_easyadmin_editorjs.tools.image.upload_image_by_file_route', $config['tools']['image']['upload_image_by_file_route']);
        $container->setParameter('setono_easyadmin_editorjs.tools.image.upload_image_by_url_route', $config['tools']['image']['upload_image_by_url_route']);

        $loader->load('services.xml');
    }
}
