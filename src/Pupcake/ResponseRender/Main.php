<?php
/**
 * ResponseRender plugin
 */
namespace Pupcake\ResponseRender;

use Pupcake;

class Main extends Pupcake\plugin
{
    private $view_engine;

    public function load($config = array())
    {
        if(!isset($config['view_engine'])){
            $this->view_engine = 'PHPNative';
        }
        $plugin = $this;
        $this->help("pupcake.plugin.express.response.create", function($event) use ($plugin) {
            $response = $event->props("response");
            $plugin->storageSet("response", $response);
            /**
             * add setViewEngine method
             */
            $response->method("setViewEngine", function($view_engine) use ($plugin) {
                $plugin->setViewEngine($view_engine);
            });

            /**
             * add render method
             */
            $response->method("render", function($view_path, $data = array()) use ($plugin) {
                return  $plugin->render($view_path, $data);
            });
        });
    }

    public function render($view_path, $data = array(), $return_output = false)
    {
        $response = $this->storageGet("response");
        $config = array('view_path' => $view_path, 'data' => $data, 'return_output' => $return_output, 'response' => $response);
        $view_engine_class = "Pupcake\\ResponseRender\\ViewEngine\\".$this->view_engine;
        $view_engine = new $view_engine_class();
        return $view_engine->render($config);
    }

    public function setViewEngine($view_engine)
    {
        $this->view_engine = $view_engine;
    }
}
