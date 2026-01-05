<?php

namespace App\Dao;

use PDO;
use PDOException;

trait Crud
{

      private  $ligacao;

    protected function initCrud(PDO $ligacao)
    {
        $this->ligacao = $ligacao;
    }

    public function beginTransaction()
    {
        return $this->ligacao->beginTransaction();
    }

    public function commit()
    {
        return $this->ligacao->commit();
    }

    public function rollback()
    {
        return $this->ligacao->rollBack();
    }

    private function desligar()
    {
        $this->ligacao = null;
    }

    public function ligacao($sql)
    {
        return $this->ligacao->prepare($sql);
    }

    public function read($sql, $params = [])
    {
        $sql = trim((string) $sql);



        if (!preg_match("/^SELECT/i", $sql)) {
            return "Erro: Query não é Compatível";
        }

        try {
            if (!empty($params)) {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute($params);
            } else {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute();
            }

            return $stmt->fetchAll(PDO::FETCH_CLASS, $this->getEntity());
        } catch (PDOException) {
            return false;
        }

        //desligar
        // $this->desligar();
    }

    public function readOne($sql, $params = [])
    {
        $sql = trim((string) $sql);

        if (!preg_match("/^SELECT/i", $sql)) {
            return false;
        }

        try {
            $stmt = $this->ligacao->prepare($sql);
            $stmt->execute($params);

            // Define o modo de fetch para instanciar a classe corretamente
            $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getEntity());

            // $this->desligar();

            return $stmt->fetch();
        } catch (PDOException) {
            // $this->desligar();
            return false;
        }
    }


    protected function insert($sql, $params = [])
    {
        $sql = trim((string) $sql);

        if (!preg_match("/^INSERT/i", $sql)) {
            return "Erro: Query não é  Compatível";
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
        } catch (PDOException $pdoException) {
            echo $pdoException->getMessage();
        }

        //desligar
        // $this->desligar();
    }

    protected function update($sql, $params = [])
    {

        $sql = trim((string) $sql);



        if (!preg_match("/^UPDATE/i", $sql)) {
            return "Erro: Query não é  Compatível";
        }

        try {
            if (!empty($params)) {
                $stmt = $this->ligacao->prepare($sql);
                $result = $stmt->execute($params);
            } else {
                $stmt = $this->ligacao->prepare($sql);
                $result = $stmt->execute();
            }

            return $result;

        } catch (PDOException $pdoException) {
           echo $pdoException;
        }

        //desligar
        // $this->desligar();
    }

    private function statement($sql, $params = [])
    {
        $sql = trim((string) $sql);


        if (preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)) {
            return "Erro: Query não é Compatível";
        }

        try {
            if (!empty($params)) {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute($params);
            } else {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute();
            }

            // return $stmt->fetchAll(PDO::FETCH_ASSOC);
            return true;
        } catch (PDOException) {
            return false;
        }

        //desligar
        // $this->desligar();
    }

    private function delete($sql, $params = [])
    {
        $sql = trim((string) $sql);





        if (!preg_match("/^DELETE/i", $sql)) {
            return "Erro: Query  não é Compatível";
        }

        try {
            if (!empty($params)) {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute($params);
            } else {
                $stmt = $this->ligacao->prepare($sql);
                $stmt->execute();
            }

            return true;
        } catch (PDOException) {
            return false;
        }

        //desligar
        // $this->desligar();
    }
}