<?php

namespace Ephp\ImapBundle\Controller\Traits;

trait ImapController {

    private $inbox = null;

    /**
     * @return resource
     */
    protected function openImap($server = null, $port = null, $protocol = null, $username = null, $password = null, $inbox = null) {
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
        $connection = '{' . $server . ':' . $port . '/' . $protocol . '}' . $inbox;
        try {
            $this->inbox = imap_open($connection, $username, $password);
            return $this->inbox;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function closeImap($inbox = null) {
        if (!$inbox) {
            $inbox = $this->inbox;
        }
        imap_close($inbox);
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
        if (!$n) {
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
    protected function getHeader($mid, $inbox = null) {
        if (!$inbox) {
            $inbox = $this->inbox;
        }
        $header = imap_headerinfo($inbox, $mid);
        if (!$header) {
            throw new \Exception('Email not found');
        }
        $out = new \Ephp\ImapBundle\Entity\Header();
        if (isset($header->Subject)) {
            $out->setSubject($header->Subject);
        } elseif (isset($header->subject)) {
            $out->setSubject($header->subject);
        } else {
            $out->setSubject('no subject');
        }
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

    /**
     * @return \Ephp\ImapBundle\Entity\Body
     */
    protected function getBody($mid, $inbox = null) {
        if (!$inbox) {
            $inbox = $this->inbox;
        }
        $body = new \Ephp\ImapBundle\Entity\Body();
        $body->setHeader($this->getHeader($mid, $inbox));
        $struct = imap_fetchstructure($inbox, $mid);
        if (isset($struct->parts)) {
            $parts = $struct->parts;
        } else {
            $parts = false;
        }
        $i = 0;
//        \Ephp\UtilityBundle\Utility\Debug::vd(imap_body($inbox, $mid));
        if (!$parts) { /* Simple message, only 1 piece */
            $attachs = array(); /* No attachments */
            $content = imap_body($inbox, $mid);
        } else { /* Complicated message, multiple parts */

            $endwhile = false;

            $stack = array(); /* Stack while parsing message */
            $content = "";    /* Content of message */
            $attachs = array(); /* Attachments */

            while (!$endwhile) {
                if (!isset($parts[$i])) {
                    if (count($stack) > 0) {
                        $parts = $stack[count($stack) - 1]["p"];
                        $i = $stack[count($stack) - 1]["i"] + 1;
                        array_pop($stack);
                    } else {
                        $endwhile = true;
                    }
                }

                if (!$endwhile) {
                    /* Create message part first (example '1.2.3') */
                    $partstring = "";
                    foreach ($stack as $s) {
                        $partstring .= ($s["i"] + 1) . ".";
                    }
                    $partstring .= ($i + 1);

                    if (isset($parts[$i]->disposition) && (strtoupper($parts[$i]->disposition) == "ATTACHMENT" || strtoupper($parts[$i]->disposition) == "INLINE")) { /* Attachment or inline images */
                        $filedata = imap_fetchbody($inbox, $mid, $partstring);
                        if ($filedata != '') {
                            // handles base64 encoding or plain text
                            $decoded_data = base64_decode($filedata);
                            $size = 0;
                            foreach ($parts[$i]->dparameters as $par) {
                                if ($par->attribute == 'SIZE') {
                                    $size = $par->value;
                                }
                            }
                            $attach = new \Ephp\ImapBundle\Entity\Attach();
                            $attach->setFilename($parts[$i]->parameters[0]->value);
                            $attach->setData($decoded_data == false ? $filedata : $decoded_data);
                            $attach->setSize($size);
                            $attach->setId($i);
                            $attach->setType($parts[$i]->subtype);
                            $attachs[] = $attach;
                        }
                    } elseif (strtoupper($parts[$i]->subtype) == "PLAIN" && strtoupper($parts[$i + 1]->subtype) != "HTML") { /* plain text message */
                        $content .= imap_fetchbody($inbox, $mid, $partstring);
                    } elseif (strtoupper($parts[$i]->subtype) == "HTML") {
                        /* HTML message takes priority */
                        $content .= imap_fetchbody($inbox, $mid, $partstring);
                    }
                }

                if (isset($parts[$i]->parts)) {
                    if ($parts[$i]->subtype != 'RELATED') {
                        // a glitch: embedded email message have one additional stack in the structure with subtype 'RELATED', but this stack is not present when using imap_fetchbody() to fetch parts.
                        $stack[] = array("p" => $parts, "i" => $i);
                    }
                    $parts = $parts[$i]->parts;
                    $i = 0;
                } else {
                    $i++;
                }
            } /* while */
        } /* complicated message */

        $body->setHtml(quoted_printable_decode($content));
//        \Ephp\UtilityBundle\Utility\Debug::vd($attachs);
        foreach ($attachs as $attach) {
            /* @var $attach \Ephp\ImapBundle\Entity\Attach */
            $attach->setBody($body);
            $body->addAttach($attach);
        }
        return $body;
    }

    protected function deteteEmail($mid, $inbox = null) {
        if (!$inbox) {
            $inbox = $this->inbox;
        }
        imap_delete($inbox, $mid);
        imap_expunge($inbox);
    }
    
    protected function dir() {
        return str_replace($this->getRequest()->server->get('SCRIPT_NAME'), '', $this->getRequest()->server->get('SCRIPT_FILENAME'));
    }
}