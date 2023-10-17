<?php

declare(strict_types=1);

namespace Setono\EasyadminEditorjsBundle\Field\Configurator;

use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use Setono\EasyadminEditorjsBundle\Field\EditorJSField;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class EditorJSConfigurator implements FieldConfiguratorInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly string $uploadImageByFileRoute,
        private readonly string $uploadImageByUrlRoute,
    ) {
    }

    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return EditorJSField::class === $field->getFieldFqcn();
    }

    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        /** @var array{tools: array{image: array{config: array{endpoints: array{byFile: string, byUrl: string}}}}} $config */
        $config = $field->getCustomOption(EditorJSField::OPTION_EDITORJS_CONFIG);

        if (!isset($config['tools']['image'])) {
            return;
        }

        $config['tools']['image']['config']['endpoints']['byFile'] = $this->urlGenerator->generate($this->uploadImageByFileRoute);
        $config['tools']['image']['config']['endpoints']['byUrl'] = $this->urlGenerator->generate($this->uploadImageByUrlRoute);

        $field->setCustomOption(EditorJSField::OPTION_EDITORJS_CONFIG, $config);
    }
}
