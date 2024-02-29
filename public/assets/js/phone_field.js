const phoneInputField = document.querySelector("#id_phone");
const phoneInput = window.intlTelInput(phoneInputField, {
    initialCountry: "zw",
    preferredCountries: ["zw", "mz", "za", "bw"],
    utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
});

phoneInputField.addEventListener("input", function() {
    var formattedNumber = phoneInput.getNumber();
    phoneInputField.value = formattedNumber;
});