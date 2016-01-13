<?php
abstract class UNL_UndergraduateBulletin_LoginRequired
{
    public $options = array();

    final function __construct($options = array())
    {
        $this->options = $options + $this->options;
        UNL_UndergraduateBulletin_Editor::authenticate();
        $this->__postConstruct();
    }
}