<?php

namespace App;

use App\Exceptions\NoConfig;

class Config
{
    protected array $params;

    public function __construct()
    {
        $configFile = BASE_DIR . DIRECTORY_SEPARATOR . '.env';
        $params = parse_ini_file($configFile);
        if (!$params) {
            throw new NoConfig($configFile);
        }
        $this->params = $params;
    }

    public function getDbDSN(): ?string
    {
        return sprintf('%s:host=%s;dbname=%s',
            $this->params['DB_DRIVER'] ?? null,
            $this->params['DB_HOST'] ?? null,
            $this->params['DB_NAME'] ?? null
        );
    }

    public function getDbUser(): ?string
    {
        return $this->params['DB_USER'] ?? null;
    }

    public function getDbPass(): ?string
    {
        return $this->params['DB_PASS'] ?? null;
    }
}
