<?php

namespace Spinon\UccelloArchive\Http\Controllers;

use Illuminate\Http\Request;
use Uccello\Core\Models\Domain;
use Uccello\Core\Models\Module;
use Uccello\Core\Http\Controllers\Core\Controller as UccelloController;
use Spinon\UccelloArchive\Scopes\ArchiveScope;

class ArchiveController extends UccelloController
{

    /**
     * Check user permissions
     */
    protected function checkPermissions()
    {
        $this->middleware('uccello.permissions:update');
    }

    /**
     * Archive record
     *
     * @param Domain|null $domain
     * @param Module $module
     * @param Request $request
     * @return void
     */
    public function archive(?Domain $domain, Module $module, Request $request) {
        $this->preProcess($domain, $module, $request);

        $model_class = $module->model_class;
        $record = $model_class::withoutGlobalScope(ArchiveScope::class)->findOrFail($request->id);;

        $archived_column_name = $record->getArchivedAtColumn();
        if ($record->$archived_column_name !== NULL) {
            $record->$archived_column_name = NULL;
        } else {
            $record->$archived_column_name = date('Y-m-d H:i:s');
        }
        $record->save();

        return $record;
    }

}
