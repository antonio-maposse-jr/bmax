{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>

@if (Auth::user()->can('customer_categories_list') || Auth::user()->can('customers_list'))
    <x-backpack::menu-dropdown title="Customer Management" icon="la la-user">
        @can('customers_list')
            <x-backpack::menu-dropdown-item title="Customers" icon="la la-user" :link="backpack_url('customer')" />
        @endcan
        @can('customer_categories_list')
            <x-backpack::menu-dropdown-item title="Customer categories" icon="la la-user-secret" :link="backpack_url('customer-category')" />
        @endcan
    </x-backpack::menu-dropdown>
@endif

@if (Auth::user()->can('processes_list'))
    <x-backpack::menu-dropdown title="Process Management" icon="la la-file-alt">
        <x-backpack::menu-dropdown-header title="Process Workflow" />
        @can('stage_sales_list')
            <x-backpack::menu-dropdown-item title="Sales Stage" icon="la la-money-bill-wave" :link="backpack_url('stage-sales')" />
        @endcan
        @can('stage_cashiers_list')
            <x-backpack::menu-dropdown-item title="Cashiers Stage" icon="la la-cash-register" :link="backpack_url('stage-cashier')" />
        @endcan
        @can('stage_authorisations_list')
            <x-backpack::menu-dropdown-item title="Authorisations Stage" icon="la la-key" :link="backpack_url('stage-authorisations')" />
        @endcan
        @can('stage_productions_list')
            <x-backpack::menu-dropdown-item title="Production Stage" icon="la la-tasks" :link="backpack_url('stage-production')" />
        @endcan
        @can('stage_credit_controls_list')
            <x-backpack::menu-dropdown-item title="Credit Control Stage" icon="la la-eye" :link="backpack_url('stage-credit-control')" />
        @endcan
        @can('stage_dispatches_list')
            <x-backpack::menu-dropdown-item title="Dispatch Stage" icon="la la-rocket" :link="backpack_url('stage-dispatch')" />
        @endcan
        <x-backpack::menu-dropdown-header title="Process States" />
        <x-backpack::menu-dropdown-item title="All Processes" icon="la la-folder" :link="backpack_url('process')" />
        <x-backpack::menu-dropdown-item title="Pending Processes" icon="la la-edit" :link="backpack_url('pendig-process')" />
        <x-backpack::menu-dropdown-item title="Declined Processes" icon="la la-window-close" :link="backpack_url('reason-decline')" />
        <x-backpack::menu-dropdown-item title="Completed Processes" icon="la la-check-circle" :link="backpack_url('completed-process')" />
    </x-backpack::menu-dropdown>
@endif

@if (Auth::user()->can('categories_list') ||
        Auth::user()->can('subcategories_list') ||
        Auth::user()->can('products_list'))
    <x-backpack::menu-dropdown title="Product Management" icon="la la-cart-arrow-down">
        @can('categories_list')
            <x-backpack::menu-dropdown-item title="Categories" icon="la la-folder-plus" :link="backpack_url('category')" />
        @endcan
        @can('subcategories_list')
            <x-backpack::menu-dropdown-item title="Subcategories" icon="la la-file-alt" :link="backpack_url('subcategory')" />
        @endcan
        @can('products_list')
            <x-backpack::menu-dropdown-item title="Products" icon="la la-archive" :link="backpack_url('product')" />
        @endcan
    </x-backpack::menu-dropdown>
@endif

@if (Auth::user()->can('users_list'))
    <x-backpack::menu-dropdown title="User Management" icon="la la-users">
        <x-backpack::menu-dropdown-header title="Authentication" />
        <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
        <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
        <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
    </x-backpack::menu-dropdown>
@endif

<x-backpack::menu-item title="System notifications" icon="la la-envelope-open" :link="backpack_url('system-notification')" />


@if (Auth::user()->can('reports_list'))
    <x-backpack::menu-dropdown title="Reports" icon="la la-chart-pie">
        <x-backpack::menu-dropdown-item title="Regular Reports" icon="la la-business-time" :link="backpack_url('regular_reports')" />
        <x-backpack::menu-dropdown-item title="Sales Reports" icon="la la-file-invoice-dollar" :link="backpack_url('sales_report')" />
    </x-backpack::menu-dropdown>
@endif


@if (Auth::user()->can('activity_log_list'))
    <x-backpack::menu-item title="Activity Logs" icon="la la-stream" :link="backpack_url('activity-log')" />
@endif
@if (Auth::user()->can('logs_list'))
    <x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')" />
@endif
