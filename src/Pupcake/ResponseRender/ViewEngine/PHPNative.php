<?php

/**
 * The default PHP Template Engine
 */

namespace Pupcake\ResponseRender\ViewEngine;

class PHPNative
{
    /**
     * perform render based on a configuration
     */
    public function render($config)
    {
        extract($config);
        $output = "";
        if(is_readable($view_path)){
            ob_start();
            extract($data);
            require $view_path;
            $output = ob_get_contents();
            ob_end_clean();
        }
        if($return_output){
            return $output;
        }
        else{
            $response->send($output);
        }
    }
}
