@if ($crud->hasAccess('processDispatchStage'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/process-dispatch-stage') }}" class="btn btn-sm btn-link"><i class="la la-tasks"></i> Process</a>
@endif