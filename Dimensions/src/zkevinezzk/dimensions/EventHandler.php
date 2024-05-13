<?php

namespace zkevinezzk\dimensions;

use zkevinezzk\dimensions\blocks\EndPortalK;
use zkevinezzk\dimensions\items\EnderEyeK;

use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\world\Position;
use pocketmine\Server;
use pocketmine\utils\Config;

class EventHandler implements Listener {

    public function onPlayerMove(PlayerMoveEvent $event): void {

        $player = $event->getPlayer();
        $block = $player->getWorld()->getBlock($player->getPosition());

        if ($block->getTypeId() === EndPortalK::END_PORTAL()->getTypeId()){
            $config = new Config(Loader::getInstance()->getDataFolder() . "config.yml", Config::YAML);
            
            $worldName = $config->get("end-world-name");
            $spawnCoords = explode(", ", $config->get("end-spawn-coords"));
            
            $position = new Position((float)$spawnCoords[0], (float)$spawnCoords[1], (float)$spawnCoords[2], Server::getInstance()->getWorldManager()->getWorldByName($worldName));
            $player->teleport($position);
            $player->sendMessage(str_replace("{world}", $player->getWorld()->getFolderName(), Loader::getInstance()->getConfig()->get("succes-msg")));
        } else {
            if ($block->getTypeId() === EndPortalK::END_PORTAL()->getTypeId()){
            $player->knockBack($player->getPosition()->getX() - $player->getPosition()->getZ(), 1);
            $player->sendMessage(Loader::getInstance()->getConfig()->get("error-msg"));
            return;
            }
        }

        if ($block->getTypeId() === VanillaBlocks::NETHER_PORTAL()->getTypeId()){
            $config = new Config(Loader::getInstance()->getDataFolder() . "config.yml", Config::YAML);

            $worldName = $config->get("nether-world-name");
            $spawnCoords = explode(", ", $config->get("nether-spawn-coords"));

            $position = new Position((float)$spawnCoords[0], (float)$spawnCoords[1], (float)$spawnCoords[2], Server::getInstance()->getWorldManager()->getWorldByName($worldName));
            $player->teleport($position);
            $player->sendMessage(str_replace("{world}", $player->getWorld()->getFolderName(), Loader::getInstance()->getConfig()->get("succes-msg")));
        } else {
            if ($block->getTypeId() === VanillaBlocks::NETHER_PORTAL()->getTypeId()){
            $player->knockBack($player->getPosition()->getX() - $player->getPosition()->getZ(), 1);
            $player->sendMessage(Loader::getInstance()->getConfig()->get("error-msg"));
            return;
        }

        if($player->getWorld()->getFolderName() === Loader::getInstance()->getConfig()->get("end-world-name")) {

            $config = new Config(Loader::getInstance()->getDataFolder() . "config.yml", Config::YAML);
            $worldName = $config->get("end-world-name");
            $spawnCoords = explode(", ", $config->get("random-coords"));

            if ($block->getTypeId() === VanillaBlocks::WATER()->getTypeId()) {
                $position = new Position((float)$spawnCoords[0], (float)$spawnCoords[1], (float)$spawnCoords[2], Server::getInstance()->getWorldManager()->getDefaultWorld());
                $player->teleport($position);
                $player->sendMessage(str_replace("{world}", $player->getWorld()->getFolderName(), Loader::getInstance()->getConfig()->get("succes-msg")));
            } else {
                }
            }
        }        
    }

    public function onPlayerInteract(PlayerInteractEvent $event): void {

        $block = $event->getBlock();
        $item = $event->getPlayer()->getInventory()->getItemInHand();

        if ($block->getTypeId() === VanillaBlocks::END_PORTAL_FRAME()->getTypeId()){
            if ($item->getTypeId() === EnderEyeK::ENDER_EYE()->getTypeId()) {

                $block->setEye(true);
                $block->getWorld()->setBlock($block, $block);
                $event->cancel();
            }
        }
    }
}