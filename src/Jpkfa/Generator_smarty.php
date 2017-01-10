<?php

namespace Jpk;

class Generator_smarty
{
    public function __construct()
    {
        $this->tpl = new \Smarty;
        $this->tpl->setTemplateDir(__DIR__ . '/../templates/');
    }

    public function xml()
    {
        return $this->tpl->fetch('jpk_fa.tpl');
    }
}
