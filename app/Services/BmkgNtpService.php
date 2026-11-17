<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class BmkgNtpService
{
    public const NTP_HOST = 'ntp.bmkg.go.id';
    public const NTP_PORT = 123;
    public const TIMEOUT_SECONDS = 1.0;
    public const CACHE_KEY = 'bmkg_ntp_offset';
    public const CACHE_TTL_SECONDS = 300; // 5 minutes cache

    /**
     * Get current timestamp in milliseconds adjusted by BMKG NTP offset.
     */
    public function getTimestampMs(): float
    {
        $offset = $this->getOffset();
        $now = microtime(true) + $offset;

        return round($now * 1000);
    }

    /**
     * Get offset in seconds between local system clock and ntp.bmkg.go.id.
     */
    public function getOffset(): float
    {
        try {
            return (float) Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
                $offset = $this->queryNtpOffset();
                // If NTP query fails, return 0.0 (fallback to local server clock)
                return $offset ?? 0.0;
            });
        } catch (\Throwable $e) {
            // Graceful fallback to zero offset if cache or network encounters an issue
            return 0.0;
        }
    }

    /**
     * Query ntp.bmkg.go.id via UDP socket (RFC 5905 SNTP).
     */
    public function queryNtpOffset(): ?float
    {
        $socket = @fsockopen('udp://' . self::NTP_HOST, self::NTP_PORT, $errNo, $errStr, self::TIMEOUT_SECONDS);
        if (!$socket) {
            return null;
        }

        // Standard 48-byte NTP client request packet
        // Byte 0: LI = 0, VN = 3, Mode = 3 (Client) -> 0x1B, followed by 47 zero bytes
        $packet = chr(0x1B) . str_repeat(chr(0), 47);

        $t0 = microtime(true);
        stream_set_timeout($socket, 1, 0);
        $written = @fwrite($socket, $packet);
        if ($written === false || $written === 0) {
            @fclose($socket);
            return null;
        }

        $response = @fread($socket, 48);
        $t3 = microtime(true);
        @fclose($socket);

        if (!$response || strlen($response) !== 48) {
            return null;
        }

        $data = unpack('N12', $response);
        if (!$data || !isset($data[9], $data[10], $data[11], $data[12])) {
            return null;
        }

        // Convert NTP timestamps (epoch Jan 1 1900) to Unix timestamps (epoch Jan 1 1970)
        // 2208988800 = seconds between 1900 and 1970
        // Data[9..10]: Server Receive Timestamp (T1)
        $t1 = (sprintf('%u', $data[9]) - 2208988800) + (sprintf('%u', $data[10]) / 4294967296);
        // Data[11..12]: Server Transmit Timestamp (T2)
        $t2 = (sprintf('%u', $data[11]) - 2208988800) + (sprintf('%u', $data[12]) / 4294967296);

        if ($t1 <= 0 || $t2 <= 0) {
            return null;
        }

        // SNTP Offset formula: ((T1 - T0) + (T2 - T3)) / 2
        return (($t1 - $t0) + ($t2 - $t3)) / 2;
    }
}
