<div role="tabpanel" class="tab-pane" id="tab_dispatch">
    <div class="row" bp-section="crud-operation-show">
        <div class="col-md-12">
            <div class="">
                <div class="card no-padding no-border mb-0">
                    <table class="table table-striped m-0 p-0">
                        <tbody>
                            <tr>
                                <td class="border-top-0">
                                    <strong>ID:</strong>
                                </td>
                                <td class="border-top-0">
                                    <span>
                                        {{ optional($dispatch_stage)->id }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Process ID:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($dispatch_stage)->process_id }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Comment:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($dispatch_stage)->comment }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Status:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($dispatch_stage)->dispatch_status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Number of Panels:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($dispatch_stage)->nr_panels }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>User processed:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($dispatch_stage)->user ? optional($dispatch_stage)->user->name : '' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Created:</strong>
                                </td>
                                <td>
                                    <span data-order="{{ optional($dispatch_stage)->created_at }}">
                                        {{ optional($dispatch_stage)->created_at }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Updated:</strong>
                                </td>
                                <td>
                                    <span data-order=" {{ optional($dispatch_stage)->updated_at }}">
                                        {{ optional($dispatch_stage)->updated_at }}
                                    </span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>