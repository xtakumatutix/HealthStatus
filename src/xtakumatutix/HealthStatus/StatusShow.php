<?php

namespace xtakumatutix\HealthStatus;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\Config;

class StatusShow implements Listener 
{
    private $Main;

    public function __construct(Main $Main)
    {
        $this->Main = $Main;
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        $NameTag = $this->Main->config->get("ネームタグ");
        $NameTag = str_replace("{br}", "\n", $NameTag);
        $NameTag = str_replace("{name}", "$name", $NameTag);
        $task = new ClosureTask(function (int $currentTick) use ($player, $name, $NameTag): void {
            $health = $player->getHealth();
            $maxhealth = $player->getMaxHealth();
            $NameTag = str_replace("{health}", "$health", $NameTag);
            $NameTag = str_replace("{maxhealth}", "$maxhealth", $NameTag);
            $player->setNameTag($NameTag);
        });
        $plugin = Server::getInstance()->getPluginManager()->getPlugin("HealthStatus_V2");//Taskのやつね
        $tick = $this->Main->config->get("更新秒");
        /** @var Plugin $plugin */
        $plugin->getScheduler()->scheduleRepeatingTask($task, 20 * $tick);//一秒更新
    }
}