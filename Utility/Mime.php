<?php

namespace Ephp\ImapBundle\Utility;

class Mime {

    public static function decode($string) {
        $parts = imap_mime_header_decode($string);
        $s = '';
        foreach ($parts as $part) {
            $s .= $part->text;
        }
        return $s;
    }

    public static function email($mailbox, $host) {
        return "{$mailbox}@{$host}";
    }

}