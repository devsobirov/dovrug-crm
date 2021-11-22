<?php

namespace App\Traits;


/**
 * Adds Support of Eloquent methods to Models with Composite Primary Key (CPK)
 * 
 */
trait HasCompositePrimaryKeys {

    protected function getKeyForSaveQuery()
    {

        $primaryKeyForSaveQuery = array(count($this->primaryKey));

        foreach ($this->primaryKey as $i => $pKey) {
            $primaryKeyForSaveQuery[$i] = isset($this->original[$this->getKeyName()[$i]])
                ? $this->original[$this->getKeyName()[$i]]
                : $this->getAttribute($this->getKeyName()[$i]);
        }

        return $primaryKeyForSaveQuery;

    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {

        foreach ($this->primaryKey as $i => $pKey) {
            $query->where($this->getKeyName()[$i], '=', $this->getKeyForSaveQuery()[$i]);
        }

        return $query;
    }

    public function getCasts()
    {
        $keyNames = [];
        if ($this->getIncrementing()) {
            foreach ($this->primaryKey as $i => $pKey) {
                if ($this->getKeyName()[$i] !== 'material_id' && $this->getKeyName()[$i] !== 'depository_id') {
                    $keyNames[$this->getKeyName()[$i] ] = $this->getKeyType()[$i];
                }
            }
            return array_merge($keyNames, $this->casts);

        }
        return $this->casts;

    }
}