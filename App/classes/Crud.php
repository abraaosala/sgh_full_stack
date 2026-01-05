<?php
namespace App\classes;

use App\Dao\Connexion;

abstract class Crud{

    private $ligacao;

      public function __construct()
      {
          $this->ligacao = Connexion::getInstance();
      }
    
    private function desligar()
    {
        $this->ligacao = null;
    }

    public function read($sql, $params = [])
    {
        $sql = trim((string) $sql);

        if (!preg_match('/^SELECT/i', $sql)) {
            return 'Erro: Query não é Compatível';
        }

        try {
            if (!empty($params)) {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute($params);
            } else {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute();
            }

            return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
        } catch (\PDOException) {
            return false;
        }

        // desligar
        $this->desligar();
    }

    public function insert($sql, $params = [])
    {
        $sql = trim((string) $sql);

        if (!preg_match('/^INSERT/i', $sql)) {
            return 'Erro: Query não é  Compatível';
        }

        try {
            if (!empty($params)) {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute($params);
            } else {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute();
            }

            return $this->ligacao->lastInsertId();
        } catch (\PDOException $pdoException) {
            return $pdoException->getMessage();
        }

        // desligar
        $this->desligar();
    }



    abstract protected function getEntity();
}
