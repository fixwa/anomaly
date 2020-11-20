<?php
namespace Fixwa\Anomaly;

class Application
{

    public function __construct(array $configurations)
    {
        Config::init($configurations);
    }

    public function go()
    {
        $router = new Router();

    }
}