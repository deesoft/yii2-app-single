`themes\Theme`
--------------

```php
'components' => [
    ...
    'view' => [
        'theme' => [
            'class' => 'themes\Theme',
            'default' => 'adminlte',
            'themes' => [
                'adminlte' => '@themes/adminlte', // <- basePath
                'metro' => 'themes\metro\Theme', // <- theme class
                'other' => [
                    'pathMap' => [
                        '@app/views' => '@themes/other/views'
                    ]
                ] 
            ]
        ]
    ]
]
```

Select Theme Widget
-------------------

Use in view
```php
<?= themes\SelectTheme::widget([
    'options' => ['class' => 'my-class'],
    'action' => 'site/change-theme', // default
]);?>
```

In SiteController
```php
public function actions()
{
    return [
        ...
        'change-theme' => 'themes\SelectThemeAction',
    ];
}
```