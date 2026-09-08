/* =========================================
   SCIENTIFIC CALCULATOR
========================================= */

const expressionDisplay =
    document.getElementById("expression");

const resultDisplay =
    document.getElementById("result");

const modeLabel =
    document.getElementById("modeLabel");

const memoryLabel =
    document.getElementById("memoryLabel");

const degBtn =
    document.getElementById("degBtn");

const radBtn =
    document.getElementById("radBtn");

const historyBtn =
    document.getElementById("historyBtn");

const historyPanel =
    document.getElementById("historyPanel");

const closeHistory =
    document.getElementById("closeHistory");

const historyList =
    document.getElementById("historyList");

const clearHistoryBtn =
    document.getElementById("clearHistory");


/* =========================================
   STATE
========================================= */

let expression = "";

let lastAnswer = 0;

let angleMode = "DEG";

let history =
    JSON.parse(
        localStorage.getItem("scientificCalculatorHistory")
    ) || [];


/* =========================================
   DISPLAY
========================================= */

function updateDisplay() {

    expressionDisplay.textContent =
        expression || "0";

    memoryLabel.textContent =
        `Ans: ${formatResult(lastAnswer)}`;

    modeLabel.textContent =
        angleMode;
}


/* =========================================
   RESULT FORMAT
========================================= */

function formatResult(value) {

    if (typeof value !== "number") {
        return value;
    }

    if (!Number.isFinite(value)) {
        return "Error";
    }

    if (Math.abs(value) < 1e-12) {
        value = 0;
    }

    return Number(
        value.toPrecision(12)
    ).toString();
}


/* =========================================
   DEG / RAD
========================================= */

function toRadians(value) {

    if (angleMode === "DEG") {
        return value * Math.PI / 180;
    }

    return value;
}


function fromRadians(value) {

    if (angleMode === "DEG") {
        return value * 180 / Math.PI;
    }

    return value;
}


function setAngleMode(mode) {

    angleMode = mode;

    if (mode === "DEG") {

        degBtn.classList.add("active");
        radBtn.classList.remove("active");

    } else {

        radBtn.classList.add("active");
        degBtn.classList.remove("active");
    }

    updateDisplay();
}


degBtn.addEventListener(
    "click",
    () => setAngleMode("DEG")
);

radBtn.addEventListener(
    "click",
    () => setAngleMode("RAD")
);


/* =========================================
   FACTORIAL
========================================= */

function factorial(n) {

    if (!Number.isFinite(n)) {
        throw new Error("Invalid number");
    }

    if (n < 0) {
        throw new Error(
            "Factorial requires a positive number"
        );
    }

    if (!Number.isInteger(n)) {
        throw new Error(
            "Factorial requires an integer"
        );
    }

    if (n > 170) {
        throw new Error(
            "Number too large"
        );
    }

    let result = 1;

    for (let i = 2; i <= n; i++) {
        result *= i;
    }

    return result;
}


/* =========================================
   SAFE MATH FUNCTIONS
========================================= */

const mathFunctions = {

    sin: value =>
        Math.sin(toRadians(value)),

    cos: value =>
        Math.cos(toRadians(value)),

    tan: value =>
        Math.tan(toRadians(value)),

    asin: value =>
        fromRadians(Math.asin(value)),

    acos: value =>
        fromRadians(Math.acos(value)),

    atan: value =>
        fromRadians(Math.atan(value)),

    sinh: value =>
        Math.sinh(value),

    cosh: value =>
        Math.cosh(value),

    tanh: value =>
        Math.tanh(value),

    log: value =>
        Math.log10(value),

    ln: value =>
        Math.log(value),

    sqrt: value =>
        Math.sqrt(value),

    cbrt: value =>
        Math.cbrt(value),

    abs: value =>
        Math.abs(value),

    exp: value =>
        Math.exp(value)
};


/* =========================================
   GET LAST NUMBER
========================================= */

function getLastNumber() {

    const match =
        expression.match(
            /(-?\d*\.?\d+(?:e[+-]?\d+)?)$/i
        );

    if (!match) {
        return null;
    }

    return match[0];
}


/* =========================================
   REPLACE LAST NUMBER
========================================= */

function replaceLastNumber(value) {

    const match =
        expression.match(
            /(-?\d*\.?\d+(?:e[+-]?\d+)?)$/i
        );

    if (!match) {
        expression += value;
        return;
    }

    expression =
        expression.slice(
            0,
            match.index
        ) + value;
}


/* =========================================
   ADD VALUE
========================================= */

function addValue(value) {

    expression += value;

    updateDisplay();
}


/* =========================================
   DELETE
========================================= */

function deleteLast() {

    expression =
        expression.slice(0, -1);

    updateDisplay();
}


/* =========================================
   CLEAR
========================================= */

function clearCalculator() {

    expression = "";

    resultDisplay.textContent = "0";

    updateDisplay();
}


/* =========================================
   PREPARE EXPRESSION
========================================= */

