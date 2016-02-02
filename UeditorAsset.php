<?php
namespace fatjiong\ueditor;

use yii\web\AssetBundle;
use fatjiong;

class UeditorAsset extends AssetBundle{
    public $sourcePath='@fatjiong\ueditor\assets';

    public $css=[
        'themes/default/css/ueditor.min.css',  
    ];
    
    public $js=[
		'js/ueditor.config.js',
		'js/ueditor.all.min.js',
		'js/lang/zh-cn/zh-cn.js',
    ];
    
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public $publishOptions = ['forceCopy' => YII_DEBUG];
    
    private function getJs() {
        return [
            YII_DEBUG ? 'ueditor.all.js':'ueditor.all.min.js',
        ];
    }
    public function init() {
        if(empty($this->js)){
            $this->js=$this->getJs();
        }
        return parent::init();
    }
}
