@if ($crud->hasAccess('notifications'))
  <a href="{{ url($crud->route.'/'.$entry->getKey().'/notifications') }}" class="btn btn-sm btn-link"><i class="la la-bell"></i> Notifications</a>
@endif