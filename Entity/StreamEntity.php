<?php

namespace Krator\StreamModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StreamEntity
 *
 * @ORM\Table(name="krator_stream_stream")
 * @ORM\Entity(repositoryClass="Krator\StreamModule\Entity\StreamEntityRepository")
 */
class StreamEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="game_id", type="integer")
     */
    private $gameId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="box_art_url", type="string", length=255)
     */
    private $boxArtUrl;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gameId
     *
     * @param integer $gameId
     *
     * @return StreamEntity
     */
    public function setGameId($gameId)
    {
        $this->gameId = $gameId;

        return $this;
    }

    /**
     * Get gameId
     *
     * @return integer
     */
    public function getGameId()
    {
        return $this->gameId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return StreamEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set boxArtUrl
     *
     * @param string $boxArtUrl
     *
     * @return StreamEntity
     */
    public function setBoxArtUrl($boxArtUrl)
    {
        $this->boxArtUrl = $boxArtUrl;

        return $this;
    }

    /**
     * Get boxArtUrl
     *
     * @return string
     */
    public function getBoxArtUrl()
    {
        return $this->boxArtUrl;
    }
}

