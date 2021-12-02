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
use yii\helpers\Json;
use yii\web\JsExpression;
use panix\engine\data\Widget;

/**
 * Class TinyMceInline
 * @package panix\ext\tinymce
 */
class TinyMceInline extends Widget {

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
    protected $assetsPlugins;
    /**
     * @inheritdoc
     */
    public function run() {
        $this->assetsPlugins = Yii::$app->getAssetManager()->publish(Yii::getAlias("@vendor/panix/wgt-tinymce/plugins"));

        $this->registerClientScript();
    }

    /**
     * Registers tinyMCE js plugin
     */
    protected function registerClientScript() {

        $moxiemanager_rootpath = '/uploads';
        //die(Yii::getAlias(Yii::$app->getModule(Yii::$app->controller->module->id)->uploadAliasPath));
        //if (isset(Yii::$app->controller->module)) {
        //    if (file_exists(Yii::getAlias(Yii::$app->getModule(Yii::$app->controller->module->id)->uploadAliasPath))) {
             //   $moxiemanager_rootpath = Yii::$app->getModule(Yii::$app->controller->module->id)->uploadPath;
        //    }
        //}

        $lang = Yii::$app->language;
        $js = [];
        $view = $this->getView();

        TinyMceAsset::register($view);
        $langAssetBundle = TinyMceLangAsset::register($view);
        $this->clientOptions['selector'] = ".edit_mode_text";
        $this->clientOptions['inline']=true;

//die($moxiemanager_rootpath);
        $this->clientOptions['plugins'] = [
            "save advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste pagebreak" // moxiemanager
        ];
        $this->clientOptions['toolbar'] = "save undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image";


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


       // $this->clientOptions['relative_urls'] = false;
       // $this->clientOptions['document_base_url'] = '/';
        // @codeCoverageIgnoreStart
        if ($lang !== null && $lang !== 'en') {
            $langFile = "i18n/{$lang}.js";

            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }

        $this->clientOptions['language'] = $lang;
        $this->clientOptions['branding'] = false;
        $defaultClientOptions['external_plugins'] = [
            //"moxiemanager" => $this->assetsPlugins[1] . "/moxiemanager/plugin.min.js",
            //"pixelion" => $this->assetsPlugins[1] . "/pixelion/plugin.js",
        ];
        $this->clientOptions['save_onsavecallback'] = new JsExpression("function () {
        //console.log('save_onsavecallback',this, this.formElement);
            var form = this.formElement;
            $.ajax({
                url:form.action,
                type:'POST',
                dataType:'json',
                data:$(form).serialize()+'&ajax=true',
                success:function(data){
                    if(data.success){
                        common.notify(data.message,'success');
                    }else{
                        common.notify('Error','error');
                    }
                }
            });
        }");
        $options = Json::encode($this->clientOptions);

        $js[] = "
            tinymce.init($options);
 
            tinymce.init({
                selector: '.edit_mode_title',
                inline: true,
                plugins: 'save',
                toolbar: 'save undo redo',
                menubar: false,
                save_onsavecallback: function(){
                    var form = this.formElement;
                    $.ajax({
                        url:form.action,
                        type:'POST',
                        dataType:'json',
                        data:$(form).serialize()+'&ajax=true',
                        success:function(data){
                            if(data.success){
                                common.notify(data.message,'success');
                            }else{
                                common.notify('Error','error');
                            }
                        }
                    });
                }
            });";


        if ($this->triggerSaveOnBeforeValidateForm) {
            //$js[] = "$('#{$id}').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });";
        }
        $view->registerJs(implode("\n", $js));
    }

}
