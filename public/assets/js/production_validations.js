var table = document.getElementById('taskTable');
var submitButton = document.getElementById('submit_btn');

// Function to check Task Status values and enable/disable Submit button

// Assume Task Status is in the second column (index 1)
var taskStatusColumn = 5;

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
    var allocatedSheetsField = document.getElementById('nr_sheets_allocated');
    var initialAllocationSheet = document.getElementById('initial_allocation_sheets');

    var attributes = button.closest('tr').dataset;
    taskId.value = attributes.task_id;
    taskName.value = attributes.task_name;
    subTaskName.value = attributes.sub_task_name;

    allocatedSheetsField.value = attributes.total_allocated_sheets;
    initialAllocationSheet.value = attributes.total_allocated_sheets;

}

function openPopupPanels(button) {
    document.getElementById("popup_panels").style.display = "block";
    document.getElementById("overlay_rs").style.display = "block";

    var taskId = document.getElementById('panel_task_id');
    var taskName = document.getElementById('panel_task_name');
    var subTaskName = document.getElementById('panel_sub_task_name');

    var allocatedPanelsField = document.getElementById('nr_panels_allocated');
    var initialAllocationPanels = document.getElementById('initial_allocation_panels');

    var attributes = button.closest('tr').dataset;
    taskId.value = attributes.task_id;
    taskName.value = attributes.task_name;
    subTaskName.value = attributes.sub_task_name;

    allocatedPanelsField.value = attributes.total_allocated_panels;
    initialAllocationPanels.value = attributes.total_allocated_panels;
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
    
    if (isNaN(nrPanelsAllocated)) {
        nrPanelsAllocated = 0;
    }
    var totalUnallocatedPanels = parseFloat(document.getElementById('popup_unallocated_panels').value);
    var initialAllocatedPanels = parseFloat(document.getElementById('initial_allocation_panels').value);
    
    var submitBtn = document.getElementById('submit_panel_task_btn');

    var totalUnalocated = ((totalUnallocatedPanels + initialAllocatedPanels) - nrPanelsAllocated)
    
    document.getElementById('nr_panels_unallocated').value = totalUnalocated;

    if (nrPanelsAllocated > nrPanelsUnallocated) {
        submitBtn.disabled = true;
    } else {
        submitBtn.disabled = false;
    }
}

function checkSheetAllocation() {
    var nrSheetsUnallocated = parseFloat(document.getElementById('nr_sheets_unallocated').value);
    var nrSheetsAllocated = parseFloat(document.getElementById('nr_sheets_allocated').value) ?? 0;
    if (isNaN(nrSheetsAllocated)) {
        nrSheetsAllocated = 0;
    }
    var totalUnallocatedSheets = parseFloat(document.getElementById('popup_unallocated_sheets').value);
    var initialAllocatedSheets = parseFloat(document.getElementById('initial_allocation_sheets').value);
    

    var submitBtn = document.getElementById('submit_sheet_task_btn');

    var totalUnalocated = ((totalUnallocatedSheets + initialAllocatedSheets) - nrSheetsAllocated)
    
    document.getElementById('nr_sheets_unallocated').value = totalUnalocated;

    
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