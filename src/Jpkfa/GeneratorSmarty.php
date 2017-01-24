<?php

namespace Jpk;

class GeneratorSmarty implements XMLGenerator
{
    public $tpl;

    public function __construct(\Smarty $smarty=null)
    {
        $this->tpl = $smarty;
        $this->tpl->setTemplateDir(__DIR__ . '/../../templates/');
    }

    public function xml($dane)
    {
        $this->tpl->assign('dane', $dane);
        return $this->tpl->fetch('jpkfa.tpl');
    }
}
