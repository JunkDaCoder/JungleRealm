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
    if (!is_dir($this->getDataFolder() . "/bounties")) mkdir($this->getDataFolder() . "/bounties");
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
            $sender->sendMessage(C::GRAY . "There are " . C::YELLOW . $this->getServer()->getOnlinePlayers() . C::GRAY . "/" . C::YELLOW . $this->getServer()->getMaxPlayers() . C::GRAY . " online on " . C::DARK_GREEN . "Jungle Realm" . C::GRAY . ":");
            $sender->sendMessage(C::AQUA . substr($online, 0, -2));
            return true;
      break;
          case "kms":
          case "suicide":
            $sender->setHealth(0);
            $sender->sendMessage(C::GRAY . "You killed yourself.");
            break;
          case "gamemode":
          case "gm":
            if(!($sender->hasPermission("cmd.gamemode"))){
              $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::DARK_RED . "ERROR: " . C::GRAY . "You need the permission " . C::YELLOW . "cmd.gamemode");
            }else{
              if($sender->hasPermission("cmd.gamemode")){
                $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Specify a gamemode: " . C::AQUA . " Survival (/gms), Creative (/gmc), Spectator (/gmsp), Adventure (/gma)" . C::GRAY . ".");
                break;
                case "gms":
                if($sender->hasPermission("cmd.gamemode.survival")){
                  $sender->setGamemode(0);
                  $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Gamemode set to " . C::AQUA . "Survival" . C::GRAY . "!");
                  break;
                  case "gmc":
                  if($sender->hasPermission("cmd.gamemode.creative")){
                    $sender->setGamemode(1);
                    $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Gamemode set to " . C::AQUA . "Creative" . C::GRAY . "!");
                    break;
                    case "gma":
                    if($sender->hasPermission("cmd.gamemode.adventure")){
                    $sender->setGamemode(2);
                    $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Gamemode set to " . C::AQUA . "Adventure" . C::GRAY . "!");
                    break;
                      case "gmsp":
                      if($sender->hasPermission("cmd.gamemode.spectator")){
                    $sender->setGamemode(3);
                    $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Gamemode set to " . C::AQUA . "Spectator" . C::GRAY . "!");
                    break;
                        case "fly":
                              if($sender->hasPermission("cmd.fly")){
                                 if($sender->getAllowFlight()){
                                   $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Flying Disabled!");
                                   $sender->setAllowFlight(false);
                                }else{
                                   $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Flying Enabled!");
                                   $sender->setAllowFlight(true);
                                break;
                                   case "feed":
                                   case "eat":
                                   if($sender->hasPermission("cmd.eat")){
                                     $sender->setFood(20);
                                     $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Hunger has been filled!");
                                     break;
                                     case "heal":
                                     if($sender->hasPermission("cmd.heal")){
                                       $sender->setHealth(20);
                                       $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Healed back to full health!");
                                       break;
                                       case "bounty":
                                       if(empty($args[0])){
                                         $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Please use " . C::AQUA . "/bounty (PLAYER) ($)" . C::GRAY . ".");
                                         if(isset($args[0]) && isset($args[1])){
                                           if($player = $this->getServer()->getPlayer($args[0])){
                                             $money = EconomyAPI::getInstance()->myMoney($sender);
                                             $pName = $issuer->getName();
                                             $target = $player->getName();
                                             if(!file_exists($this->getDataFolder() . "/bounties/" . strtolower($target) . ".yml")){
                                               $cfg = new Config($this->getDataFolder() . "/bounties/" . strtolower($target) . ".yml", Config::YAML);
                                               $cfg->set("bounty", 0);
                                               $cfg->save();
                                             }
                                             if($args[1] < 5000){
                                               $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "The minimum amount to bounty someone is " . C::AQUA . "$5000" . C::GRAY . ".");
                                               return true;
                                             }
                                             
                                             if(strpos($args[1], ".") !== false){
                                               $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Enter a valid number!");
                                                                           return true;
                                             }

                                             if (!is_numeric($args[1])) {
                                             $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "You specified an invalid bounty amount.");
                                             return true;
                                             }

                                             if ($money < $args[1]) {
                                             $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "You don't have enough balance to put a $" . $args[1] . " bounty on " . $args[0] . "!");
                                             return true;
                                             }

                                             if ($target === $pName or $pName === $target) {
                                             $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "You cannot put a bounty on yourself!");
                                             return true;
                                             }

                                             EconomyAPI::getInstance()->reduceMoney($pName, $args[1]);
                                             $this->getServer()->broadcastMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "BOUNTY" . C::DARK_GRAY . "] " . C::RESET . C::AQUA . $pName . C::GRAY . " has put a " . C::YELLOW . "$" . $args[1] . C::RESET . C::GRAY . " bounty on the head of " . C::AQUA . $futureKill . C::GRAY . "!");
                                             $this->addBounty($player->getName(), $args[1]);
                                             return true;
                                             }else{
                                             $sender->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "COMMANDS" . C::DARK_GRAY . "] " . C::RESET . C::GRAY . "Player is offline!");
                                             return true;
                                             }
                                             break;
