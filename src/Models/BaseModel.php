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
    protected array $fieldsMap;

    public function __construct(Config $config)
    {
        $this->connection = new \PDO(
            $config->getDbDSN(),
            $config->getDbUser(),
            $config->getDbPass()
        );
        $this->tableName = null;
        $this->fields = [];

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

    public function save(array $params = [])
    {
        $sql = $this->getSqlForSave();
        $statement = $this->connection->prepare($sql);
        foreach ($this->fieldsMap as $field => $fieldData) {
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

        return $statement->execute();
    }

    protected function getSqlForSave(): string
    {
        $fields = array_keys($this->fieldsMap);
        $params = array_map(fn (string $field) => ":$field", $fields);
        return sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->tableName, implode(', ', $fields), implode(', ', $params));
    }
}
