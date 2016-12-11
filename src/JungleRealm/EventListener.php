<?php

namespace EventListener;

/*
Custom Enchants Key
§c = Common
§e = Unique
§a = Legendary
§5 = Mythical
*/

use onebone\economyapi\EconomyAPI;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\{Player, Server};
use pocketmine\utils\TextFormat as C;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

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
        $armor = $p->getInventory()->getArmorContents();
        
        if(!$item->hasEnchantments()){
          return;
        if($item->hasEnchantment(100)){
          $this->ce->callEnchant("§cBlindness", $pl, $p, $item->getEnchantment(100)->getLevel(), $event);
        }
          if($item->hasEnchantment(101)){ 
            $this->ce->callEnchant("§cVenom", $pl, $p, $item->getEnchantment(101)->getLevel(), $event);
          }
            if($item->hasEnchantment(102)){
              $this->ce->callEnchant("§5Vampire", $pl, $p, $item->getEnchantment(102)->getLevel(), $event);
            }
              if($item->hasEnchantment(103)){
                $this->ce->callEnchant("§eObliteration", $pl, $p, $item->getEnchantment(103)->getLevel(), $event);
              }
                 if($item->hasEnchantment(104)){
                   $this->ce->callEnchant("§eWither", $pl, $p, $item->getEnchantment(104)->getLevel(), $event);
                 }
                    if($item->hasEnchantment(105)){
                      $this->ce->callEnchant("§eIceAspect", $pl, $p, $item->getEnchantment(105)->getLevel(), $event);
                    }
                       if($item->hasEnchantment(106)){
                         $this->ce->callEnchant("§aFurnace", $pl, $p, $item->getEnchantment(106)->getLevel(), $event);
                       }
                          if($item->hasEnchantment(107)){
                            $this->ce->callEnchant("§aCloak", $pl, $p, $item->getEnchantment(107)->getLevel(), $event);
                          }
                             if($armor->hasEnchantment(108)){
                               $this->ce->callEnchant("§aSwift", $pl, $p, $armor->getEnchantment(108)->getLevel(), $event);
                             }
                                if($armor->hasEnchantment(109)){
                                  $this->ce->callEnchant("§aBunny", $pl, $p, $armor->getEnchantment(109)->getLevel(), $event);
                                }
                                   if($armor->hasEnchantment(110)){
                                     $this->ce->callEnchant("§5Escape", $pl, $p, $armor->getEnchantment(110)->getLevel(), $event);
                                   }
