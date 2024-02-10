@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">Generate Regular Reports</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Generate Regular Reports.</p>

        <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
            <small>
                <a href="/admin" class="d-print-none font-sm">
                    <span><i
                            class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }} <span>Back to Home</span></span>
                </a>
            </small>
        </p>

    </section>
@endsection

@section('content')
    <form method="post" action="{{ route('get-users-report') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body row">
                <div class="form-group col-md-6 required">
                    <label>Select Report Type</label>
                    <select name="report_type" id="report_type" class="form-control">
                        <option value="Users">Users</option>
                        <option value="Processes">Processes</option>
                        <option value="Products">Products</option>
                        <option value="Customers">Customers</option>
                    </select>
                </div>
                <div class="form-group col-md-6 required">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="form-group col-md-6 required">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>
        </div>
        <div class="d-none" id="parentLoadedAssets">[]</div>
        <div id="saveActions" class="form-group my-3">
            <input type="hidden" name="_save_action" value="create_new_process">
            <button type="submit" class="btn btn-success">
                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                <span data-value="create_new_process">Generate Report</span>
            </button>
            <div class="btn-group" role="group">
            </div>
            <a href="/admin" class="btn btn-default"><span class="la la-ban"></span>
                &nbsp;Cancel</a>
        </div>
    </form>
@endsection
