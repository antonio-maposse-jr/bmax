@if ($crud->hasAccess('processCashierStage'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/process-cashier-stage') }}" class="btn btn-sm btn-link"><i class="la la-tasks"></i> Process</a>
@endif