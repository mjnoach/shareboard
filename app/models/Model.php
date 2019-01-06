<?php
abstract class Model
{
  protected $dbh;
  protected $sth;

  public function __construct() {
    $dsn = PDO_DSN_PREFIX.':dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;

    try {
      $this->dbh = new PDO($dsn, DB_USER, DB_PASS);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public function prepare($query) {
    try {
      $this->sth = $this->dbh->prepare($query);
    }
    catch (PDOException $e) {
      echo 'Operation failed: ' . $e->getMessage();
    }
  }

  public function bind($param, $value) {
    $this->sth->bindValue($param, $value);
  }

  public function bindInt($param, $value) {
    $this->sth->bindValue($param, $value, PDO::PARAM_INT);
  }

  public function execute($array = null) {
    return $array == null ? $this->sth->execute() : $this->sth->execute($array);
  }

  public function fetch() {
    return $this->sth->fetch();
  }

  public function fetchAll() {
    return $this->sth->fetchAll();
  }

  public function countAffectedRows() {
    return $this->sth->rowCount();
  }

  public function getPicutreExtension($name) {
    $path = __DIR__.'/../../public/assets/img/uploads/'.$name;
    if(file_exists($path.'.png')) return '.png';
    if(file_exists($path.'.jpg')) return '.jpg';
    if(file_exists($path.'.jpeg')) return '.jpeg';
  }
}
