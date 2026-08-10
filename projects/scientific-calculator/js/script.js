// ============================================
// ELEMENTS
// ============================================

const mainDisplay = document.getElementById("mainDisplay");
const expressionDisplay = document.getElementById("expressionDisplay");

const degBtn = document.getElementById("degBtn");
const radBtn = document.getElementById("radBtn");

const historyList = document.getElementById("historyList");
const clearHistoryBtn = document.getElementById("clearHistory");


// ============================================
// VARIABLES
// ============================================

let expression = "";
let lastAnswer = 0;
let angleMode = "DEG";


// ============================================
// UPDATE DISPLAY
// ============================================

function updateDisplay() {

    if (expression === "") {
        mainDisplay.textContent = "0";
    } else {
        mainDisplay.textContent = expression;
    }

}


// ============================================
// CLEAR CALCULATOR
// ============================================

function clearCalculator() {

    // Completely reset calculator
    expression = "";
    lastAnswer = 0;

    // Clear both displays
    mainDisplay.textContent = "0";
    expressionDisplay.textContent = "";

}


// ============================================
// DELETE LAST CHARACTER
// ============================================

function deleteLast() {

    if (expression.length > 0) {

        expression =
            expression.slice(0, -1);

    }

    updateDisplay();

}


// ============================================
// ADD VALUE
// ============================================

function addValue(value) {

    if (value === "PI") {

        expression += Math.PI.toString();

    }

    else if (value === "E") {

        expression += Math.E.toString();

    }

    else {

        expression += value;

    }

    updateDisplay();

}


// ============================================
// FACTORIAL
// ============================================

function factorial(number) {

    if (
        number < 0 ||
        !Number.isInteger(number)
    ) {
        throw new Error("Invalid factorial");
    }

    if (number > 170) {
        throw new Error("Number too large");
    }

    let result = 1;

    for (
        let i = 2;
        i <= number;
        i++
    ) {
        result *= i;
    }

    return result;

}


// ============================================
// DEG / RAD
// ============================================

function toRadians(number) {

    if (angleMode === "DEG") {

        return number * Math.PI / 180;

    }

    return number;

}


// ============================================
// EVALUATE EXPRESSION
// ============================================

function evaluateExpression(input) {

    if (!input) {
        throw new Error("Empty expression");
    }

    let value = input;

    value = value
        .replace(/×/g, "*")
        .replace(/÷/g, "/")
        .replace(/−/g, "-")
        .replace(/\^/g, "**");


    // Percentage

    value = value.replace(
        /(\d+(?:\.\d+)?)%/g,
        "($1/100)"
    );


    // Only allow calculator characters

    if (
        !/^[0-9+\-*/().\s%*]+$/.test(value)
    ) {
        throw new Error("Invalid expression");
    }


    const result =
        Function(
            `"use strict"; return (${value})`
        )();


    if (!Number.isFinite(result)) {
        throw new Error("Invalid result");
    }


    return result;

}


// ============================================
// FORMAT RESULT
// ============================================

function formatResult(number) {

    if (!Number.isFinite(number)) {
        throw new Error("Invalid result");
    }

    return Number(
        number.toPrecision(12)
    ).toString();

}


// ============================================
// SCIENTIFIC FUNCTIONS
// ============================================

function scientificFunction(type) {

    try {

        const value =
            evaluateExpression(expression);

        let result;


        switch (type) {

            case "sin":

                result =
                    Math.sin(
                        toRadians(value)
                    );

                break;


            case "cos":

                result =
                    Math.cos(
                        toRadians(value)
                    );

                break;


            case "tan":

                result =
                    Math.tan(
                        toRadians(value)
                    );

                break;


            case "log":

                result =
                    Math.log10(value);

                break;


            case "ln":

                result =
                    Math.log(value);

                break;


            case "sqrt":

                result =
                    Math.sqrt(value);

                break;


            case "square":

                result =
                    value * value;

                break;


            case "factorial":

                result =
                    factorial(value);

                break;


            default:

                return;

        }


        expressionDisplay.textContent =
            `${type}(${value})`;


        expression =
            formatResult(result);


        updateDisplay();

    }

    catch (error) {

        showError();

    }

}


