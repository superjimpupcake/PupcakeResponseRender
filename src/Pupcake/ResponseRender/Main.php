<?php
/**
 * ResponseRender plugin
 */
namespace Pupcake\ResponseRender;

use Pupcake;

class Main extends Pupcake\plugin
{
    private $view_engine;
    private $view_directory;

    public function load($config = array())
    {
        if(!isset($config['view_engine'])){
            $this->view_engine = 'PHPNative'; //set default view engine, PHPNative
        }

        $view_directory = ""; //default view directory is empty
        $plugin = $this;
        $app = $this->getAppInstance();

        /**
         * add setViewEngine method
         */
        $app->method("setViewEngine", function($view_engine) use ($plugin) {
            $plugin->setViewEngine($view_engine);
        });

        /**
         * add setViewDirectory method
         */
        $app->method("setViewDirectory", function($view_directory) use ($plugin) {
            $plugin->setViewDirectory($view_directory);
        });

        $this->help("pupcake.plugin.express.response.create", function($event) use ($plugin, $app) {
            $response = $event->props("response");
            $plugin->storageSet("response", $response);
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
        return $this->trigger("pupcake.responserender.render.start", function($event){
            $config = array('view_path' => $event->props('view_path'), 'data' => $event->props('data'), 'return_output' => $event->props('return_output'), 'response' => $response);
            $view_engine_class = "Pupcake\\ResponseRender\\ViewEngine\\".$event->props('view_engine');
            $view_engine = new $view_engine_class();
            return $view_engine->render($config);
        }, array(
            'view_path' => $view_path,
            'data' => $data,
            'return_output' => $return_output,
            'view_engine' => $this->view_engine,
            'view_directory' => $this->view_directory,
            'response' => $response,
        ));
    }

    public function setViewEngine($view_engine)
    {
        $this->view_engine = $view_engine;
    }

    public function getViewEngine()
    {
        return $this->view_engine;
    }

    public function setViewDirectory($view_directory)
    {
        $this->view_directory = $view_directory;
    }

    public function getViewDirectory()
    {
        return $this->view_directory;
    }
}
