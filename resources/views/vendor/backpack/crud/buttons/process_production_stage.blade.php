@if ($crud->hasAccess('processProductionStage'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/process-production-stage') }}" class="btn btn-sm btn-link"><i class="la la-tasks"></i> Process</a>
@endif