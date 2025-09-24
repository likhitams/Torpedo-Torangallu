<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PDO connection helper that *follows CodeIgniter's database.php settings*.
 *
 * Usage in views/controllers:
 *   require_once APPPATH.'libraries/Connection.php';
 *   $pdo = Connection::getConnection();
 *   $stmt = $pdo->prepare('SELECT * FROM some_table WHERE id = ?');
 *   $stmt->execute([123]);
 *   $rows = $stmt->fetchAll(); // default FETCH_OBJ
 */
final class Connection
{
    /** @var \PDO|null */
    private static $instance = null;

    /**
     * Return a shared PDO instance configured from CI's database.php.
     *
     * @return \PDO
     * @throws \RuntimeException on failure (details are logged)
     */
    public static function getConnection()
    {
        if (self::$instance instanceof \PDO) {
            return self::$instance;
        }

        $cfg = self::loadCiDbConfig();

        // Fallbacks if something is missing
        $driver  = isset($cfg['dbdriver']) ? strtolower($cfg['dbdriver']) : 'mysql';
        $host    = $cfg['hostname'] ?? 'localhost';
        $dbname  = $cfg['database'] ?? '';
        $user    = $cfg['username'] ?? 'root';
        $pass    = $cfg['password'] ?? '';
        $charset = $cfg['char_set'] ?? 'utf8';
        $port    = $cfg['port'] ?? null; // CI 2.x usually has no 'port'

        // Map CI driver to PDO DSN scheme
        $scheme = ($driver === 'mysqli' || $driver === 'mysql') ? 'mysql'
                 : (($driver === 'postgre' || $driver === 'pgsql') ? 'pgsql'
                 : $driver);

        // Build DSN (add port if provided)
        $dsn = $scheme . ':host=' . $host
             . ($port ? ';port=' . (int)$port : '')
             . ($dbname !== '' ? ';dbname=' . $dbname : '')
             . ';charset=' . ($charset ?: 'utf8');

        $options = array(
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        );

        try {
            self::$instance = new \PDO($dsn, $user, $pass, $options);
            return self::$instance;
        } catch (\PDOException $e) {
            // Log technical details; show a generic message
            if (function_exists('log_message')) {
                log_message('error', 'PDO connect failed: ' . $e->getMessage());
            } else {
                error_log('PDO connect failed: ' . $e->getMessage());
            }
            throw new \RuntimeException('Database connection failed.');
        }
    }

    /**
     * Load CI's database.php (env-aware) and return the active group's settings.
     *
     * @return array<string,mixed>
     */
    private static function loadCiDbConfig()
    {
        // Prefer environment-specific file if present
        $db = array();
        $active_group = 'default';

        $path = APPPATH . 'config/database.php';
        if (defined('ENVIRONMENT')) {
            $envPath = APPPATH . 'config/' . ENVIRONMENT . '/database.php';
            if (is_file($envPath)) {
                $path = $envPath;
            }
        }

        // Include the file into a local scope so $db and $active_group are available
        if (is_file($path)) {
            /** @noinspection PhpIncludeInspection */
            include $path;
        }

        // Fall back if include failed or variables missing
        if (!isset($db) || !is_array($db)) {
            $db = array();
        }
        if (!isset($active_group) || !isset($db[$active_group])) {
            // Try 'default', else empty array
            $active_group = 'default';
        }

        return isset($db[$active_group]) && is_array($db[$active_group])
            ? $db[$active_group]
            : array();
    }

    /** Optional: close the shared connection */
    public static function close()
    {
        self::$instance = null;
    }
}
