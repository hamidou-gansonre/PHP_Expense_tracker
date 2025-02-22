<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class FlashMiddleware implements MiddlewareInterface
{
    public function  __construct(private TemplateEngine $view) {}
    public function process(callable $next)
    {
        $sessionErrors = $_SESSION['errors'] ?? [];

        $this->view->addGlobal('errors', $sessionErrors);
        unset($_SESSION['errors']);

        $oldData = $_SESSION['oldFormData'] ?? [];

        $this->view->addGlobal('oldFormData', $oldData);
        unset($_SESSION['oldFormData']);

        $next();
    }
}
