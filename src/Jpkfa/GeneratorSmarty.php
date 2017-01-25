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
        $xml = $this->tpl->fetch('jpkfa.tpl');

        // generowanie przez smarty jest wygodne ale ma duzo problemow z formatowaniem
        // np znaki nowej lini i wciecia w ifach dlatego robimy reformat
        return $this->reformat($xml);
    }

    public function reformat($xml)
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);
        return $dom->saveXML();
    }
}
