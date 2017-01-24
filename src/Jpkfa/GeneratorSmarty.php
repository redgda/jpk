<?php

namespace Jpk;

class GeneratorSmarty implements XMLGenerator
{
    public function __construct($smarty=null)
    {
        $this->tpl = new \Smarty;
        $this->tpl->setTemplateDir(__DIR__ . '/../../templates/');
    }

    public function xml($dane)
    {
        $this->tpl->assign('dane', $dane);
        return $this->tpl->fetch('jpkfa.tpl');
    }
}
