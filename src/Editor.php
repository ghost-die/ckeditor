<?php

namespace ghost\CKEditor;

use Encore\Admin\Form\Field\Textarea;

class Editor extends Textarea
{
    protected $view = 'ghost-ckeditor::editor';

    protected static $js = [
	    'vendor/ghost/ckeditor/ckeditor.js',
	    'vendor/ghost/ckeditor/translations/zh-cn.js',
    ];

    public function render()
    {
        $config = (array) CKEditor::config('config');

        $config = array_merge($config, $this->options);
	    $config['simpleUpload']['headers'] = ['X-CSRF-TOKEN' => csrf_token()];
	
	    $config = json_encode($config);
	    
        $this->script = <<<EOT
		ClassicEditor.create( document.querySelector( '#{$this->id}' ),{$config})
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
		
EOT;
        return parent::render();
    }
}
