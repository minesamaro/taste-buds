<?php
  declare(strict_types = 1);

  class Database {
    private static $db;

    public static function getDatabase() : PDO {
      return self::getDatabaseConnection();
      if (!isset(self::$db)) {
        self::$db = self::getDatabaseConnection();
      }

      return self::$db;
    }

    private static function getDatabaseConnection() : PDO {
      $db = new PDO('sqlite:' . __DIR__ . '/../sql/database.db');
      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $db;
    }
  }
?>