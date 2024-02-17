<div role="tabpanel" class="tab-pane" id="tab_production">
    <div class="card">
        <div class="card-body row">
            <table id="taskTable">
                <tr>
                    <th>Task</th>
                    <th>Sheets Alocated</th>
                    <th>Panels Alocated</th>
                    <th>Total Work (Min)</th>
                    <th>Total Iddle Time (Min)</th>
                    <th>Task Status</th>
                </tr>
                @foreach ($production_tasks as $task)
                    <tr data-task_id="{{ $task->id }}" data-task_name="{{ $task->task_name }}"
                        data-sub_task_name="{{ $task->sub_task_name }}">
                        <td>{{ $task->sub_task_name }}</td>
                        <td>{{ $task->total_allocated_sheets }}</td>
                        <td>{{ $task->total_allocated_panels }}</td>
                        <td>{{ $task->total_work_time }}</td>
                        <td>{{ $task->total_iddle_time }}</td>
                        <td>{{ $task->task_status }}</td>
                    </tr>
                @endforeach

            </table>
            <hr>
            <span>
                @if (isset($production_stage->other))
                    <a href="{{ Storage::url($production_stage->other) }}"
                        target="_blank">Download/View Other Documents</a>
                @else
                    <p>No documents available</p>
                @endif
            </span>

        </div>

    </div>

</div>