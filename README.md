PupcakeResponseRender
=====================
Pupcake Response Render is a Plugin to allow the response object in Plugin Express Plugin to render different types of templates.

##Installation:

####install package "Pupcake/ResponseRender" using composer (http://getcomposer.org/)

###Usage

```php
<?php
//Assuming this is public/index.php and the composer vendor directory is ../vendor

require_once __DIR__.'/../vendor/autoload.php';

$app = new Pupcake\Pupcake();

$app->usePlugin("Pupcake.ResponseRender");

$app->on("node.edit.form.fields", function(){
    $fields = array();

    $fields[] = array('type' => 'textfield', 'id' => 'title');
    $fields[] = array('type' => 'textbox', 'id' => 'body');
    $fields[] = array('type' => 'textbox', 'id' => 'summary');
    $fields[] = array('type' => 'image_upload', 'id' => 'logo', 'maxsize' => '2MB');
    $fields[] = array('type' => 'embed_video', 'id' => 'youtube-video', 'provider' => 'youtube');

    return $fields;
});

$app->get("node/:id/edit", function($req, $res) use ($app) { 
    $data = array();
    $data['fields'] = $app->trigger("node.edit.form.fields"); //the node edit form creation
    $res->render("../views/index.tpl.php", $data);
});

$app->run();
```
