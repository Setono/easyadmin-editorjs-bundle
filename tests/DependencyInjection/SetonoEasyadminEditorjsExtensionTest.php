<?php

declare(strict_types=1);

namespace Setono\EasyadminEditorjsBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\EasyadminEditorjsBundle\DependencyInjection\SetonoEasyadminEditorjsExtension;

final class SetonoEasyadminEditorjsExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoEasyadminEditorjsExtension(),
        ];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_easyadmin_editorjs.tools', [
            'image' => [
                'upload_directory' => '%kernel.project_dir%/public/images/uploaded',
                'upload_path' => '/images/uploaded',
                'upload_image_by_file_route' => 'setono_easyadmin_editorjs_upload_image_by_file',
                'upload_image_by_url_route' => 'setono_easyadmin_editorjs_upload_image_by_url',
            ],
        ]);
    }
}
