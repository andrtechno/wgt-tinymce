<?php

/**
 *
 * TinyMCE renders a tinyMCE js plugin for WYSIWYG editing.
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 */

namespace panix\ext\tinymce;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class TinyMce extends InputWidget
{

    /**
     * @var string the language to use. Defaults to null (en).
     */
    public $language;

    /**
     * @var array the options for the TinyMCE JS plugin.
     * Please refer to the TinyMCE JS plugin Web page for possible options.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
    public $clientOptions = [];

    /**
     * @var bool whether to set the on change event for the editor. This is required to be able to validate data.
     * @see https://github.com/2amigos/yii2-tinymce-widget/issues/7
     */
    public $triggerSaveOnBeforeValidateForm = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    /**
     * Registers tinyMCE js plugin
     */
    protected function registerClientScript()
    {
        $lang = Yii::$app->language;
        $js = [];
        $view = $this->getView();

        $assets = TinyMceAsset::register($view);
print_r($assets);
        $assetsPlugins = Yii::$app->getAssetManager()->publish(Yii::getAlias("@vendor/panix/wgt-tinymce/plugins"));
        // $assetsUrl = $assetsPaths[1];


        $id = $this->options['id'];

        $this->clientOptions['selector'] = "#$id";
        $this->clientOptions['sticky_offset'] = 51;
        $this->clientOptions['contextmenu'] = "link image inserttable | cell row column deletetable";
        $this->clientOptions['plugins'] = [
            "stickytoolbar autoresize image template advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste pagebreak moxiemanager pixelion"
        ];
        $this->clientOptions['toolbar'] = "pixelion | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | pagebreak template";

        $langAssetBundle = TinyMceLangAsset::register($view);
        // @codeCoverageIgnoreStart
        if ($lang !== null && $lang !== 'en') {
            $langFile = "i18n/{$lang}.js";

            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }

        // $this->clientOptions['external_filemanager_path'] = "/filemanager/";
        // $this->clientOptions['filemanager_title'] = "Responsive Filemanager";
        $this->clientOptions['external_plugins'] = [
            //"responsivefilemanager" => $assetsPlugins[1]."/filemanager/plugin.min.js",
            "moxiemanager" => $assetsPlugins[1] . "/moxiemanager/plugin.min.js",
            "stickytoolbar" => $assetsPlugins[1] . "/stickytoolbar/plugin.min.js",
            "pixelion" => $assetsPlugins[1] . "/pixelion/plugin.js",
        ];


        //$moxiemanager_rootpath = Yii::getAlias('@web/uploads/content');
        $moxiemanager_rootpath = Yii::getAlias('@webroot/uploads/content');
        if (isset(Yii::$app->controller->module)) {
            if (file_exists(Yii::getAlias(Yii::$app->getModule(Yii::$app->controller->module->id)->uploadAliasPath))) {
                // $moxiemanager_rootpath = Yii::$app->getModule(Yii::$app->controller->module->id)->uploadPath;
            }
        }
        //die($moxiemanager_rootpath);

        //MoxieManager options
        $this->clientOptions['moxiemanager_rootpath'] = $moxiemanager_rootpath;
        $this->clientOptions['moxiemanager_language'] = Yii::$app->language;
        $this->clientOptions['moxiemanager_skin'] = 'custom';
        $this->clientOptions['moxiemanager_title'] = 'FileManager CMS';


//        $this->clientOptions['moxiemanager_image_settings'] = [
//            'moxiemanager_title' => 'Images',
//            'moxiemanager_extensions' => 'jpg,png,gif',
//            'moxiemanager_rootpath' => '/testfiles/testfolder',
//            'moxiemanager_view' => 'thumbs',
//        ];


        //$this->clientOptions['image_advtab'] = true;
        $this->clientOptions['resize'] = true;
        $this->clientOptions['language'] = $lang;
        $this->clientOptions['branding'] = false;
        //$this->clientOptions['paste_enable_default_filters'] = false;
        //$this->clientOptions['paste_filter_drop'] = false;
        //$this->clientOptions['relative_urls'] = false;
        //$this->clientOptions['remove_script_host'] = true;
        //$this->clientOptions['document_base_url'] = '/';

        $this->clientOptions['templates'] = [
            [
                'title' => 'Alert success',
                'content' => '<div class="alert alert-success" role="alert">My alert content</div>'
            ],
            [
                'title' => 'Alert danger',
                'content' => '<div class="alert alert-danger" role="alert">My alert content</div>'
            ],
            [
                'title' => 'Alert info',
                'content' => '<div class="alert alert-info" role="alert">My alert content</div>'
            ],
            [
                'title' => 'Alert warning',
                'content' => '<div class="alert alert-warning" role="alert">My alert content</div>'
            ],
            [
                'title' => 'Label default',
                'content' => '<span class="label label-default">Default</span>'
            ],
            [
                'title' => 'Label primary',
                'content' => '<span class="label label-primary">Primary</span>'
            ],
            [
                'title' => 'Label success',
                'content' => '<span class="label label-success">Success</span>'
            ],
            [
                'title' => 'Label info',
                'content' => '<span class="label label-info">Info</span>'
            ],
            [
                'title' => 'Label warning',
                'content' => '<span class="label label-warning">Warning</span>'
            ],
            [
                'title' => 'Label danger',
                'content' => '<span class="label label-danger">Danger</span>'
            ]
        ];
        $this->clientOptions['table_class_list'] = [
            ['title' => 'None', 'value' => ''],
            ['title' => 'Striped', 'value' => 'table table-striped'],
            ['title' => 'Bordered', 'value' => 'table table-bordered'],
            ['title' => 'Bordered & Striped', 'value' => 'table table-bordered table-striped'],
            ['title' => 'Hover', 'value' => 'table table-hover'],
            ['title' => 'Condensed', 'value' => 'table table-condensed'],
        ];
        $this->clientOptions['image_title'] = true;
        $this->clientOptions['image_class_list'] = [
            ['title' => 'None', 'value' => ''],
            ['title' => 'Rounded', 'value' => 'img-rounded'],
            ['title' => 'Rounded & Responsive', 'value' => 'img-rounded img-responsive'],
            ['title' => 'Circle', 'value' => 'img-circle'],
            ['title' => 'Circle & Responsive', 'value' => 'img-circle img-responsive'],
            ['title' => 'Thumbnail', 'value' => 'img-thumbnail'],
            ['title' => 'Thumbnail & Responsive', 'value' => 'img-thumbnail img-responsive'],
            ['title' => 'Responsive', 'value' => 'img-responsive'],
        ];

        $this->clientOptions['content_css'][] = $langAssetBundle->baseUrl.'/tinymce-stickytoolbar.css';
        if (file_exists(Yii::getAlias("@themeroot/assets/css") . DIRECTORY_SEPARATOR . 'tinymce.css')) {

            //$this->clientOptions['content_css'] = Yii::$app->getUrlManager()->createAbsoluteUrl('/css/tinymce.css');
            /* $defaultOptions['content_css'] = array(
              Yii::app()->createAbsoluteUrl(Yii::app()->controller->getBaseAssetsUrl() . '/css/bootstrap.min.css'),
              Yii::app()->createAbsoluteUrl(Yii::app()->controller->getAssetsUrl() . '/css/theme.css'),
              ); */
        }


        $options = Json::encode($this->clientOptions);

        $js[] = "tinymce.init($options);";
        if ($this->triggerSaveOnBeforeValidateForm) {
            $js[] = "$('#{$id}').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });";
        }
        $view->registerJs(implode("\n", $js));
    }

}
