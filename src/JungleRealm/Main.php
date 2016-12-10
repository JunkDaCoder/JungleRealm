<?php

namespace Main;

use pocketmine\{Player, Server};
use pocketmine\event\PlayerJoinEvent;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Listener;

class Main extends PluginBase implements Listener{
public function onEnable(){
