<?php
/**
 *
 * TinyMCE renders a tinyMCE js plugin for WYSIWYG editing.
 *
 * @author CORNER CMS <dev@corner-cms.com>
 * @link http://www.corner-cms.com/
 */
namespace panix\ext\tinymce;

use yii\web\AssetBundle;

class TinyMceLangAsset extends AssetBundle
{
    public $sourcePath = '@vendor/panix/wgt-tinymce/assets';

    public $depends = [
        'panix\ext\tinymce\TinyMceAsset'
    ];
}
