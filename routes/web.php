<?php

Route::name('uccello.')->namespace('\Spinon\UccelloArchive\Http\Controllers')->middleware('web', 'auth')->group(function() {
    // Adapt params if we use or not multi domains
    if (!uccello()->useMultiDomains()) {
        $domainParam = '';
        $domainAndModuleParams = '{module}';
    } else {
        $domainParam = '{domain}';
        $domainAndModuleParams = '{domain}/{module}';
    }
    Route::get($domainAndModuleParams.'/archive', 'ArchiveController@archive')->name('archive');

    Route::post($domainAndModuleParams.'/list/content/archive', 'ListController@processForContent')->name('list.content.archive');
});
