<?php

namespace App\Lib\SiteInfo;

use Illuminate\Support\Facades\DB;

class Database
{
    private array $database = [];

    public function getInfo(): array
    {
        $this->database['database_version'] = $this->getVersion();
        $this->database['client_version'] = $this->getClientVersion();
        $this->database['max_allowed_packet'] = $this->getValueFromVariable('max_allowed_packet');
        $this->database['max_connections'] = $this->getValueFromVariable('max_connections');
        $this->database['extension'] = $this->getDatabaseExtension();
        $this->database['database_username'] = $this->getUsername();
        $this->database['database_host'] = $this->getHost();
        $this->database['database_name'] = $this->getName();
        $this->database['database_charset'] = $this->getCharset();
        $this->database['database_collation'] = $this->getCollation();

        return $this->database;
    }

    private function executeQuery(string $query): mixed
    {
        try {
            $result = DB::select($query);

            return $result[0] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getDatabaseExtension(): string
    {
        $extensionQuery = 'SELECT @@VERSION_COMPILE_OS AS extension';
        $result = $this->executeQuery($extensionQuery);

        return $result ? $result->extension : 'Unable to determine database extension';
    }

    private function getClientVersion(): string
    {
        $connection = new \mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));

        if ($connection->connect_error) {
            return 'Unable to connect to the database';
        }

        $clientVersion = $connection->client_info;
        $connection->close();

        return $clientVersion ? $clientVersion : 'Unable to determine client version';
    }

    private function getUsername(): string
    {
        $usernameQuery = 'SELECT CURRENT_USER() AS username';
        $result = $this->executeQuery($usernameQuery);

        return $result ? $result->username : 'Unable to determine database username';
    }

    private function getHost(): string
    {
        $hostQuery = 'SELECT @@hostname AS host';
        $result = $this->executeQuery($hostQuery);

        return $result ? $result->host : 'Unable to determine host';
    }

    private function getName(): string
    {
        $nameQuery = 'SELECT DATABASE() AS name';
        $result = $this->executeQuery($nameQuery);

        return $result ? $result->name : 'Unable to determine database name';
    }

    private function getCharset(): string
    {
        $charsetQuery = 'SELECT @@character_set_database AS charset';
        $result = $this->executeQuery($charsetQuery);

        return $result ? $result->charset : 'Unable to determine database charset';
    }

    private function getCollation(): string
    {
        $collationQuery = 'SELECT @@collation_database AS collation';
        $result = $this->executeQuery($collationQuery);

        return $result ? $result->collation : 'Unable to determine database collation';
    }

    private function getVersion(): string
    {
        $versionQuery = 'select version() as version';
        $result = $this->executeQuery($versionQuery);

        return $result ? $result->version : 'Unable to determine database version';
    }

    private function getDatabaseSize(): string
    {
        $sizeQuery = 'SELECT table_schema "database_name", SUM(data_length + index_length) / 1024 / 1024 "database_size" FROM information_schema.TABLES GROUP BY table_schema';
        $result = $this->executeQuery($sizeQuery);

        return $result ? $result->database_size . ' MB' : 'Unable to determine database size';
    }

    private function getValueFromVariable(string $variableName): string
    {
        $valueQuery = "SHOW VARIABLES WHERE Variable_name='$variableName'";
        $result = $this->executeQuery($valueQuery);

        return $result ? $result->Value : "Unable to determine $variableName";
    }
}
