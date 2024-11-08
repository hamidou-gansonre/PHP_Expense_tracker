<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config\Paths;
use Framework\TemplateEngine;

class HomeController
{


    public function __construct(private TemplateEngine $view)
    {

        //$this->view = new TemplateEngine(Paths::VIEW);
    }

    public function home()
    {
        echo $this->view->render("index.php");
    }
}
