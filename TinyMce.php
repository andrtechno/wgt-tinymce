<?php

/**
 *
 * TinyMCE renders a tinyMCE js plugin for WYSIWYG editing.
 *
 * @author CORNER CMS <dev@corner-cms.com>
 * @link http://www.corner-cms.com/
 */

namespace panix\ext\tinymce;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class TinyMce extends InputWidget {

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
    public function run() {
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
    protected function registerClientScript() {
        $lang = Yii::$app->language;
        $js = [];
        $view = $this->getView();

        TinyMceAsset::register($view);

        $id = $this->options['id'];

        $this->clientOptions['selector'] = "#$id";
       $this->clientOptions['contextmenu'] = "link image inserttable | cell row column deletetable";
        $this->clientOptions['plugins'] = [
            "autoresize template advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste pagebreak"
        ];
        $this->clientOptions['toolbar'] = "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | pagebreak template";


        // @codeCoverageIgnoreStart
        if ($lang !== null && $lang !== 'en') {
            $langFile = "langs/{$lang}.js";
            $langAssetBundle = TinyMceLangAsset::register($view);
            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }

 $this->clientOptions['resize'] = true;
        $this->clientOptions['language'] = $lang;
        $this->clientOptions['branding'] = false;
        // @codeCoverageIgnoreEnd

        
         $this->clientOptions['paste_enable_default_filters'] = false;
             $this->clientOptions['paste_filter_drop'] = false;
        
        
 $this->clientOptions['templates'] = array(
                array(
                    'title' => 'Alert success',
                    'content' => '<div class="alert alert-success" role="alert">My alert content</div>'
                ),
                array(
                    'title' => 'Alert danger',
                    'content' => '<div class="alert alert-danger" role="alert">My alert content</div>'
                ),
                array(
                    'title' => 'Alert info',
                    'content' => '<div class="alert alert-info" role="alert">My alert content</div>'
                ),
                array(
                    'title' => 'Alert warning',
                    'content' => '<div class="alert alert-warning" role="alert">My alert content</div>'
                ),
                array(
                    'title' => 'Label default',
                    'content' => '<span class="label label-default">Default</span>'
                ),
                array(
                    'title' => 'Label primary',
                    'content' => '<span class="label label-primary">Primary</span>'
                ),
                array(
                    'title' => 'Label success',
                    'content' => '<span class="label label-success">Success</span>'
                ),
                array(
                    'title' => 'Label info',
                    'content' => '<span class="label label-info">Info</span>'
                ),
                array(
                    'title' => 'Label warning',
                    'content' => '<span class="label label-warning">Warning</span>'
                ),
                array(
                    'title' => 'Label danger',
                    'content' => '<span class="label label-danger">Danger</span>'
                ),
            );
             $this->clientOptions['table_class_list'] = array(
                array('title' => 'None', 'value' => ''),
                array('title' => 'Striped', 'value' => 'table table-striped'),
                array('title' => 'Bordered', 'value' => 'table table-bordered'),
                array('title' => 'Bordered & Striped', 'value' => 'table table-bordered table-striped'),
                array('title' => 'Hover', 'value' => 'table table-hover'),
                array('title' => 'Condensed', 'value' => 'table table-condensed'),
            );
             $this->clientOptions['image_title'] = true;
             $this->clientOptions['image_class_list'] = array(
                array('title' => 'None', 'value' => ''),
                array('title' => 'Rounded', 'value' => 'img-rounded'),
                array('title' => 'Rounded & Responsive', 'value' => 'img-rounded img-responsive'),
                array('title' => 'Circle', 'value' => 'img-circle'),
                array('title' => 'Circle & Responsive', 'value' => 'img-circle img-responsive'),
                array('title' => 'Thumbnail', 'value' => 'img-thumbnail'),
                array('title' => 'Thumbnail & Responsive', 'value' => 'img-thumbnail img-responsive'),
                array('title' => 'Responsive', 'value' => 'img-responsive'),
            );
        
        
        
        
        
        
        
        
        $options = Json::encode($this->clientOptions);

        $js[] = "tinymce.init($options);";
        if ($this->triggerSaveOnBeforeValidateForm) {
            $js[] = "$('#{$id}').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });";
        }
        $view->registerJs(implode("\n", $js));
    }

}
