<?php

/*
 * BloonJPHP
 * Habbo R63 Post-Shuffle
 * Based on the work of Burak (burak@burak.fr)
 *
 * https://bloon.burak.fr/ - https://github.com/BurakDev/BloonJPHP
 */

class PacketParser {

    private $fullpacket;
    private $packet;
    private $length;
    private $header;

    public function __construct($packet) {
        $this->packet = $packet;
        $this->fullpacket = $packet;
        $this->readLength();
        $this->readHeader();
    }

    private function pop($length) {
        $this->packet = substr($this->packet, $length);
    }

    private function readLength() {
        $this->length = HabboEncoding::DecodeBit32($this->packet);
        $this->pop(4);

        return $this->length;
    }

    private function readHeader() {
        $this->header = HabboEncoding::DecodeBit16($this->packet);
        $this->pop(2);

        return $this->header;
    }

    public function readInt32() {
        $int32 = HabboEncoding::DecodeBit32($this->packet);
        $this->pop(4);

        return $int32;
    }

    public function readInt16() {
        $int16 = HabboEncoding::DecodeBit16($this->packet);
        $this->pop(2);

        return $int16;
    }

    public function readString() {
        $len = HabboEncoding::DecodeBit16($this->packet);
        $string = substr($this->packet, 2, $len);
        $this->pop($len + 2);

        return $string;
    }

    public function readBoolean() {
        $boolean = (ord($this->packet[0]) == 0) ? false : true;
        $this->pop(1);

        return $boolean;
    }

    public function getHeader() {
        return $this->header;
    }

    public function getLength() {
        return $this->header;
    }

    public function getPacket() {
        return $this->packet;
    }

    public function getFullPacket() {
        return $this->fullpacket;
    }

}
