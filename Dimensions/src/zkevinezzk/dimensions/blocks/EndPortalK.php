<?php

namespace zkevinezzk\dimensions\blocks;

use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\BlockTypeInfo;
use pocketmine\block\Opaque;
use pocketmine\utils\CloningRegistryTrait;

abstract class EndPortalK {

    use CloningRegistryTrait;

    public function __construct(){
    }
    
    public const END_PORTALID = 10719;

    public static function register(string $name, Block $block) : void{
        self::_registryRegister($name, $block);
    }

    public static function getAll() : array{
        $result = self::_registryGetAll();
        return $result;
    }

    public static function setup() : void{
        $endPortalTypeId = BlockTypeIds::newId();
        self::register("end_portal", new Opaque(new BlockIdentifier($endPortalTypeId), "EndPortal", new BlockTypeInfo(BlockBreakInfo::indestructible())));
    }
}