<?php
class SecurityLogger {
    private static $logFile = __DIR__ . '/security.log';

    public static function log($level, $event, $details = '') {
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN_IP';
        
        $entry = sprintf("[%s] [%s] [IP: %s] %s | %s" . PHP_EOL, 
            $timestamp, 
            strtoupper($level), 
            $ip, 
            $event, 
            $details
        );
        
        file_put_contents(self::$logFile, $entry, FILE_APPEND);
    }
}