<?php
/**
 * 
 * @author 	fatjiong 
 * Email 	757970599@qq.com
 * QQ		757970599
 *
 */
namespace fatjiong\ueditor;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use fatjiong\ueditor\UeditorAsset;

class Ueditor extends InputWidget
{
	/**
	 * 百度编辑器内设置的参数
	 * @var array
	 */
    public $events = [];
    public $ucontent = '';
    
    // 是否生成标签
    public $renderTag=true;
        
    // 配置初始化
    public function init()
    {
    	if(isset($this->options['ucontent'])){
    		$this->ucontent = $this->options['ucontent'];
    		unset($this->options['ucontent']);
    	}
        // 设置默认的图标
        if (empty($this->options['toolbars'])) {
            $this->options['toolbars'] = [['fullscreen', 'source', '|', 'undo', 'redo', '|','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|','rowspacingtop', 'rowspacingbottom', 'lineheight', '|','customstyle', 'paragraph', 'fontfamily', 'fontsize', '|','directionalityltr', 'directionalityrtl', 'indent', '|','justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|','link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|','simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|','horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|','inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|','print', 'preview', 'searchreplace', 'help', 'drafts']];
        }
    	$this->events = $this->options;
    	\Yii::setAlias('@fatjiong\ueditor\assets', '@vendor/fatjiong/yii2-ueditor/assets');
        if(empty($this->name)){
            $this->name=$this->hasModel() ? Html::getInputName($this->model, $this->attribute): $this->id;
        }
        $asset = UeditorAsset::register($this->view);
        parent::init();
    }
    
    // 运行
    public function run()
    {
        $this->registerScripts();
        if($this->renderTag===true){
            echo $this->renderTag();
        }
    }
    
    // 渲染标签
    private function renderTag() {
    	$options = [
    		'type'	=> 'text/plain',
    		'name'	=> $this->id,
    		'id'	=> $this->id
		];
    	
        return Html::script($this->ucontent, $options);
    }
    
    // 配置js变量注入js文件
    private function registerScripts() {
        $jsonOptions = Json::encode($this->events);
        $script = <<<EOF
UE.getEditor('{$this->id}', {$jsonOptions});
EOF;
        $this->view->registerJs($script, View::POS_READY);
    }
}
