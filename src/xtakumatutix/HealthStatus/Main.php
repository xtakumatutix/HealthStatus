<?php

namespace xtakumatutix\HealthStatus;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\utils\Config; //ここまで必須

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
// use pocketmine\event\player\PlayerMoveEvent; これ要らない
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent; //ステータス更新に必要なイベント

class Main extends PluginBase implements Listener
{
    /** @ver $config*/
    // @ver 変数名じゃないよ 正しくは @var 型名
    /** @var Config */
    private $config;

    public function onEnable()
    {
        $this->getServer()->getLogger()->info("[HealthStatus]読み込み完了v1.0.6_by.xtakumatutix");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        /* $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
        '現在の体力の前' => '§c[❤',
        '現在の体力と最大体力の間' => '/',
        '最大体力の後ろ' => ']',
       )); */ // ここのコードはPJZ9nさんに教えてもらいましたサンクス！！

        $this->reloadConfig();
        $this->config = $this->getConfig();
        // resourcesフォルダにconfig.ymlを作っておくことで上の冗長な書き方を省略できるよ
        // $this->getConfig()とnew Config("config.yml") は同じもの
    }

    /*public function Onjoin(PlayerJoinEvent $event)
    {
        $player =$event->getPlayer();
        $this->setTitle($player);
    }*/

    public function onJoin(PlayerJoinEvent $event) // 1文字目は小文字
    {
        $this->setTitle($event->getPlayer());
        // $playerの使い道が他にないからこの場合は変数に入れなくていいかも。まあ正直どっちでもいい気がする
    }

    /*public function Respawn(PlayerRespawnEvent $event)
    {
        $player =$event->getPlayer();
        $this->setTitle($player);
    }*/

    public function onRespawn(PlayerRespawnEvent $event)
    {
        $this->setTitle($event->getPlayer());
    }

    /*public function optionbow(EntityDamageEvent $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Player) {
        }
        $this->setTitle($entity);
    }*/

    public function onDamage(EntityDamageEvent $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Player) {
            $this->setTitle($entity); // ifの中にちゃんと入れてあげよう
        }
    }

    /*public function RegainHealth(EntityRegainHealthEvent $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Player) {
        }
        $this->setTitle($entity);
    }*/

    public function onRegainHealth(EntityRegainHealthEvent $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Player) {
            $this->setTitle($entity);
        }
    }

    public function setTitle(Player $player)
    {
        // $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML); これ要らない
        //$name =$player->getName();
        $name = $player->getName(); // = の周りの空白ェ...
        $health = $player->getHealth();
        $maxHealth = $player->getMaxHealth();
        $config = $this->config->get("現在の体力の前");
        $config2 = $this->config->get("現在の体力と最大体力の間");
        $config3 = $this->config->get("最大体力の後ろ");
        $player->setNameTag($name."\n".$config."".$health."".$config2."".$maxHealth."".$config3."");
        $player->setNameTag("{$name}\n{$config}{$health}{$config2}{$maxHealth}{$config3}");
        // ""で繋げなくても{$変数名}で入るよ

        /**
         * 1個前の状態が表示されるバグがあるけどスケジューラー使わないといけないからまた今度
         */
    }
}
