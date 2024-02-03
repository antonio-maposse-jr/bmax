@if ($crud->hasAccess('processCreditControlStage'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/process-credit-control-stage') }}" class="btn btn-sm btn-link"><i class="la la-tasks"></i> Process</a>
@endif