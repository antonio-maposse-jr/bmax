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
    <x-backpack::menu-dropdown-item title="Customer categories" icon="la la-question" :link="backpack_url('customer-category')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Product Management" icon="la la-box">
    <x-backpack::menu-dropdown-item title="Categories" icon="la la-folder-plus" :link="backpack_url('category')" />
    <x-backpack::menu-dropdown-item title="Subcategories" icon="la la-file-alt" :link="backpack_url('subcategory')" />
    <x-backpack::menu-dropdown-item title="Products" icon="la la-archive" :link="backpack_url('product')" />
</x-backpack::menu-dropdown>


<!-- <x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
<x-backpack::menu-item title="Subcategories" icon="la la-question" :link="backpack_url('subcategory')" />
<x-backpack::menu-item title="Products" icon="la la-question" :link="backpack_url('product')" /> -->

<x-backpack::menu-item title="Processes" icon="la la-question" :link="backpack_url('process')" />
<x-backpack::menu-item title="Stage cashiers" icon="la la-question" :link="backpack_url('stage-cashier')" />
<x-backpack::menu-item title="Stage authorisations" icon="la la-question" :link="backpack_url('stage-authorisations')" />