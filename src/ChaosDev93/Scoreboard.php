<?php

namespace ChaosDev93;


use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as Color;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class Scoreboard extends PluginBase implements Listener {
	
	public $prefix = Color::WHITE . "[" . Color::GREEN . "Scoreboard" . Color::WHITE . "] ";
	
	public $anni = 1;
	
	public function onEnable() {
		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new sendSuperBar($this), 20);
		$this->getLogger()->info($this->prefix . Color::GREEN . "wurde aktiviert!");
        $this->getLogger()->info($this->prefix . Color::AQUA . "Made By" . Color::RED . " ChaosDev93!");
		
    }
}
class sendSuperBar extends Task
{
	
	public function __construct($plugin)
    {

        $this->plugin = $plugin;
        

    }

    public function onRun($tick)
    {
    	
        $all = $this->plugin->getServer()->getOnlinePlayers();
        $test = count($this->plugin->getServer()->getOnlinePlayers());
        $motd = $this->plugin->getServer()->getMotd();
        $max = $this->plugin->getServer()->getMaxPlayers();
        $t = str_repeat(" ", 60);
        $anni = $this->plugin->anni;
        
        
        if ($this->plugin->anni === 1) {
        	
        	$this->plugin->anni = 2;
        	
        } else if ($this->plugin->anni === 2) {
        	
        	$this->plugin->anni = 3;
        	
        } else if ($this->plugin->anni === 3) {
        	
        	$this->plugin->anni = 1;
        	
        	
        }
        
        foreach ($all as $player) {
            if ($anni === 1) {
            	
            	$player->sendTip(
                                               "\n\n\n\n\n\n\n\n\n\n\n\n\n\n" . 
                                               $t . Color::BOLD . $motd . Color::RESET . "\n" .
                                               $t . Color::BOLD . "Name" . Color::GRAY . ": " . Color::RESET . Color::BLUE . $player->getName() . Color::RESET . "\n" . 
                                               $t . Color::BOLD . "Spieler" . Color::GRAY . ": " . Color::RESET . Color::GREEN . $test . Color::GRAY . " / " . Color::RED . $max . Color::RESET . "\n" .
                                               $t . Color::BOLD . "Ping" . Color::GRAY . ": " . Color::RESET . Color::YELLOW . $player->getPing() . Color::RESET . "\n" . str_repeat("\n", 24));
            	
            } else if ($anni === 2) {
            	
            	$player->sendTip(
                                               "\n\n\n\n\n\n\n\n\n\n\n\n\n\n" . 
                                               $t . Color::BOLD . $motd . Color::RESET . "\n" . 
                                               $t . Color::BOLD . "Name" . Color::GRAY . ": " . Color::RESET . Color::BLUE . $player->getName() . Color::RESET . "\n" .
                                               $t . Color::BOLD . "Spieler" . Color::GRAY . ": " . Color::RESET . Color::GREEN . $test . Color::GRAY . " / " . Color::RED . $max . Color::RESET . "\n" .
                                               $t . Color::BOLD . "Ping" . Color::GRAY . ": " . Color::RESET . Color::YELLOW . $player->getPing() . Color::RESET . "\n" . str_repeat("\n", 24));
            	
            } else if ($anni === 3) {
            	
            	$player->sendTip(
                                               "\n\n\n\n\n\n\n\n\n\n\n\n\n\n" . 
                                               $t . Color::BOLD . $motd . Color::RESET . "\n" . 
                                               $t . Color::BOLD . "Name" . Color::GRAY . ": " . Color::RESET . Color::BLUE . $player->getName() . Color::RESET . "\n" .
                                               $t . Color::BOLD . "Spieler" . Color::GRAY . ": " . Color::RESET . Color::GREEN . $test . Color::GRAY . " / " . Color::RED . $max . Color::RESET . "\n" .
                                               $t . Color::BOLD . "Ping" . Color::GRAY . ": " . Color::RESET . Color::YELLOW . $player->getPing() . Color::RESET . "\n" . str_repeat("\n", 24));
            	
            }
           }
          }
         }
