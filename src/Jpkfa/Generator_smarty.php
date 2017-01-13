<?php

namespace Jpk;

class Generator_smarty
{
    public function __construct()
    {
        $this->tpl = new \Smarty;
        $this->tpl->setTemplateDir(__DIR__ . '/../templates/');
    }

    public function xml($dane)
    {
        $this->tpl->assign('dane', $dane);
        $this->tpl->assign('Faktury', $dane['faktury']);
        $this->tpl->assign('Podmiot1', $dane['Podmiot1']); // wygodny alias
        $this->tpl->assign('FakturaCtrl', $dane['FakturaCtrl']);

        return $this->tpl->fetch('jpk_fa.tpl');
    }
}
