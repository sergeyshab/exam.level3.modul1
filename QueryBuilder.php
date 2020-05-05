<?php

class QueryBuilder {
    protected $pdo;

// создаёт соединение с  базой

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

// возвращает все записи из базы

    public function getAll($table) {

        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

// возвращает одну запись из базы

    public function getOne($table, $id) {

        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

// вносит данные в базу

    public function insert($table, $data) {

        $keys = implode(',', array_keys($data));
        $tags = ":". implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

// обновляет данные в базе

    public function update($table, $data, $id) {

        $kays = array_keys($data);

        $string = '';

        foreach ($kays as $kay) {
            $string .= $kay . '=:' . $kay . ',';
        }

        $kays = rtrim($string, ',');
        $data['id'] = $id;

        $sql = "UPDATE {$table} SET {$kays} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

// удаляет данные из базы

    public function delete($table, $id) {
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

}