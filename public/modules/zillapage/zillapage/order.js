// Get all the plus, minus icons, and other elements
const plusIcons = document.getElementsByClassName("plus-box");
const minusIcons = document.getElementsByClassName("minus-box");
const priceElements = document.getElementsByClassName("amount");
const quantityInputs = document.getElementsByClassName("product-quantity");
const subtotalElement = document.querySelector(".subtotal-price");
const totalElement = document.querySelector(".total-price");
const totalPaymentElement = document.querySelector(".total-payment");
const shippingOptions = document.querySelectorAll("input[name='shipping']");

const paymentOptionsCard = document.getElementById("payment-options");
const paymentButton1 = document.querySelector(".payment-button1");
const paymentButton2 = document.querySelector(".payment-button2");

// Function to show payment options and style buttons
function showPaymentOptions(clickedButton) {
    paymentOptionsCard.style.display = "block";

    // Reset styles for both buttons
    paymentButton1.style.backgroundColor = "";
    paymentButton1.style.color = "";
    paymentButton2.style.backgroundColor = "";
    paymentButton2.style.color = "";

    // Apply styles based on which button was clicked
    if (clickedButton === paymentButton1) {
        paymentButton1.style.backgroundColor = "green";
        paymentButton1.style.color = "white";
    } else if (clickedButton === paymentButton2) {
        paymentButton2.style.backgroundColor = "red";
        paymentButton2.style.color = "white";
    }

    setTimeout(() => {
        paymentOptionsCard.classList.add("show");
    }, 10);
}

const paymentButtons = document.querySelectorAll(".pay-btn");
// Add click event listeners for payment buttons
paymentButtons.forEach((button) => {
    button.addEventListener("click", function () {
        // Set the value of the hidden input based on the clicked button's data attribute
        document.getElementById("payment_type").value =
            this.getAttribute("data-payment-type");

        // Check if paymentOptionsCard is defined before using it
        const paymentOptionsCard = document.getElementById("payment-options");
        if (paymentOptionsCard) {
            paymentOptionsCard.style.display = "block";
        }
    });
});

// Add click event listeners for payment buttons
paymentButton1.addEventListener("click", () =>
    showPaymentOptions(paymentButton1)
);
paymentButton2.addEventListener("click", () =>
    showPaymentOptions(paymentButton2)
);

// Initialize total variables
let subtotal = 0;
let shippingCost = 0;

// Function to update the subtotal display
function updateSubtotalDisplay() {
    subtotalElement.textContent = `${subtotal.toFixed(0)}`;
    updateTotalDisplay();
}

// Function to update the total display
function updateTotalDisplay() {
    const total = subtotal + shippingCost;
    totalElement.textContent = `${total.toFixed(0)}`;
    totalPaymentElement.textContent = `${total.toFixed(0)}`;
}

// Function to handle quantity and subtotal updates for plus and minus
function updateSubtotal(index, isAdding) {
    const priceValue = parseFloat(priceElements[index].value);
    let currentQuantity = parseInt(quantityInputs[index].value) || 1;

    if (isAdding) {
        currentQuantity += 1;
    } else {
        currentQuantity = Math.max(1, currentQuantity - 1); // Ensure quantity doesn't go below 1
    }

    quantityInputs[index].value = currentQuantity;
    recalculateSubtotal();
}

// Function to recalculate the entire subtotal
function recalculateSubtotal() {
    subtotal = 0;
    for (let i = 0; i < quantityInputs.length; i++) {
        const qty = parseFloat(quantityInputs[i].value) || 1;
        const price = parseFloat(priceElements[i].value);
        subtotal += qty * price;
    }
    updateSubtotalDisplay();
}

// Add click event to plus icons
for (let i = 0; i < plusIcons.length; i++) {
    plusIcons[i].addEventListener("click", function () {
        updateSubtotal(i, true);
    });
}

// Add click event to minus icons
for (let i = 0; i < minusIcons.length; i++) {
    minusIcons[i].addEventListener("click", function () {
        updateSubtotal(i, false);
    });
}

// Function to handle quantity input changes
function handleQuantityChange(index) {
    const inputValue = quantityInputs[index].value;

    // If the input is not empty and is a number, ensure it's not negative
    if (inputValue !== "") {
        const numValue = parseFloat(inputValue);
        if (numValue <= 0) {
            quantityInputs[index].value = 1;
        }
    }

    recalculateSubtotal();
}

// Add input event listeners for quantity inputs
for (let i = 0; i < quantityInputs.length; i++) {
    quantityInputs[i].addEventListener("input", function () {
        handleQuantityChange(i);
    });
}

// Shipping cost update function
function updateShippingCost() {
    shippingOptions.forEach((option) => {
        if (option.checked) {
            shippingCost = parseFloat(option.value);
        }
    });
    updateTotalDisplay();
}

// Add event listeners for shipping options
shippingOptions.forEach((option) => {
    option.addEventListener("change", updateShippingCost);
});

// Initialize subtotal on page load
function initializeSubtotal() {
    if (shippingOptions.length > 0) {
        // Check the first shipping option by default if none is selected
        let isChecked = false;
        shippingOptions.forEach((option) => {
            if (option.checked) {
                shippingCost = parseFloat(option.value);
                isChecked = true;
            }
        });

        if (!isChecked) {
            shippingOptions[0].checked = true;
            shippingCost = parseFloat(shippingOptions[0].value);
        }
    }

    recalculateSubtotal();
    updateTotalDisplay();
}

// Call the initialize function
initializeSubtotal();
