function specialAuthorizationTogleCashier() {
    // Get the checkbox and the field
    var checkbox = document.getElementById('special_authorization');
    var otherField = document.getElementById('special_instructions');
    var submit_btn = document.getElementById('submit_btn');

    // Enable or disable the field based on the checkbox status
    otherField.disabled = !checkbox.checked;
    submit_btn.disabled = checkbox.checked
    if (!checkbox.checked) {
        otherField.value = ''
    }
}

function controlInputData() {

    var otherField = document.getElementById('special_instructions');
    var submit_btn = document.getElementById('submit_btn');

    submit_btn.disabled = !otherField.value.trim() === ''
}


function validateAmount() {
    var invoiceAmount = parseFloat(document.getElementById("invoice_amount").value);
    var quoteAmount = parseFloat(document.getElementById("quote_amount").value);
    var varianceExplanationField = document.getElementById("variance_explanation");
    var submitBtn = document.getElementById("submit_btn");

    if (invoiceAmount < quoteAmount) {
        // Enable the variance explanation field
        varianceExplanationField.disabled = false;

        // Check if variance explanation is inserted
        if (varianceExplanationField.value.trim() !== "") {
            // Enable the submit button
            submitBtn.disabled = false;
        } else {
            // Disable the submit button if variance explanation is not inserted
            submitBtn.disabled = true;
        }
    } else {
        // If invoice amount is not less than quote amount, disable both fields
        varianceExplanationField.disabled = true;
        submitBtn.disabled = false;
    }
}

function validateAmountPaid() {
    var invoiceAmount = parseFloat(document.getElementById("invoice_amount").value);
    var totalAmountPaid = parseFloat(document.getElementById("total_amount_paid").value);
    var statusField = document.getElementById("invoice_status");
    var balanceToBePaid = document.getElementById("balance_to_be_paid");

    if (totalAmountPaid > invoiceAmount) {
        statusField.value = "Excess amount Advance Payment";
    } else if (totalAmountPaid === invoiceAmount) {
        statusField.value = "PAID";
    } else if (totalAmountPaid < invoiceAmount && totalAmountPaid!==0) {
        statusField.value = "PARTIALLY PAID";
    } else {
        statusField.value = "UNPAID";
    }

    if(totalAmountPaid>0){
        var recieptRefGroup= document.getElementById('reciept_ref_group');
        recieptRefGroup.classList.add('required');
    }else{
        var recieptRefGroup= document.getElementById('reciept_ref_group');
        recieptRefGroup.classList.remove('required');
    }
    balanceToBePaid.value = invoiceAmount - totalAmountPaid;
}

function specialConditionsAuthorization(){
    var decision = document.getElementById("decision");
    var specialCondition = document.getElementById("auth_special_conditions");
    var submitBtn = document.getElementById("submit_btn");

    if(decision.value == "APPROVED WITH CONDITIONS"){
        specialCondition.disabled =false
        submitBtn.disabled = true

    }else{
        specialCondition.disabled =true
        specialCondition.value = ""
        submitBtn.disabled = false
    }
}


function controlInputDataAuth() {

    var otherField = document.getElementById('auth_special_conditions');
    var submit_btn = document.getElementById('submit_btn');

    submit_btn.disabled = !otherField.value.trim() === ''
}

function decisionCreditControl(){
    var decision = document.getElementById("decision_cc");
    var specialCondition = document.getElementById("list_special_conditions");
    var submitBtn = document.getElementById("submit_btn");

    if(decision.value == "APPROVED WITH CONDITIONS"){
        specialCondition.disabled =false
        submitBtn.disabled = true

    }else{
        specialCondition.disabled =true
        specialCondition.value = ""
        submitBtn.disabled = false
    }
}

function controlInputDataCreditControl() {

    var otherField = document.getElementById('list_special_conditions');
    var submit_btn = document.getElementById('submit_btn');

    submit_btn.disabled = !otherField.value.trim() === ''
}

function partialDispatch(){
    var dispatchStatus = document.getElementById("dispatch_status");
    var nrPanels = document.getElementById("nr_panels");
    var submitBtn = document.getElementById("submit_btn");

    if(dispatchStatus.value == "Partial Dispatch"){
        nrPanels.disabled =false
        submitBtn.disabled = true

    }else{
        nrPanels.disabled =true
        nrPanels.value = ""
        submitBtn.disabled = false
    }
}

function controlInputDataDispatch() {

    var otherField = document.getElementById('dispatch_status');
    var submit_btn = document.getElementById('submit_btn');

    submit_btn.disabled = !otherField.value.trim() === ''
}