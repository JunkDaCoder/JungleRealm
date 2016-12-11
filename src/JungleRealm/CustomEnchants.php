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
    switch ($enchant){
      case "blindness":
        switch(mt_rand(1, 15) == 1){
            case 4:
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::GREEN . "You've blinded your enemy!");
            $victim->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::RED . "Your enemy has blinded you!");
            $blindness->setDuration(200 + 10 * $level);
            $victim->addEffect($blindness);
            break;
        }
        break;
      case "venom":
        switch(mt_rand(1, 15) == 1){
          case 6:
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::GREEN . "Enemy has been injected with venom!");
            $victim->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::RED . "You've been injected with venom!");
            $poison->setDuration(200 + $level * 20);
            $victim->addEffect($poison);
            break;
        }
        break;
      case "vampire":
        switch(mt_rand(1,30) == 1){
          case 9:
            $dmgrhealth = $damager->getHealth();
            $vctmhealth = $victim->getHealth();
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::GREEN . "+3 HP stolen from enemy!");
            $damager->setHealth($dmgrhealth + 3);
            $damager->sendMessage(C::DARK_GRAY . C::BOLD . "[" . C::RED . "CE" . C::DARK_GRAY . "] " . C::RESET . C::RED . "-3 HP stolen by the enemy!");
            $victim->setHealth($vctmhealth - 3);
            break;
        }
        break;
