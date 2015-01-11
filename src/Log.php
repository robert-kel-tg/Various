<?php

namespace test1\Src;

class Log {

    private $_name;

    public function __construct($name) {
        $this->_name = $name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

}