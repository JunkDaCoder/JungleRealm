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
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\enchantment\Enchantment

class Main extends PluginBase implements Listener{
  
  public $interval = 10;
  public $players;
    
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
  
  public function Death(PlayerDeathEvent $event){
    $cause = $event->getEntity()->getLastDamageCause();
    if($cause instanceof EntityDamageByEntityEvent){
      $victim = $event->getEntity();
      $killer = $cause->getEntity();
      $killername = $killer->getName();
      $victimname = $victim->getName();
      $weapon = $killer->getInventory()->getItemInHand();
      if($killer instanceof Player){
        $this->getServer()->broadcastMessage(C::DARK_RED . C::BOLD . "x " . C::RESET . C::YELLOW . $victimname . C::ORANGE . " killed by " . C::YELLOW . $killername . C::ORANGE . " with " . C::AQUA . $weapon . C::DARK_RED . C::BOLD . " x");
      }
      
      public function enterCombat(Player $player){
        if(isset($this->players[$player->getName()])){
          if((time() - $this->players[$player->getName()]) > $this->interval){
            $player->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMBAT" . C::DARK_GRAY . "]" . C::RESET . C::GRAY . " You've entered combat! Don't log out for " . C::YELLOW . "10 SECONDS" . C::GRAY . "!");
          }
        }else{
          $player->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMBAT" . C::DARK_GRAY . "]" . C::RESET . C::GRAY . " You've entered combat! Don't log out for " . C::YELLOW . "10 SECONDS" . C::GRAY . "!");
        }
        $this->players[$player->getName()] = time();
      }
      public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
        switch (strtolower($cmd->getName())){
          case "me":
            $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "]" . C::RESET . C::YELLOW . " This command is blocked!");
            break;
          case "list":
            
            $online = "";
            $onlineCount = 0;
            
            foreach($sender->getServer()->getOnlinePlayers() as $player){
              if($player->isOnline() and (!($sender instanceof Player))){
                $online .= $player->getDisplayName() . ", ";
                ++$onlineCount;
              }
            }
            
            $sender->sendMessage(C::GRAY . "There are " . C::YELLOW . $this->getServer()->getOnlinePlayers() . C::GRAY . "/ " . C::YELLOW . $this->getServer()->getMaxPlayers() . C::GRAY . " online on " . C::DARK_GREEN . "Jungle Realm" . C::GRAY . ":");
            $sender->sendMessage(C::AQUA . substr($online, 0, -2));
            return true;
        }
      }
      break;
    }
  }
}
