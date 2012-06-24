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
        $plugin = $this;
        $this->help("pupcake.plugin.express.response.create", function($event) use ($plugin) {
            $response = $event->props("response");
            $plugin->storageSet("response", $response);
            $response->method("render", function($view_path, $data = array()) use ($plugin) {
                return  $plugin->render($view_path, $data);
            });
        });
    }

    public function render($view_path, $data = array())
    {
    }
}
