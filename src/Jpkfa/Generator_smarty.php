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
        // wszystkie dane:
        $this->tpl->assign('dane', $dane);
        // wygodne aliasy:
        $this->tpl->assign('Naglowek', $dane['Naglowek']);
        $this->tpl->assign('Podmiot1', $dane['Podmiot1']); 
        $this->tpl->assign('Faktury', $dane['Faktury']);
        $this->tpl->assign('FakturaCtrl', $dane['FakturaCtrl']);
        $this->tpl->assign('Wiersze', $dane['Wiersze']);
        $this->tpl->assign('FakturaWierszCtrl', $dane['FakturaWierszCtrl']);

        return $this->tpl->fetch('jpk_fa.tpl');
    }
}
