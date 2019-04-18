<?php

namespace Spinon\UccelloArchive\Traits;

use Spinon\UccelloArchive\Scopes\ArchiveScope;

trait ArchiveTrait {

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ArchiveScope);
    }

    /**
     * Get the name of the "archived at" column.
     *
     * @return string
     */
    public function getArchivedAtColumn()
    {
        return property_exists($this, 'ARCHIVED_AT') ? static::$ARCHIVED_AT : 'archived_at';
    }

    /**
     * Get the fully qualified "archived at" column.
     *
     * @return string
     */
    public function getQualifiedArchivedAtColumn()
    {
        return $this->qualifyColumn($this->getArchivedAtColumn());
    }

    public static function isArchivable() {
        return true;
    }

}