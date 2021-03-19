<?php

/**
 * View-specific wrapper.
 * Limits the accessible scope available to templates.
 */
class View{

    protected $template = null;


    public function __construct($template) {
        $this->template = str_replace(".", DIRECTORY_SEPARATOR, $template);
    }


    public function h($data) {
        return htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8');
    }


    public function render(Array $data) {
		$sep = DIRECTORY_SEPARATOR;
		$views_path = dirname(__FILE__)  . $sep . '..'  . $sep . '..'  . $sep . 'Views'  . $sep;
		
        extract($data);
        
        ob_start();
        include( $views_path . $this->template . ".php");
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

?>