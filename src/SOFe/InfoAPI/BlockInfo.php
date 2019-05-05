<?php

/*
 * InfoAPI
 *
 * Copyright (C) 2019 SOFe
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace SOFe\InfoAPI;

use Generator;
use pocketmine\block\Block;

class BlockInfo extends Info{
	/** @var Block */
	private $block;
	/** @var bool */
	private $hasPosition;

	public function __construct(Block $block, bool $hasPosition = true){
		$this->block = $block;
		$this->hasPosition = $hasPosition;
	}

	public function getBlock() : Block{
		return $this->block;
	}

	public function toString() : string{
		return $this->block->getName();
	}

	public function defaults(InfoResolveEvent $event) : bool{
		return $event->match("pocketmine.block.id", function(){
				return new NumberInfo($this->block->getId());
			}) or $event->match("pocketmine.block.damage", function(){
				return new NumberInfo($this->block->getDamage());
			});
	}

	public function fallbackInfos() : Generator{
		if($this->hasPosition){
			yield new PositionInfo($this->block);
		}
	}
}