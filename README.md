# Uccello-Archive package

**Installation**

```bash
composer require spinon/uccello-archive
```

```bash
php artisan vendor:publish --provider="Spinon\\UccelloArchive\\Providers\\AppServiceProvider"
```



Once installation is done, you need to create a new listing view to override Uccello's. Put the code below into resources/views/uccello/modules/default/list/main.blade.php :

```php+HTML
@extends('uccello::modules.default.list.main')

@section('script')
    {{-- Put your global JS files here --}}

    {{-- Uncomment below to load js/app.js with Mix --}}
    {{-- {!! Html::script(mix('js/app.js')) !!} --}}

    {!! Html::script(mix('js/autoloader.js', 'vendor/spinon/uccello-archive')) !!}
@endsection

<?php $is_archivable = (method_exists($module->model_class, "isArchivable") && ($module->model_class)::isArchivable() === true); ?>

{{-- Row template used by the query --}}
@section('datatable-row-template')
<tr class="template hide" data-row-url="{{ ucroute('uccello.detail', $domain, $module, ['id' => 'RECORD_ID']) }}">
    <td class="select-column hide-on-small-only">&nbsp;</td>

    @foreach ($datatableColumns as $column)
    <td data-field="{{ $column['name'] }}">&nbsp;</td>
    @endforeach

    <td class="actions-column hide-on-small-only hide-on-med-only right-align">
        {{-- Listing view override --}}
        @if (Auth::user()->canUpdate($domain, $module) && $is_archivable)
        <a href="{{ ucroute('uccello.archive', $domain, $module, ['id' => 'RECORD_ID']) }}" data-tooltip="{{ trans('uccello-archive::archive.button.archive') }}" data-unarchive-label="{{ trans('uccello-archive::archive.button.unarchive') }}" data-position="top" class="archive-btn primary-text"><i class="material-icons">archive</i></a>
        @endif

        @if (Auth::user()->canUpdate($domain, $module))
        <a href="{{ ucroute('uccello.edit', $domain, $module, ['id' => 'RECORD_ID']) }}" data-tooltip="{{ uctrans('button.edit', $module) }}" data-position="top" class="edit-btn primary-text"><i class="material-icons">edit</i></a>
        @endif

        @if (Auth::user()->canDelete($domain, $module))
        <a href="{{ ucroute('uccello.delete', $domain, $module, ['id' => 'RECORD_ID']) }}" data-tooltip="{{ uctrans('button.delete', $module) }}" data-position="top" class="delete-btn primary-text" data-config='{"actionType":"link","confirm":true,"dialog":{"title":"{{ uctrans('confirm.button.delete_record', $module) }}"}}'><i class="material-icons">delete</i></a>
        @endif
    </td>
</tr>
@endsection

@section('before-columns-visibility-button')
    @if ($is_archivable)
    <!-- Dropdown Trigger -->
    <a class='dropdown-trigger btn-small primary' href='#' data-target='archive-dropdown' data-constrain-width="false" data-alignment="right">
            <span>{{ trans('uccello-archive::archive.button.display') }}</span>
        <i class="material-icons hide-on-med-and-down right">arrow_drop_down</i>
    </a>

    <!-- Dropdown Structure -->
    <ul id='archive-dropdown' class='dropdown-content' data-table="datatable">
        <li><a href="javascript:void(0);" data-archive-filter="both">{{ trans('uccello-archive::archive.button.all_records') }}</a></li>
        <li class="active"><a href="javascript:void(0);" data-archive-filter="unarchived">{{ trans('uccello-archive::archive.button.unarchived_records') }}</a></li>
        <li><a href="javascript:void(0);" data-archive-filter="archived">{{ trans('uccello-archive::archive.button.archived_records') }}</a></li>
    </ul>
    @endif
@endsection
```



Then, to use the ArchiveTrait, you need to add these lines to the corresponding Models :

```
use Spinon\UccelloArchive\Traits\ArchiveTrait;

class MyModel extends Model
{
  use ArchiveTrait;
  ...
}
```

