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

class TinyMceInline extends \panix\engine\data\Widget {

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

        $this->registerClientScript();
    }

    /**
     * Registers tinyMCE js plugin
     */
    protected function registerClientScript() {

        $moxiemanager_rootpath = '/uploads';
        //die(Yii::getAlias(Yii::$app->getModule(Yii::$app->controller->module->id)->uploadAliasPath));
        if (isset(Yii::$app->controller->module)) {
            if (file_exists(Yii::getAlias(Yii::$app->getModule(Yii::$app->controller->module->id)->uploadAliasPath))) {
             //   $moxiemanager_rootpath = Yii::$app->getModule(Yii::$app->controller->module->id)->uploadPath;
            }
        }

        $lang = Yii::$app->language;
        $js = [];
        $view = $this->getView();

        TinyMceAsset::register($view);
        $this->clientOptions['selector'] = ".edit_mode_text";
        $this->clientOptions['inline']=true;

//die($moxiemanager_rootpath);
        $this->clientOptions['plugins'] = [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste pagebreak moxiemanager"
        ];
        $this->clientOptions['toolbar'] = "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image";
        //$this->clientOptions['moxiemanager_rootpath'] = $moxiemanager_rootpath;
        $this->clientOptions['moxiemanager_rootpath'] = $moxiemanager_rootpath;
        $this->clientOptions['moxiemanager_language'] = $lang;
        $this->clientOptions['moxiemanager_skin'] = 'custom';
       // $this->clientOptions['relative_urls'] = false;
       // $this->clientOptions['document_base_url'] = '/';
        // @codeCoverageIgnoreStart
        if ($lang !== null && $lang !== 'en') {
            $langFile = "langs/{$lang}.js";
            $langAssetBundle = TinyMceLangAsset::register($view);
            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }

        $this->clientOptions['language'] = $lang;
        $this->clientOptions['branding'] = false;


        $options = Json::encode($this->clientOptions);
        /*
          tinymce.init({
          selector: '.edit_mode_title',
          inline: true,
          toolbar: 'undo redo',
          menubar: false
          });

          tinymce.init({
          selector: '.edit_mode_text',
          inline: true,
          plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table contextmenu paste moxiemanager'
          ],
          toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
          content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css']
          });
         */
        $js[] = "
            tinymce.init($options);
 
tinymce.init({
  selector: '.edit_mode_title',
  inline: true,
  toolbar: 'undo redo',
  menubar: false
});


                ";
        if ($this->triggerSaveOnBeforeValidateForm) {
            //$js[] = "$('#{$id}').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });";
        }
        $view->registerJs(implode("\n", $js));
    }

}
