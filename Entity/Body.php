<?php

namespace Ephp\ImapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Body
 *
 * @ORM\Table(name="imap_body")
 * @ORM\Entity(repositoryClass="Ephp\ImapBundle\Entity\BodyRepository")
 */
class Body {

    /**
     * @var Header
     * 
     * @ORM\OneToOne(targetEntity="Header", inversedBy="body")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * */
    private $header;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text")
     */
    private $html;

    /**
     * @var string
     *
     * @ORM\Column(name="txt", type="text")
     */
    private $txt;

    /**
     * @ORM\OneToMany(targetEntity="Attach", mappedBy="body", cascade={"all"})
     * */
    private $attach;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->header->getId();
    }

    /**
     * Set header
     *
     * @param integer $header
     * @return Body
     */
    public function setHeader($header) {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return integer 
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * Set html
     *
     * @param string $html
     * @return Body
     */
    public function setHtml($html) {
        $html = utf8_encode($html);
        $this->html = $html;
        $this->txt = trim(str_replace(array('     ', '    ', '   ', '  '), array(' ', ' ', ' ', ' '), strip_tags(str_replace('>', '> ', $html))));

        return $this;
    }

    /**
     * Get html
     *
     * @return string 
     */
    public function getHtml() {
        return $this->html;
    }

    /**
     * Set txt
     *
     * @param string $txt
     * @return Body
     */
    public function setTxt($txt) {
        $this->txt = $txt;

        return $this;
    }

    /**
     * Get txt
     *
     * @return string 
     */
    public function getTxt() {
        return $this->txt;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->attach = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add attach
     *
     * @param \Ephp\ImapBundle\Entity\Attach $attach
     * @return Body
     */
    public function addAttach(\Ephp\ImapBundle\Entity\Attach $attach) {
        $attach->setBody($this);
        $this->attach[] = $attach;

        return $this;
    }

    /**
     * Remove attach
     *
     * @param \Ephp\ImapBundle\Entity\Attach $attach
     */
    public function removeAttach(\Ephp\ImapBundle\Entity\Attach $attach) {
        $this->attach->removeElement($attach);
    }

    /**
     * Get attach
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttach() {
        return $this->attach;
    }
    
    public function getSubject() {
        return $this->header ? $this->header->getSubject() : 'N.S.';
    }

}