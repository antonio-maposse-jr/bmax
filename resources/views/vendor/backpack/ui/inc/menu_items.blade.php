{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="User Management" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Customer Management" icon="la la-user">
    <x-backpack::menu-dropdown-item title="Customers" icon="la la-user" :link="backpack_url('customer')" />
    <x-backpack::menu-dropdown-item title="Customer categories" icon="la la-user-secret" :link="backpack_url('customer-category')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Product Management" icon="la la-cart-arrow-down">
    <x-backpack::menu-dropdown-item title="Categories" icon="la la-folder-plus" :link="backpack_url('category')" />
    <x-backpack::menu-dropdown-item title="Subcategories" icon="la la-file-alt" :link="backpack_url('subcategory')" />
    <x-backpack::menu-dropdown-item title="Products" icon="la la-archive" :link="backpack_url('product')" />
    <x-backpack::menu-dropdown-item title="Colors" icon="la la-pen-nib" :link="backpack_url('color')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Process Management" icon="la la-file-alt">
    <x-backpack::menu-dropdown-item title="All Process" icon="la la-folder" :link="backpack_url('process')" />
    <x-backpack::menu-dropdown-item title="Pending Process" icon="la la-edit" :link="backpack_url('pendig-process')" />
    <x-backpack::menu-dropdown-item title="Declined Process" icon="la la-window-close" :link="backpack_url('reason-decline')" />
    <x-backpack::menu-dropdown-item title="Completed Process" icon="la la-check-circle" :link="backpack_url('completed-process')" />
    <x-backpack::menu-dropdown-header title="Process Workflow" />
    <x-backpack::menu-dropdown-item title="Cashiers Stage" icon="la la-cash-register" :link="backpack_url('stage-cashier')" />
    <x-backpack::menu-dropdown-item title="Authorisations Stage" icon="la la-key" :link="backpack_url('stage-authorisations')" />
    <x-backpack::menu-dropdown-item title="Production Stage" icon="la la-tasks" :link="backpack_url('stage-production')" />
    <x-backpack::menu-dropdown-item title="Credit Control Stage" icon="la la-eye" :link="backpack_url('stage-credit-control')" />
    <x-backpack::menu-dropdown-item title="Dispatch Stage" icon="la la-rocket" :link="backpack_url('stage-dispatch')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Reports" icon="la la-chart-pie">
    <x-backpack::menu-dropdown-item title="Regular Reports" icon="la la-business-time" :link="backpack_url('regular_reports')" />
    <x-backpack::menu-dropdown-item title="Sales Reports" icon="la la-file-invoice-dollar" :link="backpack_url('sales_report')" />
</x-backpack::menu-dropdown>
