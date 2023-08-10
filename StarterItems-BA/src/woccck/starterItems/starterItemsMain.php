<?php

namespace woccck\starterItems;

use pocketmine\plugin\PluginBase;

class starterItemsMain extends PluginBase {

    public static starterItemsMain $instance;

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->saveDefaultConfig();
        $this->registerListeners();
    }

    public function registerListeners() {
        $pluginMngr = $this->getServer()->getPluginManager();

        $pluginMngr->registerEvents(new EventListener(), $this);
    }

    public static function getInstance() : starterItemsMain {
        return self::$instance;
    }
}