// ============================================
// POWER
// ============================================

function power() {

    if (expression === "") {
        return;
    }

    expression += "^";

    updateDisplay();

}


// ============================================
// ANSWER
// ============================================

function insertAnswer() {

    expression +=
        formatResult(lastAnswer);

    updateDisplay();

}


// ============================================
// CALCULATE
// ============================================

function calculate() {

    if (expression === "") {
        return;
    }

    try {

        const originalExpression =
            expression;


        const result =
            evaluateExpression(
                expression
            );


        lastAnswer = result;


        expression =
            formatResult(result);


        expressionDisplay.textContent =
            originalExpression;


        updateDisplay();


        addHistory(
            originalExpression,
            expression
        );

    }

    catch (error) {

        showError();

    }

}


// ============================================
// ERROR
// ============================================

function showError() {

    mainDisplay.textContent =
        "Error";


    setTimeout(() => {

        expression = "";

        expressionDisplay.textContent = "";

        mainDisplay.textContent = "0";

    }, 1000);

}


// ============================================
// HISTORY
// ============================================

function addHistory(
    calculation,
    result
) {

    const item =
        document.createElement("div");

    item.className =
        "history-item";


    const expressionSpan =
        document.createElement("span");

    expressionSpan.className =
        "history-expression";

    expressionSpan.textContent =
        calculation;


    const resultSpan =
        document.createElement("span");

    resultSpan.className =
        "history-result";

    resultSpan.textContent =
        result;


    item.appendChild(
        expressionSpan
    );

    item.appendChild(
        resultSpan
    );


    historyList.prepend(item);

}


// ============================================
// NORMAL BUTTONS
// ============================================

document
    .querySelectorAll("[data-value]")
    .forEach(button => {

        button.addEventListener(
            "click",
            function () {

                addValue(
                    this.dataset.value
                );

            }
        );

    });


// ============================================
// ACTION BUTTONS
// ============================================

document
    .querySelectorAll("[data-action]")
    .forEach(button => {

        button.addEventListener(
            "click",
            function () {

                const action =
                    this.dataset.action;


                if (action === "clear") {

                    clearCalculator();

                }

                else if (action === "delete") {

                    deleteLast();

                }

                else if (action === "calculate") {

                    calculate();

                }

                else if (action === "power") {

                    power();

                }

                else if (action === "ans") {

                    insertAnswer();

                }

                else {

                    scientificFunction(action);

                }

            }
        );

    });


// ============================================
// DEGREE MODE
// ============================================

degBtn.addEventListener(
    "click",
    function () {

        angleMode = "DEG";

        degBtn.classList.add("active");

        radBtn.classList.remove("active");

    }
);


// ============================================
// RADIAN MODE
// ============================================

radBtn.addEventListener(
    "click",
    function () {

        angleMode = "RAD";

        radBtn.classList.add("active");

        degBtn.classList.remove("active");

    }
);


// ============================================
// CLEAR HISTORY
// ============================================

clearHistoryBtn.addEventListener(
    "click",
    function () {

        historyList.innerHTML = "";

    }
);


// ============================================
// KEYBOARD SUPPORT
// ============================================

document.addEventListener(
    "keydown",
    function (event) {

        const key = event.key;


        // Numbers

        if (/^[0-9]$/.test(key)) {

            addValue(key);

            return;

        }


        // Operators

        if (
            [
                "+",
                "-",
                "*",
                "/",
                "(",
                ")",
                "."
            ].includes(key)
        ) {

            addValue(key);

            return;

        }


        // Enter

        if (
            key === "Enter" ||
            key === "="
        ) {

            calculate();

            return;

        }


        // Backspace

        if (key === "Backspace") {

            deleteLast();

            return;

        }


        // Escape = AC

        if (key === "Escape") {

            clearCalculator();

        }

    }
);


// ============================================
// INITIAL DISPLAY
// ============================================

clearCalculator();