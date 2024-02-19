<div role="tabpanel" class="tab-pane" id="tab_cashier">
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
                                        {{ optional($cashier_stage)->id }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Order ID:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->process_id }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Invoice reference:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->invoice_reference }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Invoice amount:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->invoice_amount }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Variance explanation:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->variance_explanation }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Reciept reference:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->reciept_reference }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Total amount paid:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->total_amount_paid }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Invoice status:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->invoice_status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Balance to be paid:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->balance_to_be_paid }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Special authorization:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->special_authorization == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Special instructions:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ optional($cashier_stage)->special_instructions }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Invoice:</strong>
                                </td>
                                <td>
                                    <span>
                                        <span>
                                            @if (isset($cashier_stage->invoice))
                                                <a href="{{ Storage::url($cashier_stage->invoice) }}"
                                                    target="_blank">Download/View Other Invoice</a>
                                            @else
                                                <p>No documents available</p>
                                            @endif
                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Receipt:</strong>
                                </td>
                                <td>
                                    <span>
                                        @if (isset($cashier_stage->receipt))
                                            <a href="{{ Storage::url($cashier_stage->receipt) }}"
                                                target="_blank">Download/View Other Receipt</a>
                                        @else
                                            <p>No documents available</p>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Other Documents:</strong>
                                </td>
                                <td>
                                    <span>
                                        @if (isset($cashier_stage->other))
                                            <a href="{{ Storage::url($cashier_stage->other) }}"
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
                                        {{ optional($cashier_stage)->user ? optional($cashier_stage)->user->name : '' }}
                                    </span>
                                </td>
                            </tr>
                            <td>
                                <strong>Created:</strong>
                            </td>
                            <td>
                                <span data-order="{{ optional($cashier_stage)->created_at }}">
                                    {{ optional($cashier_stage)->created_at }}
                                </span>
                            </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Updated:</strong>
                                </td>
                                <td>
                                    <span data-order=" {{ optional($cashier_stage)->updated_at }}">
                                        {{ optional($cashier_stage)->updated_at }}
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