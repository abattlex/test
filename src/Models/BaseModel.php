<?php

namespace App\Models;

use App\Config;

abstract class BaseModel
{
    const PARAM_NAME    = 'PARAM_NAME';
    const PARAM_TYPE    = 'PARAM_TYPE';
    const PARAM_HANDLER = 'PARAM_HANDLER';

    protected \PDO $connection;
    protected ?string $tableName;
    protected array $fields;
    protected array $saveMap;
    protected array $findMap;

    public function __construct(Config $config)
    {
        $this->connection = new \PDO(
            $config->getDbDSN(),
            $config->getDbUser(),
            $config->getDbPass()
        );
        $this->tableName    = null;
        $this->fields       = [];
        $this->saveMap      = [];
        $this->findMap      = [];
    }

    public function get(string $fieldName)
    {
        return $this->fields[$fieldName] ?? null;
    }

    public function set(string $fieldName, $value)
    {
        $this->fields[$fieldName] = $value;

        return $this;
    }

    public function findOne(array $params = [])
    {
        $sql = $this->getSqlForFindOne();
        $statement = $this->getStatement($this->findMap, $sql, $params);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function save(array $params = [])
    {
        $sql = $this->getSqlForSave();
        $statement = $this->getStatement($this->saveMap, $sql, $params);

        if ($statement->execute()) {
            return $this->findOne($params);
        }
        return false;
    }

    protected function getStatement(array $fieldsMap, string $sql, array $params)
    {
        $statement = $this->connection->prepare($sql);
        foreach ($fieldsMap as $field => $fieldData) {
            $param      = ":$field";
            $value      = $params[$field] ?? $this->get($field);
            $handler    = $fieldData[self::PARAM_HANDLER] ?? null;
            $type       = $fieldData[self::PARAM_TYPE];

            $this->set($field, $value);

            if ($handler) {
                $value = $handler($value);
            }
            $statement->bindValue($param, $value, $type);
        }

        return $statement;
    }

    protected function getSqlForFindOne(): string
    {
        $conditions = array_map(fn ($field) => "$field = :$field", array_keys($this->findMap));

        return sprintf('SELECT * FROM %s WHERE %s', $this->tableName, implode(' AND ', $conditions));
    }

    protected function getSqlForSave(): string
    {
        $fields = array_keys($this->saveMap);
        $params = array_map(fn (string $field) => ":$field", $fields);

        return sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->tableName, implode(', ', $fields), implode(', ', $params));
    }
}
