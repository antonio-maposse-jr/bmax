var table = document.getElementById('taskTable');
var submitButton = document.getElementById('submit_btn');

// Function to check Task Status values and enable/disable Submit button

// Assume Task Status is in the second column (index 1)
var taskStatusColumn = 4;

// Check if all Task Status values are 'completed'
var allCompleted = Array.from(table.rows).slice(1) // Exclude the header row
    .every(function (row) {
        return row.cells[taskStatusColumn].textContent.trim().toLowerCase() === 'completed';
    });

// Enable or disable the Submit button accordingly
submitButton.disabled = !allCompleted;



function openPopupSheets(button) {
    document.getElementById("popup_sheets").style.display = "block";
    document.getElementById("overlay_rs").style.display = "block";

    var taskId = document.getElementById('popup_task_id');
    var taskName = document.getElementById('popup_task_name');
    var subTaskName = document.getElementById('popup_sub_task_name');

    var attributes = button.closest('tr').dataset;
    taskId.value = attributes.task_id;
    taskName.value = attributes.task_name;
    subTaskName.value = attributes.sub_task_name;
}

function openPopupPanels(button) {
    document.getElementById("popup_panels").style.display = "block";
    document.getElementById("overlay_rs").style.display = "block";

    var taskId = document.getElementById('panel_task_id');
    var taskName = document.getElementById('panel_task_name');
    var subTaskName = document.getElementById('panel_sub_task_name');

    var attributes = button.closest('tr').dataset;
    taskId.value = attributes.task_id;
    taskName.value = attributes.task_name;
    subTaskName.value = attributes.sub_task_name;
}



function closePopupSheets() {
    document.getElementById("popup_sheets").style.display = "none";
    document.getElementById("overlay_rs").style.display = "none";
}

function closePopupPanels() {
    document.getElementById("popup_panels").style.display = "none";
    document.getElementById("overlay_rs").style.display = "none";
}

function checkPanelsAllocation() {
    var nrPanelsUnallocated = parseFloat(document.getElementById('nr_panels_unallocated').value);
    var nrPanelsAllocated = parseFloat(document.getElementById('nr_panels_allocated').value);
    var submitBtn = document.getElementById('submit_panel_task_btn');

    if (nrPanelsAllocated > nrPanelsUnallocated) {
        submitBtn.disabled = true;
    } else {
        submitBtn.disabled = false;
    }
}

function checkSheetAllocation() {
    var nrSheetsUnallocated = parseFloat(document.getElementById('nr_sheets_unallocated').value);
    var nrSheetsAllocated = parseFloat(document.getElementById('nr_sheets_allocated').value);
    var submitBtn = document.getElementById('submit_sheet_task_btn');

    if (nrSheetsAllocated > nrSheetsUnallocated) {
        submitBtn.disabled = true;
    } else {
        submitBtn.disabled = false;
    }
}

function openConfirmationPopup(button, taskStatusInput) {
    var overlay = document.getElementById('overlay');
    var popup = document.getElementById('confirmationPopup');
    var popupContent = document.getElementById('popupContent');

    var taskStatus = document.getElementById('confirm_task_status');
    var taskId = document.getElementById('confirm_task_id');
    var taskName = document.getElementById('confirm_task_name');
    var subTaskName = document.getElementById('confirm_sub_task_name');


    var attributes = button.closest('tr').dataset;
    taskId.value = attributes.task_id;
    taskName.value = attributes.task_name;
    subTaskName.value = attributes.sub_task_name;
    taskStatus.value = taskStatusInput;



    //Message
    popupContent.innerHTML = `Are you sure you want update the task status to ${taskStatusInput}?`;

    overlay.style.display = 'block';
    popup.style.display = 'block';
}

function closeConfirmationPopup() {
    var overlay = document.getElementById('overlay');
    var popup = document.getElementById('confirmationPopup');

    overlay.style.display = 'none';
    popup.style.display = 'none';
}