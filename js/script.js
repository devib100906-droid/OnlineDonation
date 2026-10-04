// Registration Form Validation

function validateRegistrationForm() {

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let password = document.getElementById("password").value;

    // Check name
    if (name.length < 3) {
        alert("Please enter a valid name.");
        return false;
    }

    // Check email
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Check phone number
    let phonePattern = /^[0-9]{10}$/;

    if (!phonePattern.test(phone)) {
        alert("Please enter a valid 10-digit phone number.");
        return false;
    }

    // Check password
    if (password.length < 6) {
        alert("Password must contain at least 6 characters.");
        return false;
    }

    return true;
}
// Donation Form Validation

function validateDonationForm() {

    let amount = document.getElementById("amount").value;
    let paymentMethod = document.getElementById("payment_method").value;

    // Check donation amount
    if (amount <= 0) {
        alert("Donation amount must be greater than zero.");
        return false;
    }

    // Check payment method
    if (paymentMethod === "") {
        alert("Please select a payment method.");
        return false;
    }

    return true;
}