<?php
namespace Crc16CCIT;
/**
 * Calculate CRC16-CCIT checksum
 * Code ported to PHP from Java
 *
 * Oryginal source:
 * http://introcs.cs.princeton.edu/java/51data/CRC16CCITT.java.html
 * CRC16-CCIT for 123456789 = 29b1
 *
 * Online calculator for testing:
 * http://zorc.breitbandkatze.de/crc.html
 */
class Crc16CCIT
{
    /**
     * @param string $data
     * @return string
     */
    public static function calculate($data)
    {

        $crc = 0xFFFF;
        $polynomial = 0x1021;

        foreach (str_split($data, 1) as $char) {
            $byte = ord($char);
            for ($i = 0; $i < 8; $i++) {
                $bit = (($byte >> (7 - $i) & 1) == 1);
                $c15 = (($crc >> 15 & 1) == 1);
                $crc <<= 1;
                if ($c15 ^ $bit) {
                    $crc ^= $polynomial;
                }
            }
        }

        $crc &= 0xffff;

        return dechex($crc);
    }
}