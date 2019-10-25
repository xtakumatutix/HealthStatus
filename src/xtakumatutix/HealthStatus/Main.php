<?php

namespace xtakumatutix\HealthStatus;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;

class Main extends PluginBase implements Listener {

	public function onEnable(){
        $this->getServer()->getLogger()->info("[HealthStatus]読み込み完了v1.0.2_by.xtakumatutix");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function Onjoin(PlayerJoinEvent $event){
    	$player =$event->getPlayer(); 
        $this->setTitle($player);
    }

    public function Respawn(PlayerRespawnEvent $event){
        $player =$event->getPlayer(); 
        $this->setTitle($player);
    }

    public function Move(PlayerMoveEvent $event){
        $player =$event->getPlayer(); 
        $this->setTitle($player);
    }

    public function optionbow(EntityDamageEvent $event){
        $entity = $event->getEntity();
        if($entity instanceof Player){
        }
        $this->setTitle($entity);
    }

    public function RegainHealth(EntityRegainHealthEvent $event){
        $entity = $event->getEntity();
        if($entity instanceof Player){
        }
        $this->setTitle($entity);
    }

    public function setTitle(Player $player){
        $name =$player->getName();
        $health =$player->getHealth();
        $maxHealth =$player->getMaxHealth();
        $player->setNameTag($name."\n".$health."/".$maxHealth);
    }
}