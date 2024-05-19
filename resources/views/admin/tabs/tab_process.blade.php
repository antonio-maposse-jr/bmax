<div role="tabpanel" class="tab-pane active show" id="tab_process">
    <div class="row" bp-section="crud-operation-show">
        <div class="col-md-12">
            <div class="">
                <div class="card no-padding no-border mb-0">
                    <table class="table table-striped m-0 p-0">
                        <tbody>
                            <tr>
                                <td class="border-top-0">
                                    <strong>Customer :</strong>
                                </td>
                                <td class="border-top-0">
                                    <span>
                                       <b> {{ $entry->customer->name }}</b>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-top-0">
                                    <strong>Nr sheets:</strong>
                                </td>
                                <td class="border-top-0">
                                    <span>
                                        {{ $entry->nr_sheets }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Nr panels:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->nr_panels }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Order value:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ number_format($entry->order_value, 2) }}$
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Estimated process time:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->estimated_process_time }} hours
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Date required:</strong>
                                </td>
                                <td>
                                    <span data-order="2024-01-12">
                                        {{ $entry->date_required }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Priority level:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->priority_level }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Job reference:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->job_reference }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Order confirmation:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->order_confirmation }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Key Products:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->products->pluck('product.name')->implode(', ') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Status:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Stage Id:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->stage_id }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>CurrentStage Name:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->stage_name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Job layout:</strong>
                                </td>
                                <td>
                                    <span>
                                        @if (isset($entry->job_layout))
                                            <a href="{{ Storage::url($entry->job_layout) }}"
                                                target="_blank">Download/View Job Layout</a>
                                        @else
                                            <p>No documents available</p>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Cutting list:</strong>
                                </td>
                                <td>
                                    <span>
                                        <span>
                                            @if (isset($entry->cutting_list))
                                                <a href="{{ Storage::url($entry->cutting_list) }}"
                                                    target="_blank">Download/View Cutting list</a>
                                            @else
                                                <p>No documents available</p>
                                            @endif
                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Quote:</strong>
                                </td>
                                <td>
                                    <span>
                                        <span>
                                            @if (isset($entry->quote))
                                                <a href="{{ Storage::url($entry->quote) }}"
                                                    target="_blank">Download/View Quote</a>
                                            @else
                                                <p>No documents available</p>
                                            @endif

                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Confirmation call record:</strong>
                                </td>
                                <td>
                                    <span>
                                        <span>
                                            @if (isset($entry->confirmation_call_record))
                                                <a href="{{ Storage::url($entry->confirmation_call_record) }}"
                                                    target="_blank">Download/View Confirmation call
                                                    record</a>
                                            @else
                                                <p>No documents available</p>
                                            @endif
                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Signed confirmation:</strong>
                                </td>
                                <td>
                                    <span>
                                        @if (isset($entry->signed_confirmation))
                                            <a href="{{ Storage::url($entry->signed_confirmation) }}"
                                                target="_blank">Download/View Signed confirmation</a>
                                        @else
                                            <p>No documents available</p>
                                        @endif

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Custom cutting list:</strong>
                                </td>
                                <td>
                                    <span>
                                        @if (isset($entry->custom_cutting_list))
                                            <a href="{{ Storage::url($entry->custom_cutting_list) }}"
                                                target="_blank">Download/View Custom cutting list</a>
                                        @else
                                            <p>No documents available</p>
                                        @endif

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Other document:</strong>
                                </td>
                                <td>
                                    <span>
                                        @if (isset($entry->other_document))
                                            <a href="{{ Storage::url($entry->other_document) }}"
                                                target="_blank">Download/View Other document</a>
                                        @else
                                            <p>No documents available</p>
                                        @endif

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Cutting:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->cutting == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Edging:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->edging == 1 ? 'Yes' : 'No' }}

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Cnc machining:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->cnc_machining == 1 ? 'Yes' : 'No' }}

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Grooving:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->grooving == 1 ? 'Yes' : 'No' }}

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Hinge boring:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->hinge_boring == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Wrapping:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->wrapping == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Sanding:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->sanding == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Hardware:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->hardware == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>User Submited:</strong>
                                </td>
                                <td>
                                    <span>
                                        {{ $entry->user->name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Created:</strong>
                                </td>
                                <td>
                                    <span data-order="{{ $entry->created_at }}">
                                        {{ $entry->created_at }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Updated:</strong>
                                </td>
                                <td>
                                    <span data-order=" {{ $entry->updated_at }}">
                                        {{ $entry->updated_at }}
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