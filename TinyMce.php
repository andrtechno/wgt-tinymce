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
use yii\helpers\ArrayHelper;
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
     */
    public $triggerSaveOnBeforeValidateForm = true;
    protected $assetsPlugins;
    public function init()
    {
        parent::init();
        $this->assetsPlugins = Yii::$app->getAssetManager()->publish(Yii::getAlias("@vendor/panix/wgt-tinymce/plugins"));



        $defaultClientOptions = [];
        $lang = Yii::$app->language;

        $defaultClientOptions['sticky_offset'] = 51;
        $defaultClientOptions['contextmenu'] = "link image inserttable | cell row column deletetable";
        $defaultClientOptions['plugins'] = [
            "textcolor stickytoolbar autoresize image template advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste pagebreak pixelion moxiemanager"//responsivefilemanager
        ];
        $defaultClientOptions['menubar'] = true;
        $defaultClientOptions['statusbar'] = true;
        $defaultClientOptions['toolbar'] = "pixelion | forecolor backcolor | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | pagebreak template";
        $defaultClientOptions['image_advtab'] = true;

        //MoxieManager options
        $defaultClientOptions['moxiemanager_rootpath'] = '/';
        $defaultClientOptions['moxiemanager_path'] = '/';
        $defaultClientOptions['moxiemanager_language'] = Yii::$app->language;
        $defaultClientOptions['moxiemanager_skin'] = 'custom';
        $defaultClientOptions['moxiemanager_title'] = 'FileManager';
        $defaultClientOptions['moxiemanager_image_settings'] = [
//            'moxiemanager_title' => 'Images',
//            'moxiemanager_extensions' => 'jpg,png,gif',
//            'moxiemanager_rootpath' => '/testfiles/testfolder',
//            'moxiemanager_view' => 'thumbs',
        ];


        $defaultClientOptions['resize'] = true;
        $defaultClientOptions['language'] = $lang;
        $defaultClientOptions['branding'] = false;
        //$defaultClientOptions['paste_enable_default_filters'] = false;
        $defaultClientOptions['paste_filter_drop'] = false;
        $defaultClientOptions['relative_urls'] = false;
        //$defaultClientOptions['remove_script_host'] = true;
        $defaultClientOptions['document_base_url'] = '/';
        $defaultClientOptions['image_prepend_url'] = '/';
        $defaultClientOptions['templates'] = [
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
                'title' => 'Badge secondary',
                'content' => '<span class="badge badge-secondary">Secondary</span>'
            ],
            [
                'title' => 'Badge primary',
                'content' => '<span class="badge badge-primary">Primary</span>'
            ],
            [
                'title' => 'Badge success',
                'content' => '<span class="badge badge-success">Success</span>'
            ],
            [
                'title' => 'Badge info',
                'content' => '<span class="badge badge-info">Info</span>'
            ],
            [
                'title' => 'Badge warning',
                'content' => '<span class="badge badge-warning">Warning</span>'
            ],
            [
                'title' => 'Badge danger',
                'content' => '<span class="badge badge-danger">Danger</span>'
            ]
        ];
        $defaultClientOptions['table_class_list'] = [
            ['title' => 'None', 'value' => ''],
            ['title' => 'Striped', 'value' => 'table table-striped'],
            ['title' => 'Bordered', 'value' => 'table table-bordered'],
            ['title' => 'Bordered & Striped', 'value' => 'table table-bordered table-striped'],
            ['title' => 'Hover', 'value' => 'table table-hover'],
            ['title' => 'Condensed', 'value' => 'table table-condensed'],
        ];
        $defaultClientOptions['image_title'] = true;
        $defaultClientOptions['image_class_list'] = [
            ['title' => 'None', 'value' => ''],
            ['title' => 'Rounded', 'value' => 'img-rounded'],
            ['title' => 'Rounded & Responsive', 'value' => 'img-rounded img-responsive img-fluid'],
            ['title' => 'Circle', 'value' => 'img-circle'],
            ['title' => 'Circle & Responsive', 'value' => 'img-circle img-responsive img-fluid'],
            ['title' => 'Thumbnail', 'value' => 'img-thumbnail'],
            ['title' => 'Thumbnail & Responsive', 'value' => 'img-thumbnail img-responsive img-fluid'],
            ['title' => 'Responsive', 'value' => 'img-responsive img-fluid'],
        ];
        $defaultClientOptions['selector'] = "#{$this->options['id']}";


        //responsivefilemanager
        //$this->clientOptions['filemanager_crossdomain'] = true;
        //$this->clientOptions['external_filemanager_path'] = $assetsPlugins[1] . '/responsivefilemanager/filemanager/';
        //$this->clientOptions['path_from_filemanager'] = '/uploads/';
        //$this->clientOptions['filemanager_access_key'] = 'test';
        //$this->clientOptions['filemanager_title'] = "Responsive Filemanager";
        $defaultClientOptions['external_plugins'] = [
            //"responsivefilemanager" => $assetsPlugins[1] . "/responsivefilemanager/plugin.min.js",
            "moxiemanager" => $this->assetsPlugins[1] . "/moxiemanager/plugin.min.js",
            "stickytoolbar" => $this->assetsPlugins[1] . "/stickytoolbar/plugin.min.js",
            "pixelion" => $this->assetsPlugins[1] . "/pixelion/plugin.js",
            //"mybbcode" => $this->assetsPlugins[1] . "/mybbcode/plugin.js",
        ];
        $view = $this->getView();
        $langAssetBundle = TinyMceLangAsset::register($view);
        if ($lang !== null && $lang !== 'en') {
            $langFile = "i18n/{$lang}.js";

            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }



        $this->clientOptions = ArrayHelper::merge($defaultClientOptions, $this->clientOptions);

    }

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
        $js = [];
        $view = $this->getView();
        TinyMceAsset::register($view);



        if (isset(Yii::$app->controller->module)) {
            if (file_exists(Yii::getAlias(Yii::$app->getModule(Yii::$app->controller->module->id)->uploadAliasPath))) {
                // $moxiemanager_rootpath = Yii::$app->getModule(Yii::$app->controller->module->id)->uploadPath;

            }
        }

        $theme = Yii::$app->settings->get('app', 'theme');
        // $this->clientOptions['content_css'][] = $langAssetBundle->baseUrl.'/tinymce-stickytoolbar.css';


        $class = "\app\web\themes\{$theme}\assets\ThemeAsset";
        $themeAsset =Yii::createObject("\\app\\web\\themes\\{$theme}\\ThemeAsset");


        $themeAssetUrl = (new \yii\web\AssetManager)->publish($themeAsset->sourcePath);
        // $bootstrapAssetUrl = (new \yii\web\AssetManager)->publish(Yii::createObject("\yii\bootstrap4\BootstrapAsset")->sourcePath);


        $bootstrapAsset = \yii\bootstrap4\BootstrapAsset::register($view);

        $this->clientOptions['content_css'][] = $bootstrapAsset->baseUrl . '/css/bootstrap.min.css';
        echo Yii::$app->controller->assetUrl.'/css/tinymce.css';
        if (file_exists(Yii::getAlias("@web_theme/assets/css") . DIRECTORY_SEPARATOR . 'tinymce.css')) {
            $this->clientOptions['content_css'][] = $themeAssetUrl[1].'/css/tinymce.css';
        }
        $options = Json::encode($this->clientOptions);

        $js[] = "tinymce.init($options);";
        if ($this->triggerSaveOnBeforeValidateForm) {
            $js[] = "$('#{$this->options['id']}').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });";
        }
        $view->registerJs(implode("\n", $js));
    }

}
