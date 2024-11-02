<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 22-10-2023
 */

namespace App\Traits;

trait SeederTrait
{
    /**
     * Instances
     *
     * @var array
     */
    private $instances = [];

    /**
     * Set instance
     */
    private function setInstance(string $namespace, string $column): void
    {
        if (! isset($this->instances[$namespace])) {
            $this->instances[$namespace]['index'] = 0;
            $this->instances[$namespace][$column] = $namespace::select($column)->get()->pluck($column)->toArray();
        }
    }

    /**
     * Check index existence
     */
    private function existIndex(string $namespace, array $columns): void
    {
        if (! isset($columns[$this->instances[$namespace]['index']])) {
            $this->instances[$namespace]['index'] = 0;
        }
    }

    /**
     * Get id or other column data
     */
    public function getData(string $namespace, string $column = 'id', bool $random = false): ?int
    {
        if (! class_exists($namespace)) {
            return null;
        }

        $this->setInstance($namespace, $column);

        $columns = $this->instances[$namespace][$column];

        if (empty($columns)) {
            return null;
        }

        if ($random) {
            shuffle($columns);
        }

        $this->existIndex($namespace, $columns);

        return $columns[$this->instances[$namespace]['index']++];
    }
}
