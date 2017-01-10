<?php

namespace Jpk;

class Jpkfa
{
    public function __construct($podmiot, $data_od, $data_do)
    {
        $this->podmiot = $podmiot;
    }

    public function set_generator($generator)
    {
        $this->generator = $generator;
    }

    public function generuj($path)
    {
        $content = 'raport jpkfa';
        file_put_contents($path, $content);
    }
}
