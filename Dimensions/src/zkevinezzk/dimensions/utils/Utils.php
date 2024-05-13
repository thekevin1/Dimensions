<?php
    
namespace zkevinezzk\dimensions\utils;

use pocketmine\block\Block;
use pocketmine\block\RuntimeBlockStateRegistry;
use pocketmine\data\bedrock\block\BlockTypeNames;
use pocketmine\item\StringToItemParser;
use pocketmine\world\format\io\GlobalBlockStateHandlers;
use pocketmine\utils\CloningRegistryTrait;
use pocketmine\data\bedrock\item\ItemTypeNames;
use pocketmine\data\bedrock\item\SavedItemData;
use pocketmine\item\Item;
use pocketmine\world\format\io\GlobalItemDataHandlers;

use zkevinezzk\dimensions\blocks\EndPortalK;
use zkevinezzk\dimensions\items\EnderEyeK;

abstract class Utils {
    
    use CloningRegistryTrait;

    public static function startBlock() : void {
        $block = EndPortalK::END_PORTAL();
        self::registerBlock(BlockTypeNames::END_PORTAL, $block, ["end_portal"]);
    }

    public static function startItem() : void{
		$item = EnderEyeK::ENDER_EYE();
		self::registerItem(ItemTypeNames::ENDER_EYE, $item, ["ender_eye"]);
	}

    private static function registerBlock(string $id, Block $block, array $stringToItemParserNames) : void {
        RuntimeBlockStateRegistry::getInstance()->register($block);

        GlobalBlockStateHandlers::getDeserializer()->mapSimple($id, fn() => clone $block);
        GlobalBlockStateHandlers::getSerializer()->mapSimple($block, $id);

        foreach($stringToItemParserNames as $name) {
            StringToItemParser::getInstance()->registerBlock($name, fn() => clone $block);
        }
    }

    private static function registerItem(string $id, Item $item, array $stringToItemParserNames) : void{
		GlobalItemDataHandlers::getDeserializer()->map($id, fn() => clone $item);
		GlobalItemDataHandlers::getSerializer()->map($item, fn() => new SavedItemData($id));

		foreach($stringToItemParserNames as $name){
			StringToItemParser::getInstance()->register($name, fn() => clone $item);
		}
	}
}