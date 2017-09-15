<?php

// module/Album/Module.php

namespace Contenu;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
