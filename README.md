wgt-tinymce
===========
Widget for Yii Framework 2.0 to use [TinyMce](http://www.tinymce.com)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist panix/wgt-tinymce "*"
```

or add

```
"panix/wgt-tinymce": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

```php
<?php
        $form->field($model, 'text')->widget(TinyMce::className(), [
            'options' => ['rows' => 6],
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            ]
        ]);
 ?>
```

