@if ($crud->hasAccess('processAuthorizationStage'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/process-authorization-stage') }}" class="btn btn-sm btn-link"><i class="la la-tasks"></i> Process</a>
@endif