<?php

// module/Album/Module.php

namespace Siteprivate;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
