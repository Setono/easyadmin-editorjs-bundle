<?php

declare(strict_types=1);

namespace Setono\EasyadminEditorjsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * @template T
 *
 * @extends AbstractType<T>
 */
final class EditorJSType extends AbstractType
{
    public function getParent(): string
    {
        return TextareaType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_easyadmin_editorjs';
    }
}
