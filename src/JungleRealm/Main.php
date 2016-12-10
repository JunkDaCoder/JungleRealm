<?php

namespace Main;

use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Listener;
use pocketmine\permission\Permission;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\level\particle\FloatingTextParticle;

class Main extends PluginBase implements Listener{
  public function onEnable(){
    new Config($this->getDataFolder() . "config.yml", Config::YAML);
    $this->saveResource("config.yml");
    $this->saveDefaultConfig();
    $this->getServer()->getPluginManager()->registerEvents(new MACEventListener(), $this);
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new BroadcastTask($this), 2000);
    $this->getServer()->getNetwork()->setName($this->getConfig()->get("Server-Name"));
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    $this->ce = new CustomEnchants($this);
    $this->reward = new Reward($this);
  }
  
  public function isCustomEnchant($enchant){
    if ($enchant > 99) return true;
  }else{
    return false;
  }
  
  public function spawnHolo(){
    $level = this->getServer()->getLevelByName("world");
    $holo = $this->getConfig();
    $x = $holo->get("X");
    $y = $holo->get("Y");
    $z = $holo->get("Z");
    $text = $holo->get("TEXT");
    $particle = new FloatingTextParticle(new Vector3($x, $y , $z), $text);
    $level->addParticle($particle);
  }
