<?php

namespace Ephp\ImapBundle\Controller\Traits;

trait ImapController {

    private $inbox = null;

    /**
     * @return resource
     */
    protected function openImap($server = null, $port = null, $protocol = null, $username = null, $password = null) {
        if (!$server) {
            $server = $this->container->getParameter('ephp_imap.server');
        }
        if (!$port) {
            $port = $this->container->getParameter('ephp_imap.port');
        }
        if (!$protocol) {
            $protocol = $this->container->getParameter('ephp_imap.protocol');
        }
        if (!$username) {
            $username = $this->container->getParameter('ephp_imap.username');
        }
        if (!$password) {
            $password = $this->container->getParameter('ephp_imap.password');
        }
        $connection = '{' . $server . ':' . $port . '/' . $protocol . '}INBOX';
        try {
            $this->inbox = imap_open($connection, $username, $password);
            return $this->inbox;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return integer
     */
    protected function countMessages($inbox = null) {
        if (!$inbox) {
            $inbox = $this->inbox;
        }
        return imap_num_msg($inbox);
    }

    /**
     * @return \Ephp\ImapBundle\Entity\Header
     */
    protected function getHeaders($tot, $n = null, $inbox = null) {
        if(!$n) {
            $n = $tot;
        }
        $out = array();
        for ($i = $tot; $i > $tot - $n; $i--) {
            $out[] = $this->getHeader($i, $inbox);
        }
        return $out;
    }

    /**
     * @return \Ephp\ImapBundle\Entity\Header
     */
    protected function getHeader($i, $inbox = null) {
        if (!$inbox) {
            $inbox = $this->inbox;
        }
        $header = imap_headerinfo($inbox, $i);
        if (!$header) {
            throw new \Exception('Email not found');
        }
        $out = new \Ephp\ImapBundle\Entity\Header();
        $out->setSubject($header->Subject);
        $out->setSize($header->Size);
        $out->setDate($header->Date);
        $out->setMessageId($header->message_id);
        if (isset($header->to)) {
            $out->setTo($header->to);
        }
        if (isset($header->from)) {
            $out->setFrom($header->from);
        }
        if (isset($header->cc)) {
            $out->setCc($header->cc);
        }
        if (isset($header->bcc)) {
            $out->setBcc($header->bcc);
        }
        return $out;
    }

}