<?php

namespace xtakumatutix\HealthStatus;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

Class Main extends PluginBase 
{

    public function onEnable() 
    {
        $this->getServer()->getPluginManager()->registerEvents(new StatusShow($this), $this);
        $this->getLogger()->notice("起動完了 - ver.".$this->getDescription()->getVersion());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
            'ネームタグ' => '{name}{br}§c{health}/{maxhealth}',
            '更新秒' => '2'
        ]);
    }
}