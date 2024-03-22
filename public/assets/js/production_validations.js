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

function openPopupDecline() {
    document.getElementById("popup_decline").style.display = "block";
    document.getElementById("overlay_rs").style.display = "block";

}
function closePopupDecline() {
    document.getElementById("popup_decline").style.display = "none";
    document.getElementById("overlay_rs").style.display = "none";
}

function openPopupSheets(button, option) {
    document.getElementById("popup_sheets").style.display = "block";
    document.getElementById("overlay_rs").style.display = "block";

    var taskId = document.getElementById('popup_task_id');
    var taskName = document.getElementById('popup_task_name');
    var subTaskName = document.getElementById('popup_sub_task_name');
    var allocatedSheetsField = document.getElementById('nr_sheets_allocated');
    var initialAllocationSheet = document.getElementById('nr_sheets_unallocated');


    var attributes = button.closest('tr').dataset;
    taskId.value = attributes.task_id;
    taskName.value = attributes.task_name;
    subTaskName.value = attributes.sub_task_name;

    allocatedSheetsField.value = attributes.total_allocated_sheets;
    initialAllocationSheet.value = document.getElementById('initial_unallocated_sheets').value;
    document.getElementById('popup_option').value = option;

    document.getElementById('initial_allocated_sheets_task').value = attributes.total_allocated_sheets;

    if (option == 'edit') {
        document.getElementById('popup_sheet_title').innerHTML= 'Edit Sheet Allocation';
    }else{
        document.getElementById('popup_sheet_title').innerHTML= 'Assign Sheet Allocation';
    }

}


function checkSheetAllocation() {
    var nrSheetsAllocated = parseFloat(document.getElementById('nr_sheets_allocated').value) ?? 0;
    if (isNaN(nrSheetsAllocated)) {
        nrSheetsAllocated = 0;
    }
    var initialUnallocatedSheets = parseFloat(document.getElementById('initial_unallocated_sheets').value);
    var totalNumberSheets = parseFloat(document.getElementById('total_sheets').value);
    var option = document.getElementById('popup_option').value;
    

    var submitBtn = document.getElementById('submit_sheet_task_btn');
    // var totalAllocated = totalNumberSheets - initialUnallocatedSheets;
    var totalUnalocated = 0;

    if (option == 'edit') {
        initial_allocated_sheets_task = parseFloat(document.getElementById('initial_allocated_sheets_task').value);
        totalUnalocated = (initialUnallocatedSheets + initial_allocated_sheets_task) - nrSheetsAllocated;
    }else{
        totalUnalocated = initialUnallocatedSheets - nrSheetsAllocated;
    }
   
    
    document.getElementById('nr_sheets_unallocated').value = totalUnalocated;

   // console.log('nrSheetsAllocated: '+nrSheetsAllocated+' nrSheetsUnallocated: '+nrSheetsUnallocated+' totalUnalocated: '+totalUnalocated)
    if (nrSheetsAllocated > totalNumberSheets || totalUnalocated < 0) {
        submitBtn.disabled = true;
    } else {
        submitBtn.disabled = false;
    }
}


function checkPanelsAllocation() {
    var nrPanelsAllocated = parseFloat(document.getElementById('nr_panels_allocated').value);
    
    if (isNaN(nrPanelsAllocated)) {
        nrPanelsAllocated = 0;
    }

    var totalNumberPanels = parseFloat(document.getElementById('total_panels').value);
    var initialUnallocatedPanels = parseFloat(document.getElementById('initial_unallocated_panels').value);
    var submitBtn = document.getElementById('submit_panel_task');
    var option = document.getElementById('popup_option_panels').value;

    var totalUnalocated = 0;
    

    if (option == 'edit') {
        initial_allocated_panels_task = parseFloat(document.getElementById('initial_allocated_panels_task').value);
        totalUnalocated = (initialUnallocatedPanels + initial_allocated_panels_task) - nrPanelsAllocated;
    }else{
        totalUnalocated = initialUnallocatedPanels - nrPanelsAllocated;
    }
   
    document.getElementById('nr_panels_unallocated').value = totalUnalocated;


    if (nrPanelsAllocated > totalNumberPanels || totalUnalocated < 0) {
        submitBtn.disabled = true;
    } else {
        submitBtn.disabled = false;
    }
}

function openPopupPanels(button, option) {
    document.getElementById("popup_panels").style.display = "block";
    document.getElementById("overlay_rs").style.display = "block";

    var taskId = document.getElementById('panel_task_id');
    var taskName = document.getElementById('panel_task_name');
    var subTaskName = document.getElementById('panel_sub_task_name');

    var allocatedPanelsField = document.getElementById('nr_panels_allocated');
    var initialAllocatedPanels = document.getElementById('nr_panels_unallocated');

    var attributes = button.closest('tr').dataset;
    taskId.value = attributes.task_id;
    taskName.value = attributes.task_name;
    subTaskName.value = attributes.sub_task_name;

    allocatedPanelsField.value = attributes.total_allocated_panels;
    initialAllocatedPanels.value = document.getElementById('initial_unallocated_panels').value;

    document.getElementById('popup_option_panels').value = option;

    document.getElementById('initial_allocated_panels_task').value = attributes.total_allocated_panels;

    if (option == 'edit') {
        document.getElementById('popup_panel_title').innerHTML= 'Edit Panels Allocation';
    }else{
        document.getElementById('popup_panel_title').innerHTML= 'Assign Panels Allocation';
    }
}


    
function closePopupSheets() {
    document.getElementById("popup_sheets").style.display = "none";
    document.getElementById("overlay_rs").style.display = "none";
}

function closePopupPanels() {
    document.getElementById("popup_panels").style.display = "none";
    document.getElementById("overlay_rs").style.display = "none";
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