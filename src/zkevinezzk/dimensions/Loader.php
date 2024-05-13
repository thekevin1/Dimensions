<?php

namespace zkevinezzk\dimensions;

use zkevinezzk\dimensions\EventHandler;
use zkevinezzk\dimensions\utils\Utils;

use pocketmine\scheduler\AsyncTask;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    public static Loader $instance;

    protected function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        $this->getConfig()->save();
        Utils::startBlock();
        Utils::startItem();

        $this->getServer()->getPluginManager()->registerEvents(new EventHandler(), $this);
        $this->getServer()->getAsyncPool()->addWorkerStartHook(function(int $worker) : void{
            $this->getServer()->getAsyncPool()->submitTaskToWorker(new class extends AsyncTask{
                public function onRun() : void {
                    Utils::startBlock();
                    Utils::startItem();
                }
            }, $worker);
        });
        
        $this->getServer()->getWorldManager()->loadWorld($this->getConfig()->get("end-world-name"));
        $this->getServer()->getWorldManager()->loadWorld($this->getConfig()->get("nether-world-name"));
    
        $this->getLogger()->info("Plugin cargado!");
    }
    

    public function onDisable(): void {
        $this->getConfig()->save();
        $this->getLogger()->info("Plugin desactivado!");
    }

    public static function getInstance(): Loader {
        return self::$instance;
    }
}
