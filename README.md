# Integrate EditorJS into your EasyAdmin application

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]

## Installation

To install this bundle, simply run:

```shell
composer require setono/easyadmin-editorjs-bundle
```

### Add route configuration

Add a route import inside `config/routes`:

```yaml
# config/routes/setono_easyadmin_editorjs.yaml
setono_easyadmin_editorjs:
    resource: "@SetonoEasyadminEditorjsBundle/Resources/config/routes.yaml"
```

## Usage

When configuring your fields in your crud controller, add an `EditorJSField` like this:

```php
public function configureFields(string $pageName): iterable
{
    // ...
    
    yield EditorJSField::new('content')
        ->addHeaderTool(2)
        ->addListTool()
        ->addQuoteTool()
    ;
    
    // ...
}
```

[ico-version]: https://poser.pugx.org/setono/easyadmin-editorjs-bundle/v/stable
[ico-license]: https://poser.pugx.org/setono/easyadmin-editorjs-bundle/license
[ico-github-actions]: https://github.com/Setono/easyadmin-editorjs-bundle/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/easyadmin-editorjs-bundle/branch/master/graph/badge.svg

[link-packagist]: https://packagist.org/packages/setono/easyadmin-editorjs-bundle
[link-github-actions]: https://github.com/Setono/easyadmin-editorjs-bundle/actions
[link-code-coverage]: https://codecov.io/gh/Setono/easyadmin-editorjs-bundle
