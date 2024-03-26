@if ($crud->hasAccess('sales'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/sales') }}" class="btn btn-sm btn-link"><i class="la la-tasks"></i> Process</a>
@endif