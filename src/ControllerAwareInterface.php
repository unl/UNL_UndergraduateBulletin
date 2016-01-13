<?php

interface UNL_UndergraduateBulletin_ControllerAwareInterface
{
    public function setController(UNL_UndergraduateBulletin_Controller $controller);
    public function getController();
}
