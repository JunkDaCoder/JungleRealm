<?php

namespace EventListener;

use onebone\economyapi\EconomyAPI;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as C;

class EventListener implements Listener{
  public function __construct(EventListener $plugin){
    $this->ce = new CustomEnchantments($plugin);
    this->plugin = $plugin;
    
    public function onHurt(EntityDamageEvent $event){
      $entity = $event->getEntity();
      $cause = $event->getCause();
      if($entity instanceof Player){
        if($cause == EntityDamageEvent::CAUSE_FALL){
          $event->setCancelled(true);
        }
        $p = $event->getEntity();
        $pl = $event->getDamager();
        $item = $pl->getInventory()->getItemInHand();
        if(!$item->hasEnchantments()) return;
        if($item->hasEnchantment(100)){
          $this->ce->callEnchant("Blindness", $pl, $p, $item->getEnchantment(100)->getLevel(), $event);
        }
          if($it->hasEnchantment(101)){ 
            $this->ce->callEnchant("Venom", $pl, $p, $item->getEnchantment(101)->getLevel(), $event);
          }
            if($it->hasEnchantment(102)){
              $this->ce->callEnchant("Vampire", $pl, $p, $item->getEnchantment(102)->getLevel(), $event);
            }
              if($it->hasEnchantment(103)){
                $this->ce->callEnchant("Obliteration", $pl, $p, $item->getEnchantment(103)->getLevel(), $event);
              }
                 if($it->hasEnchantment(104)){
                   $this->ce->callEnchant("Wither", $pl, $p, $item->getEnchantment(119)->getLevel(), $event);
                 }
        
