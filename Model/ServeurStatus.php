<?php
/**
 * Created by PhpStorm.
 * User: CodingByJerez
 * Url: http://coding.by.jerez.me
 * Github: https://github.com/CodingByJerez
 * Date: 28/10/2019
 * Time: 16:00
 */

namespace CodingByJerez\MinecraftBundle\Model;


use CodingByJerez\MinecraftBundle\Util\TextInHtml;

class ServeurStatus
{
    /** @var bool */
    private $online;

    /** @var Version */
    private $version;

    /** @var Joueurs */
    private $joueurs;

    /** @var string */
    private $description;

    /** @var string */
    private $favicon;


    public function __construct()
    {
        $this->online = false;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOnline(): bool
    {
        return $this->online;
    }

    /**
     * @param bool $online
     * @return ServeurStatus
     */
    public function setOnline(bool $online): self
    {
        $this->online = $online;
        return $this;
    }



    /**
     * @return Version
     */
    public function getVersion(): Version
    {
        return $this->version;
    }

    /**
     * @param Version $version
     * @return ServeurStatus
     */
    public function setVersion(Version $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return Joueurs
     */
    public function getJoueurs(): Joueurs
    {
        return $this->joueurs;
    }

    /**
     * @param Joueurs $joueurs
     * @return ServeurStatus
     */
    public function setJoueurs(Joueurs $joueurs): self
    {
        $this->joueurs = $joueurs;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param object $description
     * @return ServeurStatus
     */
    public function setDescription($description): self
    {
        $this->description = TextInHtml::GetInHTML($description);
        return $this;
    }

    /**
     * @return string
     */
    public function getFavicon(): string
    {
        return $this->favicon;
    }

    /**
     * @param string $favicon
     * @return ServeurStatus
     */
    public function setFavicon(string $favicon): self
    {
        $this->favicon = $favicon;
        return $this;
    }





}