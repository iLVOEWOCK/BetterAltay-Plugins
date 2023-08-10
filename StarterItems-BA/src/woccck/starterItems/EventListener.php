<?php

namespace woccck\starterItems;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use woccck\starterItems\Utils\Utils;

class EventListener implements Listener {

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        if (!$player->hasPlayedBefore()) {
            $this->getStarterKit($player);
        }
    }

    public function getStarterKit(Player $player) {
        $config = Utils::getStarterItemsConfig();
        $starterItems = $config->getNested("starterItems", []);

        $inventory = $player->getInventory();

        foreach ($starterItems as $itemData) {
            $itemString = $itemData["item"];
            $name = isset($itemData["name"]) ? $itemData["name"] : null;
            $amount = $itemData["amount"] ?? 1;

            $item = Item::fromString($itemString);
            $loreLines = $itemData["lore"] ?? [];

            if ($item instanceof Item) {
                if ($name !== null) {
                    $item->setCustomName(TextFormat::colorize($name));
                }

                $item->setCount($amount);

                $enchantments = $itemData["enchantments"] ?? [];

                foreach ($enchantments as $enchantmentData) {
                    $enchantmentString = $enchantmentData["enchantment"];
                    $level = $enchantmentData["level"] ?? 1;

                    $enchantment = Enchantment::getEnchantmentByName($enchantmentString);
                    if ($enchantment instanceof Enchantment) {
                        $item->addEnchantment(new EnchantmentInstance($enchantment, $level));
                    }
                }

                foreach ($loreLines as $loreLine) {
                    $item->getLore()[] = TextFormat::colorize($loreLine);
                }

                $inventory->addItem($item);
            }
        }
    }
}
