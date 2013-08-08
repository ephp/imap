<?php

namespace Ephp\ImapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ephp\ImapBundle\Utility\Mime;

/**
 * Header
 *
 * @ORM\Table(name="imap_header")
 * @ORM\Entity(repositoryClass="Ephp\ImapBundle\Entity\HeaderRepository")
 */
class Header {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="message_id", type="string", length=255, nullable=true)
     */
    private $message_id;

    /**
     * @var string
     *
     * @ORM\Column(name="to_name", type="string", length=255, nullable=true)
     */
    private $to_name;

    /**
     * @var string
     *
     * @ORM\Column(name="to_address", type="string", length=255, nullable=true)
     */
    private $to_address;

    /**
     * @var array
     *
     * @ORM\Column(name="to_array_names", type="array", nullable=true)
     */
    private $to_array_names;

    /**
     * @var array
     *
     * @ORM\Column(name="to_array_addresses", type="array", nullable=true)
     */
    private $to_array_addresses;

    /**
     * @var string
     *
     * @ORM\Column(name="from_name", type="string", length=255, nullable=true)
     */
    private $from_name;

    /**
     * @var string
     *
     * @ORM\Column(name="from_address", type="string", length=255, nullable=true)
     */
    private $from_address;

    /**
     * @var array
     *
     * @ORM\Column(name="from_array_names", type="array", nullable=true)
     */
    private $from_array_names;

    /**
     * @var array
     *
     * @ORM\Column(name="from_array_addresses", type="array", nullable=true)
     */
    private $from_array_addresses;

    /**
     * @var string
     *
     * @ORM\Column(name="cc_name", type="string", length=255, nullable=true)
     */
    private $cc_name;

    /**
     * @var string
     *
     * @ORM\Column(name="cc_address", type="string", length=255, nullable=true)
     */
    private $cc_address;

    /**
     * @var array
     *
     * @ORM\Column(name="cc_array_names", type="array", nullable=true)
     */
    private $cc_array_names;

    /**
     * @var array
     *
     * @ORM\Column(name="cc_array_addresses", type="array", nullable=true)
     */
    private $cc_array_addresses;

    /**
     * @var string
     *
     * @ORM\Column(name="bcc_name", type="string", length=255, nullable=true)
     */
    private $bcc_name;

    /**
     * @var string
     *
     * @ORM\Column(name="bcc_address", type="string", length=255, nullable=true)
     */
    private $bcc_address;

    /**
     * @var array
     *
     * @ORM\Column(name="bcc_array_names", type="array", nullable=true)
     */
    private $bcc_array_names;

    /**
     * @var array
     *
     * @ORM\Column(name="bcc_array_addresses", type="array", nullable=true)
     */
    private $bcc_array_addresses;

    /**
     * @ORM\OneToOne(targetEntity="Body", mappedBy="header", cascade={"all"})
     */
    private $body;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Header
     */
    public function setSubject($subject) {
        $this->subject = Mime::decode($subject);

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Header
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

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Header
     */
    public function setDate($date) {
        $this->date = new \DateTime(date("c", strtotime($date)));

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set message_id
     *
     * @param string $messageId
     * @return Header
     */
    public function setMessageId($messageId) {
        $this->message_id = $messageId;

        return $this;
    }

    /**
     * Get message_id
     *
     * @return string 
     */
    public function getMessageId() {
        return $this->message_id;
    }

    /**
     * Set to_name
     *
     * @param string $toName
     * @return Header
     */
    public function setToName($toName) {
        $this->to_name = $toName;

        return $this;
    }

    /**
     * Get to_name
     *
     * @return string 
     */
    public function getToName() {
        return $this->to_name;
    }

    /**
     * Set to_address
     *
     * @param string $toAddress
     * @return Header
     */
    public function setToAddress($toAddress) {
        $this->to_address = $toAddress;

        return $this;
    }

    /**
     * Get to_address
     *
     * @return string 
     */
    public function getToAddress() {
        return $this->to_address;
    }

    /**
     * Set to_array_names
     *
     * @param array $toArrayNames
     * @return Header
     */
    public function setToArrayNames($toArrayNames) {
        $this->to_array_names = $toArrayNames;

        return $this;
    }

    /**
     * Get to_array_names
     *
     * @return array 
     */
    public function getToArrayNames() {
        return $this->to_array_names;
    }

    /**
     * Set to_array_addresses
     *
     * @param array $toArrayAddresses
     * @return Header
     */
    public function setToArrayAddresses($toArrayAddresses) {
        $this->to_array_addresses = $toArrayAddresses;

        return $this;
    }

    /**
     * Get to_array_addresses
     *
     * @return array 
     */
    public function getToArrayAddresses() {
        return $this->to_array_addresses;
    }

    /**
     * Set from_name
     *
     * @param string $fromName
     * @return Header
     */
    public function setFromName($fromName) {
        $this->from_name = $fromName;

        return $this;
    }

    /**
     * Get from_name
     *
     * @return string 
     */
    public function getFromName() {
        return $this->from_name;
    }

    /**
     * Set from_address
     *
     * @param string $fromAddress
     * @return Header
     */
    public function setFromAddress($fromAddress) {
        $this->from_address = $fromAddress;

        return $this;
    }

    /**
     * Get from_address
     *
     * @return string 
     */
    public function getFromAddress() {
        return $this->from_address;
    }

    /**
     * Set from_array_names
     *
     * @param array $fromArrayNames
     * @return Header
     */
    public function setFromArrayNames($fromArrayNames) {
        $this->from_array_names = $fromArrayNames;

        return $this;
    }

    /**
     * Get from_array_names
     *
     * @return array 
     */
    public function getFromArrayNames() {
        return $this->from_array_names;
    }

    /**
     * Set from_array_addresses
     *
     * @param array $fromArrayAddresses
     * @return Header
     */
    public function setFromArrayAddresses($fromArrayAddresses) {
        $this->from_array_addresses = $fromArrayAddresses;

        return $this;
    }

    /**
     * Get from_array_addresses
     *
     * @return array 
     */
    public function getFromArrayAddresses() {
        return $this->from_array_addresses;
    }

    /**
     * Set cc_name
     *
     * @param string $ccName
     * @return Header
     */
    public function setCcName($ccName) {
        $this->cc_name = $ccName;

        return $this;
    }

    /**
     * Get cc_name
     *
     * @return string 
     */
    public function getCcName() {
        return $this->cc_name;
    }

    /**
     * Set cc_address
     *
     * @param string $ccAddress
     * @return Header
     */
    public function setCcAddress($ccAddress) {
        $this->cc_address = $ccAddress;

        return $this;
    }

    /**
     * Get cc_address
     *
     * @return string 
     */
    public function getCcAddress() {
        return $this->cc_address;
    }

    /**
     * Set cc_array_names
     *
     * @param array $ccArrayNames
     * @return Header
     */
    public function setCcArrayNames($ccArrayNames) {
        $this->cc_array_names = $ccArrayNames;

        return $this;
    }

    /**
     * Get cc_array_names
     *
     * @return array 
     */
    public function getCcArrayNames() {
        return $this->cc_array_names;
    }

    /**
     * Set cc_array_addresses
     *
     * @param array $ccArrayAddresses
     * @return Header
     */
    public function setCcArrayAddresses($ccArrayAddresses) {
        $this->cc_array_addresses = $ccArrayAddresses;

        return $this;
    }

    /**
     * Get cc_array_addresses
     *
     * @return array 
     */
    public function getCcArrayAddresses() {
        return $this->cc_array_addresses;
    }

    /**
     * Get bcc_address
     *
     * @return string 
     */
    public function getBccAddress() {
        return $this->bcc_address;
    }

    /**
     * Set bcc_array_names
     *
     * @param array $bccArrayNames
     * @return Header
     */
    public function setBccArrayNames($bccArrayNames) {
        $this->bcc_array_names = $bccArrayNames;

        return $this;
    }

    /**
     * Get bcc_array_names
     *
     * @return array 
     */
    public function getBccArrayNames() {
        return $this->bcc_array_names;
    }

    /**
     * Set bcc_array_addresses
     *
     * @param array $bccArrayAddresses
     * @return Header
     */
    public function setBccArrayAddresses($bccArrayAddresses) {
        $this->bcc_array_addresses = $bccArrayAddresses;

        return $this;
    }

    /**
     * Get bcc_array_addresses
     *
     * @return array 
     */
    public function getBccArrayAddresses() {
        return $this->bcc_array_addresses;
    }

    public function setTo($to_list) {
        $first = true;
        $toNames = $toAddresses = array();
        foreach ($to_list as $to) {
            $toName = isset($to->personal) ? Mime::decode($to->personal) : Mime::email($to->mailbox, $to->host);
            $toAddress = Mime::email($to->mailbox, $to->host);
            if ($first) {
                $first = false;
                $this->setToName($toName);
                $this->setToAddress($toAddress);
            }
            $toNames[] = $toName;
            $toAddresses[] = $toAddress;
        }
        $this->setToArrayNames($toNames);
        $this->setToArrayAddresses($toAddresses);
    }

    public function setFrom($from_list) {
        $first = true;
        $fromNames = $fromAddresses = array();
        foreach ($from_list as $from) {
            $fromName = isset($from->personal) ? Mime::decode($from->personal) : Mime::email($from->mailbox, $from->host);
            $fromAddress = Mime::email($from->mailbox, $from->host);
            if ($first) {
                $first = false;
                $this->setFromName($fromName);
                $this->setFromAddress($fromAddress);
            }
            $fromNames[] = $fromName;
            $fromAddresses[] = $fromAddress;
        }
        $this->setFromArrayNames($fromNames);
        $this->setFromArrayAddresses($fromAddresses);
    }

    public function setCc($cc_list) {
        $first = true;
        $ccNames = $ccAddresses = array();
        foreach ($cc_list as $cc) {
            $ccName = isset($cc->personal) ? Mime::decode($cc->personal) : Mime::email($cc->mailbox, $cc->host);
            $ccAddress = Mime::email($cc->mailbox, $cc->host);
            if ($first) {
                $first = false;
                $this->setCcName($ccName);
                $this->setCcAddress($ccAddress);
            }
            $ccNames[] = $ccName;
            $ccAddresses[] = $ccAddress;
        }
        $this->setCcArrayNames($ccNames);
        $this->setCcArrayAddresses($ccAddresses);
    }

    public function setBcc($bcc_list) {
        $first = true;
        $bccNames = $bccAddresses = array();
        foreach ($bcc_list as $bcc) {
            $bccName = isset($bcc->personal) ? Mime::decode($bcc->personal) : Mime::email($bcc->mailbox, $bcc->host);
            $bccAddress = Mime::email($bcc->mailbox, $bcc->host);
            if ($first) {
                $first = false;
                $this->setBccName($bccName);
                $this->setBccAddress($bccAddress);
            }
            $bccNames[] = $bccName;
            $bccAddresses[] = $bccAddress;
        }
        $this->setBccArrayNames($bccNames);
        $this->setBccArrayAddresses($bccAddresses);
    }


    /**
     * Set bcc_name
     *
     * @param string $bccName
     * @return Header
     */
    public function setBccName($bccName)
    {
        $this->bcc_name = $bccName;
    
        return $this;
    }

    /**
     * Get bcc_name
     *
     * @return string 
     */
    public function getBccName()
    {
        return $this->bcc_name;
    }

    /**
     * Set bcc_address
     *
     * @param string $bccAddress
     * @return Header
     */
    public function setBccAddress($bccAddress)
    {
        $this->bcc_address = $bccAddress;
    
        return $this;
    }

    /**
     * Set body
     *
     * @param \Ephp\ImapBundle\Entity\Body $body
     * @return Header
     */
    public function setBody(\Ephp\ImapBundle\Entity\Body $body = null)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return \Ephp\ImapBundle\Entity\Body 
     */
    public function getBody()
    {
        return $this->body;
    }
}