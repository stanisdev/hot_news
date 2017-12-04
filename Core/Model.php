<?php
namespace Core;

use \PDO;

class Model
{
  private $options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ];
  protected $config;

  /**
   * Class life starts here
   */
  public function __construct(\Core\Config $config)
  {
    $this->config = $config;
  }

  /**
   * Conenction to Database
   */
  private function connect()
  {
    $config = $this->config->db;
    return new PDO(
      $config["dialect"] . ":host=" . $config["host"] .";dbname=" . $config["name"] . ";charset=" . $config["charset"],
      $config["username"],
      $config["password"],
      $this->options
    );
  }

  /**
   * Get Database handler
   */
  public function getHandler()
  {
    static $handler = null;
    if (is_null($handler)) {
      $handler = $this->connect();
    }
    return $handler;
  }

  /**
   * Select or find data by given query
   */
  public function find($sql, $params = null, $options = null)
  {
    if (is_null($params)) {
      $sth = $this->getHandler()->query($sql);
      if (!($sth instanceof PDOStatement)) {
        throw new Exception("Plain SQL Query '${sql}' called with error");
      }
    }
    else {
      $sth = $this->prepareQuery($sql, $params);
      if ($sth->execute() !== true) {
        throw new Exception("SQL Query '${sql}' called with error");
      }
    }
    $result = $sth->fetchAll();
    $sth->closeCursor();
    if (is_array($options) && count($result) > 0) {
      return $result[0];
    }
    return $result;
  }

  /**
   * Exec queries like insert, delete etc
   */
  public function exec($sql, $params = null)
  {
    if (is_null($params)) { // if plain query
      $count = $this->getHandler()->exec($sql);
      if (!is_numeric($count)) {
        throw new Exception("SQL Query '${sql}' withount binding params called with error");
      }
      return $count;
    }
    $sth = $this->prepareQuery($sql, $params);
    if ($sth->execute() !== true) {
      throw new Exception("SQL Query '${sql}' called with error");
    }
    return $sth->rowCount();
  }

  /**
   * Prepare query before query within binding params
   */
  private function prepareQuery($sql, $params)
  {
    $sth = $this->getHandler()->prepare($sql);
    foreach ($params as $columnName => $value) {
      $sth->bindParam(":${columnName}", $params[$columnName], $this->getParamType($value));
    }
    return $sth;
  }

  /**
   * Get PDO param-type by given php type
   */
  private function getParamType($param)
  {
    switch (gettype($param)) {
      case 'integer':
        return PDO::PARAM_INT;
      case 'string':
        return PDO::PARAM_STR;
      case 'boolean':
        return PDO::PARAM_BOOL;
      case 'NULL':
        return PDO::PARAM_NULL;
      default:
        throw new Exception("Param has incorrect type");
    }
  }

  /**
   * Remove helpless methods
   */
  private function __sleep() {}

  private function __clone() {}

  private function __wakeup() {}
}
