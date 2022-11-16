<?php

namespace app\pc\controller;

class Index extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        return $this->fetch('index');
    }

}
