<?php
/**
 * Created by PhpStorm.
 * User: CodingByJerez
 * Url: http://coding.by.jerez.me
 * Github: https://github.com/CodingByJerez
 * Date: 28/10/2019
 * Time: 16:02
 */

namespace CodingByJerez\MinecraftBundle\Model;


class Version
{

    /** @var string */
    private $nom;

    /** @var integer */
    private $protocol;


    /**
     * Version constructor.
     * @param array $version
     */
    public function __construct($version = null)
    {
        if(!is_null($version)){
            $this->nom = $version->name ?? "";
            $this->protocol = $version->protocol ?? "";
        }else{
            $this->nom = "x.x.x";
            $this->protocol = 0;
        }


        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Version
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return int
     */
    public function getProtocol(): int
    {
        return $this->protocol;
    }

    /**
     * @param int $protocol
     * @return Version
     */
    public function setProtocol(int $protocol): self
    {
        $this->protocol = $protocol;
        return $this;
    }



}