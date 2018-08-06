<?php

namespace ChaosDev93;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Pocketmine;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as Color;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\block\Block;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\Position;
use pocketmine\level\particle\Particle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\utils\Config;

class Hub extends PluginBase implements Listener {

public $prefix = Color::WHITE . "[" . Color::GREEN . "Hub" . Color::WHITE . "] ";

public function onEnable() {
		
		$this->saveResource("settings.yml");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info($this->prefix . Color::GREEN . "wurde aktiviert!");
        $this->getLogger()->info($this->prefix . Color::AQUA . "Made By" . Color::RED . " ChaosDev93!");
		$this->config = $this->getConfig();
		$this->config = new Config($this->getDataFolder()."settings.yml", Config::YAML, [
		  "JoinMessage" => "",
		  "QuitMessage" => "",
		]);
		$this->userDataFolder = $this->getDataFolder() . "players/";
        if(!file_exists($this->userDataFolder))
            @mkdir($this->userDataFolder, 0777, true);
    }
    public function onDisable() {
         
    }
    public function profil(Player $player) {
    	$player->getInventory()->clearAll();
        $play = $player->getPlayer();
        if($play->hasPermission("hub.build") == true){
       
        $build = Item::get(270, 0, 1);
        $friends = Item::get(397, 3, 0);
        $back = Item::get(372, 0, 1);
        $build->setCustomName(Color::GRAY . "[" . Color::GREEN . "Build-Mode" . Color::GRAY . "]");
        $friends->setCustomName(Color::GRAY . "[" . Color::YELLOW . "Friends" . Color::GRAY . "]");
        $back->setCustomName(Color::GRAY . "[" . Color::RED . "Back" . Color::GRAY . "]");
        $player->getInventory()->setItem(1, $build);
        $player->getInventory()->setItem(3, $friends);
        $player->getInventory()->setItem(8, $back);
        
        } else if ($play->hasPermission("hub.build") == false) {
        $friends = Item::get(397, 3, 1);
        $back = Item::get(372, 0, 1);
        $friends->setCustomName(Color::GRAY . "[" . Color::YELLOW . "Friends" . Color::GRAY . "]");
        $back->setCustomName(Color::GRAY . "[" . Color::RED . "Back" . Color::GRAY . "]");
        $player->getInventory()->setItem(3, $friends);
        $player->getInventory()->setItem(8, $back);
        }
    }
    
    public function mainItems(Player $player) {
    	
    	$player->getInventory()->clearAll();
        $play = $player->getPlayer();
        if ($play->hasPermission("hub.booster") == true) {
        	
        	$teleporter = Item::get(345, 0, 1);
        	$boost = Item::get(369, 10, 1);
            $profil = Item::get(397, 3 ,1);
            $teleporter->setCustomName(Color::AQUA . "Game Teleporter");
		    $boost->setCustomName(Color::RED . "Energie Schub\n" . Color::BOLD . Color::LIGHT_PURPLE . "Soon...");
		    $profil->setCustomName(Color::YELLOW . "Profil");
            $player->getInventory()->setItem(0, $teleporter);
		    $player->getInventory()->setItem(4, $boost);
		    $player->getInventory()->setItem(8, $profil);
        	
        } else if ($play->hasPermission("hub.booster") == false) {
        	
        	$teleporter = Item::get(345, 0, 1);
            $profil = Item::get(397, 3 ,1);
            $teleporter->setCustomName(Color::AQUA . "Game Teleporter");
            $profil->setCustomName(Color::YELLOW . "Profil");
            $player->getInventory()->setItem(0, $teleporter);
            $player->getInventory()->setItem(8, $profil);
        	
        }
		
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
      $this->config = $this->getConfig();
      $player = $sender->getPlayer();
      $userName = $player->getName();
      $this->config = new Config($this->userDataFolder . strtolower($userName) . ".yml" , Config::YAML);
      if ($command->getName() === "build") {
      	if($sender->hasPermission("hub.build") == true) {
      	
      	if (isset($args[0])) {
        	
        	        if (strtolower($args[0]) === "on") {
      	          $this->config->set("build", true);
                    $this->config->save();
                    $sender->setGamemode(1);
                    $sender->getInventory()->clearAll();
                    $sender->sendMessage(Color::GREEN . "Build-Mode betreten");
                    } else if (strtolower($args[0]) === "off") {
          $this->config->set("build", false);
          $this->config->save();
          $sender->setGamemode(2);
          $this->mainItems($player);
          $sender->sendMessage(Color::RED . "Build-Mode verlassen");
          } else if (strtolower($args[0]) === "") {
          	$sender->sendMessage("Usage: /build <on/off>");
          }
          }
          } else if ($sender->hasPermission("hub.build") === false) {
          	$sender->sendMessage(Color::RED . "Du hast keine Rechte dazu!");
          }
          }
          if ($command->getName() === "fly") {
      	if($sender->hasPermission("hub.fly") == true) {
      	
      	if (isset($args[0])) {
        	
        	        if (strtolower($args[0]) === "on") {
      	          $this->config->set("fly", true);
                    $this->config->save();
                    $sender->setFlying(1);
                    $sender->sendMessage(Color::GREEN . "Fly-Mode betreten");
                    } else if (strtolower($args[0]) === "off") {
          $this->config->set("fly", false);
          $this->config->save();
          $sender->setFlying(0);
          $sender->sendMessage(Color::RED . "Fly-Mode verlassen");
          } else if (strtolower($args[0]) === "") {
          	$sender->sendMessage("Usage: /fly <on/off>");
          }
          }
          } else if ($sender->hasPermission("hub.fly") === false) {
          	$sender->sendMessage(Color::RED . "Du hast keine Rechte dazu!");
          }
          }
          return true;
          }
          public function onInteract(PlayerInteractEvent $event) {
          	$player = $event->getPlayer();
          	$item = $player->getInventory()->getItemInHand();
          if ($item->getCustomName() === Color::YELLOW . "Profil"){
          	$this->profil($player);
          } else if($item->getCustomName() === Color::GRAY . "[" . Color::RED . "Back" . Color::GRAY . "]") {
          	$this->mainItems($player);
          }
          } 
    public function onJoin(PlayerJoinEvent $event) {
    	$player = $event->getPlayer();
        $spawn = $player->getLevel()->getSafeSpawn();
        $userName = $player->getName();
        $this->mainItems($player);
        $player->teleport($spawn);
        $player->setGamemode(2);
        $event->setJoinMessage($this->config->get("JoinMessage"));
        $player->sendMessage(Color::BOLD . Color::RED . "Willkommen auf" . Color::GREEN . " ChaosCraft" . Color::GREEN . "!\n" . Color::RESET . Color::GOLD . "Mit den Commands" . Color::RED . " /info" . Color::GOLD . " und" . Color::RED . " /hilfe" . Color::GOLD . " erhaelst du einige Infos" . Color::RESET);
        
        if(!file_exists($this->userDataFolder . strtolower($userName) . ".yml"))
            {
                return new Config($this->userDataFolder . strtolower($userName) . ".yml", Config::YAML, [
       