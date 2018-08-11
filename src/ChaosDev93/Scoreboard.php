<?php

namespace ChaosDev93;


use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as Color;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\Task;

use ChaosDev93\sendSuperBar;

class Scoreboard extends PluginBase implements Listener {
	
	public $prefix = Color::WHITE . "[" . Color::GREEN . "Scoreboard" . Color::WHITE . "] ";
	
	public $anni = 1;
	
	public function onEnable() {
		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new sendSuperBar($this), 20);
		$this->getLogger()->info($this->prefix . Color::GREEN . "wurde aktiviert!");
        $this->getLogger()->info($this->prefix . Color::AQUA . "Made By" . Color::RED . " ChaosDev93!");
		
    }

public function getHour() {
  $hour = strftime("%H", time())+$this->timeZone;
  return $hour;
}
public function getMin() {
	$min = strftime("%M", time())+$this->timeZone;
	return $min;
	}
public function getSek() {
	$sek = strftime("%S", time())+$this->timeZone;
	return $sek;
	}
}
