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

        $filter = request('filter');
        if (isset($filter)) {
            if ($filter == 'archived') {
                $query = $query->withoutGlobalScope(ArchiveScope::class)->whereNotNull('archived_at');
            } else if ($filter == 'unarchived') {
                $query = $query->withoutGlobalScope(ArchiveScope::class)->whereNull('archived_at');
            } else {
                $query = $query->withoutGlobalScope(ArchiveScope::class);
            }
        } else {
            $query = $query->withoutGlobalScope(ArchiveScope::class);
        }

        return $query;
    }

}