<?php
/**
 * Created by PhpStorm.
 * User: CodingByJerez
 * Url: http://coding.by.jerez.me
 * Github: https://github.com/CodingByJerez
 * Date: 28/10/2019
 * Time: 16:05
 */

namespace CodingByJerez\MinecraftBundle\Model;


class Joueurs
{

    /** @var integer */
    private $max;

    /** @var integer */
    private $online;


    /**
     * Joueurs constructor.
     * @param array $joueurs
     */
    public function __construct($joueurs = null)
    {
        if(!is_null($joueurs)){
            $this->max = $joueurs->max ?? 0;
            $this->online = $joueurs->online ?? 0;
        }else{
            $this->max = 0;
            $this->online = 0;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $max
     * @return Joueurs
     */
    public function setMax(int $max): self
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @return int
     */
    public function getOnline(): int
    {
        return $this->online;
    }

    /**
     * @param int $online
     * @return Joueurs
     */
    public function setOnline(int $online): self
    {
        $this->online = $online;
        return $this;
    }



}