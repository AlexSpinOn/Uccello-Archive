<?php
namespace Spinon\UccelloArchive\Http\Controllers;

use Schema;
use DB;

use Uccello\Core\Http\Controllers\Core\ListController as UccelloListController;
use Uccello\Core\Models\Module;
use Uccello\Core\Models\Domain;
use Illuminate\Http\Request;
use Spinon\UccelloArchive\Scopes\ArchiveScope;
use Uccello\Core\Facades\Uccello;
use Uccello\Core\Models\Relatedlist;
use Uccello\Core\Models\Filter;

class ListController extends UccelloListController {

    /**
     * Override query build to select archived records if needed
     *
     * @return \Illuminate\Database\Eloquent\Builder;
     */
    protected function buildContentQuery()
    {
        $query = parent::buildContentQuery();

        $module = $this->module;
        $modelClass = $module->model_class;

        $filter = request('filter');
        if (isset($filter) && (new $modelClass)->isArchivable()) {
            if ($filter == 'archived') {
                $query = $query->withoutGlobalScope(ArchiveScope::class)->whereNotNull((new $modelClass)->getArchivedAtColumn());
            } else if ($filter == 'unarchived') {
                $query = $query->withoutGlobalScope(ArchiveScope::class)->whereNull((new $modelClass)->getArchivedAtColumn());
            } else {
                $query = $query->withoutGlobalScope(ArchiveScope::class);
            }
        } else {
            $query = $query->withoutGlobalScope(ArchiveScope::class);
        }

        return $query;
    }

}