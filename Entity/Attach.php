<?php

namespace Ephp\ImapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attach
 *
 * @ORM\Table(name="imap_attach")
 * @ORM\Entity(repositoryClass="Ephp\ImapBundle\Entity\AttachRepository")
 */
class Attach {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Body", inversedBy="features")
     * @ORM\JoinColumn(name="body_id", referencedColumnName="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="blob")
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=32)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * Set id
     *
     * @var $id integer 
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set body
     *
     * @param integer $body
     * @return Attach
     */
    public function setBody($body) {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return integer 
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Attach
     */
    public function setFilename($filename) {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return Attach
     */
    public function setData($data) {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Attach
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Attach
     */
    public function setSize($size) {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize() {
        return $this->size;
    }

}