function prepareExpression(input) {

    let exp = input;

    /* Multiplication symbol */

    exp =
        exp.replace(/×/g, "*");

    /* Division symbol */

    exp =
        exp.replace(/÷/g, "/");

    /* Power */

    exp =
        exp.replace(/\^/g, "**");

    /* Percentage */

    exp =
        exp.replace(
            /(\d+(?:\.\d+)?)%/g,
            "($1/100)"
        );

    return exp;
}


/* =========================================
   CALCULATE EXPRESSION
========================================= */

function calculateExpression(input) {

    let exp =
        prepareExpression(input);

    if (!exp.trim()) {
        return 0;
    }


    /*
        Replace Ans with the previous result.
    */

    exp =
        exp.replace(
            /\bAns\b/g,
            `(${lastAnswer})`
        );


    /*
        Convert constants.
    */

    exp =
        exp.replace(
            /\bπ\b/g,
            "Math.PI"
        );

    exp =
        exp.replace(
            /\be\b/g,
            "Math.E"
        );


    /*
        Convert scientific functions.
    */

    exp =
        exp.replace(
            /sin\(/g,
            "mathFunctions.sin("
        );

    exp =
        exp.replace(
            /cos\(/g,
            "mathFunctions.cos("
        );

    exp =
        exp.replace(
            /tan\(/g,
            "mathFunctions.tan("
        );

    exp =
        exp.replace(
            /asin\(/g,
            "mathFunctions.asin("
        );

    exp =
        exp.replace(
            /acos\(/g,
            "mathFunctions.acos("
        );

    exp =
        exp.replace(
            /atan\(/g,
            "mathFunctions.atan("
        );

    exp =
        exp.replace(
            /sinh\(/g,
            "mathFunctions.sinh("
        );

    exp =
        exp.replace(
            /cosh\(/g,
            "mathFunctions.cosh("
        );

    exp =
        exp.replace(
            /tanh\(/g,
            "mathFunctions.tanh("
        );

    exp =
        exp.replace(
            /log\(/g,
            "mathFunctions.log("
        );

    exp =
        exp.replace(
            /ln\(/g,
            "mathFunctions.ln("
        );

    exp =
        exp.replace(
            /sqrt\(/g,
            "mathFunctions.sqrt("
        );

    exp =
        exp.replace(
            /cbrt\(/g,
            "mathFunctions.cbrt("
        );


    /*
        Factorial.
        Example:
        5! -> factorial(5)
    */

    while (/\d+!/.test(exp)) {

        exp =
            exp.replace(
                /(\d+(?:\.\d+)?)!/,
                "factorial($1)"
            );
    }


    /*
        Basic validation.

        This prevents unexpected characters
        from being evaluated.
    */

    if (
        /[^0-9+\-*/().,\sA-Za-z_π]/.test(exp)
    ) {
        throw new Error(
            "Invalid expression"
        );
    }


    /*
        Evaluate expression.

        Only calculator-generated
        expressions reach this point.
    */

    const calculate =
        new Function(
            "mathFunctions",
            "factorial",
            `"use strict"; return (${exp});`
        );

    const value =
        calculate(
            mathFunctions,
            factorial
        );

    if (
        typeof value !== "number" ||
        !Number.isFinite(value)
    ) {
        throw new Error(
            "Invalid mathematical result"
        );
    }

    return value;
}


/* =========================================
   CALCULATE BUTTON
========================================= */

function calculate() {

    if (!expression) {
        return;
    }

    try {

        const originalExpression =
            expression;

        const value =
            calculateExpression(expression);

        const formatted =
            formatResult(value);

        resultDisplay.textContent =
            formatted;

        lastAnswer = value;

        memoryLabel.textContent =
            `Ans: ${formatted}`;

        saveHistory(
            originalExpression,
            formatted
        );

    } catch (error) {

        resultDisplay.textContent =
            "Error";

        console.error(error);
    }
}


/* =========================================
   SCIENTIFIC FUNCTIONS
========================================= */

function applyFunction(functionName) {

    try {

        const number =
            getLastNumber();

        if (number === null) {

            /*
                If there is no number,
                create function( so user
                can type inside it.
            */

            expression +=
                functionName + "(";

            updateDisplay();

            return;
        }


        const value =
            parseFloat(number);


        let result;


        switch (functionName) {

            case "sin":
            case "cos":
            case "tan":
            case "asin":
            case "acos":
            case "atan":
            case "sinh":
            case "cosh":
            case "tanh":
            case "log":
            case "ln":
            case "sqrt":
            case "cbrt":

                result =
                    mathFunctions[
                        functionName
                    ](value);

                break;


            case "square":

                result =
                    Math.pow(value, 2);

                break;


            case "cube":

                result =
                    Math.pow(value, 3);

                break;


            case "factorial":

                result =
                    factorial(value);

                break;


            case "reciprocal":

                if (value === 0) {
                    throw new Error(
                        "Cannot divide by zero"
                    );
                }

                result =
                    1 / value;

                break;


            case "percent":

                result =
                    value / 100;

                break;


            case "power":

                /*
                    Convert:
                    5 -> 5^

                    Then user can enter
                    the exponent.
                */

                expression += "^";

                updateDisplay();

                return;


            default:

                return;
        }


        replaceLastNumber(
            formatResult(result)
        );

        resultDisplay.textContent =
            formatResult(result);

        updateDisplay();

    } catch (error) {

        resultDisplay.textContent =
            "Error";
    }
}


/* =========================================
   HISTORY
========================================= */

function saveHistory(
    calculation,
    result
) {

    const item = {

        expression: calculation,

        result: result,

        time:
            new Date().toLocaleTimeString(
                [],
                {
                    hour: "2-digit",
                    minute: "2-digit"
                }
            )
    };


    history.unshift(item);


    /*
        Keep latest 50 calculations.
    */

    history =
        history.slice(0, 50);


    localStorage.setItem(
        "scientificCalculatorHistory",
        JSON.stringify(history)
    );


    renderHistory();
}


/* =========================================
   RENDER HISTORY
========================================= */

function renderHistory() {

    if (history.length === 0) {

        historyList.innerHTML = `

            <div class="empty-history">

                <div class="empty-icon">
                    ∑
                </div>

                <h3>
                    No calculations yet
                </h3>

                <p>
                    Your calculations will appear here.
                </p>

            </div>
        `;

        return;
    }


    historyList.innerHTML = "";


    history.forEach(
        (item, index) => {

            const historyItem =
                document.createElement("div");

            historyItem.className =
                "history-item";


            historyItem.innerHTML = `

                <div class="history-expression">
                    ${escapeHTML(item.expression)}
                </div>

                <div class="history-result">
                    = ${escapeHTML(item.result)}
                </div>

                <div class="history-time">
                    ${item.time}
                </div>

            `;


            /*
                Clicking history restores
                the expression.
            */

            historyItem.addEventListener(
                "click",
                () => {

                    expression =
                        item.expression;

                    resultDisplay.textContent =
                        item.result;

                    historyPanel.classList.remove(
                        "show"
                    );

                    updateDisplay();
                }
            );


            historyList.appendChild(
                historyItem
            );
        }
    );
}


/* =========================================
   ESCAPE HTML
========================================= */

function escapeHTML(value) {

    const div =
        document.createElement("div");

    div.textContent =
        value;

    return div.innerHTML;
}


/* =========================================
   CLEAR HISTORY
========================================= */

clearHistoryBtn.addEventListener(
    "click",
    () => {

        history = [];

        localStorage.removeItem(
            "scientificCalculatorHistory"
        );

        renderHistory();
    }
);


/* =========================================
   HISTORY PANEL
========================================= */

historyBtn.addEventListener(
    "click",
    () => {

        renderHistory();

        historyPanel.classList.add(
            "show"
        );
    }
);


closeHistory.addEventListener(
    "click",
    () => {

        historyPanel.classList.remove(
            "show"
        );
    }
);


/* =========================================
   BUTTON EVENTS
========================================= */

document.addEventListener(
    "click",
    event => {

        const button =
            event.target.closest("button");

        if (!button) {
            return;
        }


        /*
            Normal value buttons
        */

        if (
            button.dataset.value !== undefined
        ) {

            addValue(
                button.dataset.value
            );

            return;
        }


        /*
            Scientific functions
        */

        if (
            button.dataset.function
        ) {

            applyFunction(
                button.dataset.function
            );

            return;
        }


        /*
            Actions
        */

        const action =
            button.dataset.action;


        switch (action) {

            case "clear":

                clearCalculator();

                break;


            case "delete":

                deleteLast();

                break;


            case "calculate":

                calculate();

                break;


            case "open":

                addValue("(");

                break;


            case "close":

                addValue(")");

                break;


            case "ans":

                addValue(
                    "Ans"
                );

                break;
        }

    }
);


/* =========================================
   KEYBOARD SUPPORT
========================================= */

document.addEventListener(
    "keydown",
    event => {

        const key =
            event.key;


        /*
            Numbers
        */

        if (
            /^[0-9.]$/.test(key)
        ) {

            addValue(key);

            return;
        }


        /*
            Operators
        */

        if (
            ["+", "-", "*", "/", "(", ")", "^"].includes(key)
        ) {

            addValue(key);

            return;
        }


        /*
            Enter
        */

        if (
            key === "Enter" ||
            key === "="
        ) {

            event.preventDefault();

            calculate();

            return;
        }


        /*
            Backspace
        */

        if (
            key === "Backspace"
        ) {

            deleteLast();

            return;
        }


        /*
            Escape
        */

        if (
            key === "Escape"
        ) {

            clearCalculator();

            return;
        }


        /*
            Percentage
        */

        if (
            key === "%"
        ) {

            applyFunction("percent");

            return;
        }


        /*
            Keyboard shortcuts
        */

        if (
            key.toLowerCase() === "d"
        ) {

            setAngleMode("DEG");

            return;
        }


        if (
            key.toLowerCase() === "r"
        ) {

            setAngleMode("RAD");

            return;
        }

    }
);


/* =========================================
   INITIALIZE
========================================= */

renderHistory();

updateDisplay();