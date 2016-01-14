<?php

namespace UNL\UndergraduateBulletin;

interface ControllerAwareInterface
{
    public function setController(Controller $controller);
    public function getController();
}
