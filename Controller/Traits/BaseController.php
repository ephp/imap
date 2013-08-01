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
            $inbox = $this->$inbox;
        }
        return imap_num_msg($inbox);
    }

    /**
     * @return integer
     */
    protected function getHeader($i, $inbox = null) {
        if (!$inbox) {
            $inbox = $this->$inbox;
        }
        $header = imap_headerinfo($inbox, $i);
        $out = array();
        
    }

}