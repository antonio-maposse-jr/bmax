<div role="tabpanel" class="tab-pane" id="tab_authorisation">
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
                                        {{ optional($authorisation_stage)->id }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Order ID:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($authorisation_stage)->process_id }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Comment:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($authorisation_stage)->comment }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Decision:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($authorisation_stage)->decision }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Comments:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($authorisation_stage)->comments }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Special conditions:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($authorisation_stage)->special_conditions == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Other documents:</strong>
                                </td>
                                <td>
                                    <span>
                                        @if (isset($authorisation_stage->other_documents))
                                            <a href="{{ Storage::url($authorisation_stage->other_documents) }}"
                                                target="_blank">Download/View Other Documents</a>
                                        @else
                                            <p>No documents available</p>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>User processed:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($authorisation_stage)->user ? optional($authorisation_stage)->user->name : '' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Created:</strong>
                                </td>
                                <td>
                                    <span
                                        data-order="{{ optional($authorisation_stage)->created_at }}">
                                        {{ optional($authorisation_stage)->created_at }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Updated:</strong>
                                </td>
                                <td>
                                    <span
                                        data-order=" {{ optional($authorisation_stage)->updated_at }}">
                                        {{ optional($authorisation_stage)->updated_at }}
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