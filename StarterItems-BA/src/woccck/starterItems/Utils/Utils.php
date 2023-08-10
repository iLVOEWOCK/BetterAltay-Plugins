<?php

namespace woccck\starterItems\Utils;

use pocketmine\utils\Config;
use woccck\starterItems\starterItemsMain;

class Utils {

    public static function getStarterItemsConfig() : Config {
        return new Config(starterItemsMain::getInstance()->getDataFolder() . "config.yml", Config::YAML);
    }
}
