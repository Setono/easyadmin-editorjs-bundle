<?php

declare(strict_types=1);

namespace Setono\EasyadminEditorjsBundle\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Setono\EasyadminEditorjsBundle\Form\Type\EditorJSType;
use Webmozart\Assert\Assert;

final class EditorJSField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_EDITORJS_CONFIG = 'editorjsConfig';

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(EditorJSType::class)
            ->addJsFiles(
                'https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.26.5/dist/editor.min.js',
                '/bundles/setonoeasyadmineditorjs/field-editorjs.js',
            )
            ->addCssFiles('/bundles/setonoeasyadmineditorjs/field-editorjs.css', )
            ->addFormTheme('@SetonoEasyadminEditorjs/form_theme/field_editorjs.html.twig')
            ->setTemplatePath('@SetonoEasyadminEditorjs/crud/field/editorjs.html.twig')
            ->setCustomOption(self::OPTION_EDITORJS_CONFIG, [])
            ->setRequired(false) // todo has to be fixed later
        ;
    }

    public function addDelimiterTool(): self
    {
        return $this
            ->addJsFiles('https://cdn.jsdelivr.net/npm/@editorjs/delimiter@1.3.0/dist/bundle.min.js')
            ->addTool('delimiter', [
                'class' => 'Delimiter',
            ])
        ;
    }

    public function addEmbedTool(): self
    {
        return $this
            ->addJsFiles('https://cdn.jsdelivr.net/npm/@editorjs/embed@2.5.3/dist/bundle.min.js')
            ->addTool('embed', [
                'class' => 'Embed',
            ])
        ;
    }

    public function addHeaderTool(int $defaultLevel = 1, array $levels = [1, 2, 3]): self
    {
        return $this
            ->addJsFiles('https://cdn.jsdelivr.net/npm/@editorjs/header@2.7.0/dist/bundle.min.js')
            ->addTool('header', [
                'class' => 'Header',
                'config' => [
                    'levels' => $levels,
                    'defaultLevel' => $defaultLevel,
                ],
            ])
        ;
    }

    public function addImageTool(): self
    {
        return $this
            ->addJsFiles('https://cdn.jsdelivr.net/npm/@editorjs/image@2.8.1/dist/bundle.min.js')
            ->addTool('image', [
                'class' => 'ImageTool',
            ])
        ;
    }

    public function addListTool(): self
    {
        return $this
            ->addJsFiles('https://cdn.jsdelivr.net/npm/@editorjs/list@1.8.0/dist/bundle.min.js')
            ->addTool('list', [
                'class' => 'List',
            ])
        ;
    }

    public function addQuoteTool(): self
    {
        return $this
            ->addJsFiles('https://cdn.jsdelivr.net/npm/@editorjs/quote@2.5.0/dist/bundle.min.js')
            ->addTool('quote', [
                'class' => 'Quote',
            ])
        ;
    }

    public function addRawTool(): self
    {
        return $this
            ->addJsFiles('https://cdn.jsdelivr.net/npm/@editorjs/raw@2.4.0/dist/bundle.min.js')
            ->addTool('raw', [
                'class' => 'RawTool',
            ])
        ;
    }

    /**
     * @param array{class: string, config?: array} $config
     */
    public function addTool(string $key, array $config): self
    {
        $existingConfig = $this->dto->getCustomOption(self::OPTION_EDITORJS_CONFIG);
        Assert::isArray($existingConfig);

        $this->setCustomOption(self::OPTION_EDITORJS_CONFIG, array_merge_recursive($existingConfig, [
            'tools' => [
                $key => $config,
            ],
        ]));

        return $this;
    }
}
