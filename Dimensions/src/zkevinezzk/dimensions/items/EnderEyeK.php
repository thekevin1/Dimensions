<?php

namespace zkevinezzk\dimensions\items;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\utils\CloningRegistryTrait;

final class EnderEyeK{
	use CloningRegistryTrait;

	private function __construct(){
		//NOOP
	}

	protected static function register(string $name, Item $item) : void{
		self::_registryRegister($name, $item);
	}
	public static function getAll() : array{
		$result = self::_registryGetAll();
		return $result;
	}

	protected static function setup() : void{

		$enderEye = ItemTypeIds::newId();
		self::register("ender_eye", new Item(new ItemIdentifier($enderEye), "EnderEye"));
	}
}