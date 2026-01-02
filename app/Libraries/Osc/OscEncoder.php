<?php

namespace App\Libraries\Osc;

/**
 * OSC Message Encoder/Decoder
 * 
 * Implements OSC 1.0 binary encoding/decoding according to specification.
 * All elements are null-terminated, 4-byte aligned, and big-endian encoded.
 */
class OscEncoder
{
    /**
     * Pad string to 4-byte boundary (OSC requirement)
     */
    private static function pad(string $str): string
    {
        $len = strlen($str);
        $pad = (4 - ($len % 4)) % 4;
        return $str . str_repeat("\0", $pad);
    }

    /**
     * Encode OSC message
     * 
     * @param string $path OSC address pattern
     * @param string $types Type tag string (starts with ',')
     * @param array $args Arguments matching the type tag
     * @return string Binary OSC message
     */
    public static function encode(string $path, string $types, array $args): string
    {
        $message = '';

        // Encode path (null-padded to 4-byte boundary)
        $message .= self::pad($path);

        // If no type tag provided, create empty one
        if (empty($types)) {
            $types = ',';
        }

        // Ensure type tag starts with comma
        if ($types[0] !== ',') {
            $types = ',' . $types;
        }

        // Encode type tag (null-padded to 4-byte boundary)
        $message .= self::pad($types);

        // Encode arguments according to type tag
        $typeTag = substr($types, 1); // Skip the ','

        foreach ($args as $i => $arg) {
            if ($i >= strlen($typeTag)) {
                break; // More args than types
            }

            $type = $typeTag[$i];

            switch ($type) {
                case 'i': // int32 (signed, big-endian)
                    $message .= pack('N', (int)$arg);
                    break;

                case 'f': // float32 (big-endian)
                    $message .= pack('N', self::floatToInt32((float)$arg));
                    break;

                case 's': // string (null-padded to 4-byte boundary)
                    $message .= self::pad((string)$arg);
                    break;

                case 'b': // blob (size + data, padded to 4-byte boundary)
                    $blobLen = strlen($arg);
                    $message .= pack('N', $blobLen);
                    $message .= self::pad($arg);
                    break;

                default:
                    // Unknown type - skip or handle as needed
                    break;
            }
        }

        return $message;
    }

    /**
     * Decode OSC message
     * 
     * @param string $data Binary OSC message
     * @return array|null Decoded message with 'path', 'types', and 'args', or null on error
     */
    public static function decode(string $data): ?array
    {
        $offset = 0;
        $result = [];

        // Decode path
        $path = self::readString($data, $offset);
        if ($path === null) {
            return null;
        }
        $result['path'] = $path;

        // Decode type tag
        $types = self::readString($data, $offset);
        if ($types === null || empty($types) || $types[0] !== ',') {
            return null;
        }
        $result['types'] = $types;

        // Decode arguments
        $args = [];
        $typeTag = substr($types, 1); // Skip the ','

        for ($i = 0; $i < strlen($typeTag) && $offset < strlen($data); $i++) {
            $type = $typeTag[$i];

            switch ($type) {
                case 'i': // int32
                    if ($offset + 4 > strlen($data)) {
                        break 2;
                    }
                    $value = unpack('N', substr($data, $offset, 4))[1];
                    // Handle signed int32 (two's complement)
                    if ($value > 2147483647) {
                        $value -= 4294967296;
                    }
                    $args[] = $value;
                    $offset += 4;
                    break;

                case 'f': // float32
                    if ($offset + 4 > strlen($data)) {
                        break 2;
                    }
                    $int32 = unpack('N', substr($data, $offset, 4))[1];
                    $args[] = self::int32ToFloat($int32);
                    $offset += 4;
                    break;

                case 's': // string
                    $str = self::readString($data, $offset);
                    if ($str === null) {
                        break 2;
                    }
                    $args[] = $str;
                    break;

                case 'b': // blob
                    if ($offset + 4 > strlen($data)) {
                        break 2;
                    }
                    $blobLen = unpack('N', substr($data, $offset, 4))[1];
                    $offset += 4;
                    if ($offset + $blobLen > strlen($data)) {
                        break 2;
                    }
                    $blob = substr($data, $offset, $blobLen);
                    $offset += $blobLen;
                    $offset = (int)((($offset + 3) / 4) * 4); // Pad to 4-byte boundary
                    $args[] = $blob;
                    break;

                default:
                    // Unknown type - skip
                    break;
            }
        }

        $result['args'] = $args;
        return $result;
    }

    /**
     * Read null-terminated string from binary data (4-byte aligned)
     */
    private static function readString(string $data, int &$offset): ?string
    {
        $len = strlen($data);
        if ($offset >= $len) {
            return null;
        }

        $end = strpos($data, "\0", $offset);
        if ($end === false) {
            return null;
        }

        $str = substr($data, $offset, $end - $offset);
        
        // Pad offset to 4-byte boundary
        // The string ends at $end (null byte), so we need to round up ($end + 1) to next 4-byte boundary
        $nextOffset = $end + 1;
        $pad = (4 - ($nextOffset % 4)) % 4;
        $offset = $nextOffset + $pad;

        return $str;
    }

    /**
     * Convert float to int32 representation (for big-endian float encoding)
     */
    private static function floatToInt32(float $value): int
    {
        $packed = pack('f', $value);
        $unpacked = unpack('N', $packed);
        return $unpacked[1];
    }

    /**
     * Convert int32 to float (for big-endian float decoding)
     */
    private static function int32ToFloat(int $value): float
    {
        $packed = pack('N', $value);
        $unpacked = unpack('f', $packed);
        return $unpacked[1];
    }
}

