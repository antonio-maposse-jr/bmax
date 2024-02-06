@if ($crud->hasAccess('viewProcess'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/view-process') }}" class="btn btn-sm btn-link"><i class="la la-tasks"></i> View Details</a>
@endif