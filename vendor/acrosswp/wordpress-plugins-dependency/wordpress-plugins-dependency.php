<?php
namespace acrosswp;

abstract class WordPress_Plugins_Dependency {

    function __construct() {
        echo $this->someMethod();
    }

    abstract public function someMethod();
}