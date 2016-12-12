<?php

namespace CustomEnchants;

use pocketmine\entity\Effect;
use pocketmine\utils\TextFormat as C;

class CustomEnchantments{
  public function __construct(CustomEnchants $plugin){
    $this->plugin = $plugin;
  }
  
  public function callEnchant($enchant, $damager, $victim, $level, $event){
    $item = $damager->getItemInHand();
    $enchant = strtolower($enchant);
    $blindness = Effect::getEffect(15)->setVisible(false);
    $nausea = Effect::getEffect(9)->setVisible(false);
    $poison = Effect::getEffect(19)->setVisible(false)->setAmplifier(1);
    $weakness = Effect::getEffect(18)->setVisible(false)->setAmplifier(1);
    $slowness = Effect::getEffect(2)->setVisible(false)->setAmplifier(2);
    $haste = Effect::getEffect(3)->setVisible(false)->setAmplifier(2);
    $speed = Effect::getEffect(1)->setVisible(false)->setAmplifier(3);
    $wither = Effect::getEffect(20)->setVisible(false)->setAmplifier(1);
    $strength = Effect::getEffect(5)->setVisible(false)->setAmplifier(1);
    $regen = Effect:getEffect(10)->setVisible(false)->setAmplifier(2);
    $invis = Effect:getEffect(14)->setVisible(false)->setAmplifier(1);
      
    switch ($enchant){
      case "blindness":
        switch(mt_rand(1, 20) == 1){
            case 2:
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::GREEN . "You've blinded your enemy!");
            $victim->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::RED . "Your enemy has blinded you!");
            $blindness->setDuration(200 + 10 * $level);
            $victim->addEffect($blindness);
            break;
        }
        break;
      case "venom":
        switch(mt_rand(1, 20) == 1){
          case 3:
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::GREEN . "Enemy has been injected with venom!");
            $victim->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::RED . "You've been injected with venom!");
            $poison->setDuration(200 + 20 * $level);
            $victim->addEffect($poison);
            break;
        }
        break;
      case "vampire":
        switch(mt_rand(1,40) == 1){
          case 4:
            $dmgrhealth = $damager->getHealth();
            $vctmhealth = $victim->getHealth();
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::GREEN . "+4 HP stolen from enemy!");
            $damager->setHealth($dmgrhealth + 4);
            $victim->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::RED . "-4 HP stolen by the enemy!");
            $victim->setHealth($vctmhealth - 4);
            break;
        }
        break;
      case "wither":
        switch(mt_rand(1,20) == 1){
          case 5:
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::GREEN . "Enemy has been withered!");
            $victim->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::RED . "You've been withered!");
            $wither->setDuration(200 + 10 * $level);
            $victim->addEffect($wither);
            break;
        }
        break;
      case "iceaspect":
        /* TO DO */
