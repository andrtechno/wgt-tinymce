<?php
/**
 * @copyright Copyright (c) 2013-2017 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace panix\engine\widgets\tinymce;

use yii\web\AssetBundle;

class TinyMceLangAsset extends AssetBundle
{
    public $sourcePath = '@vendor/panix/engine/widgets/tinymce/assets';

    public $depends = [
        'panix\engine\widgets\tinymce\TinyMceAsset'
    ];
}
