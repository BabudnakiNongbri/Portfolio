// ----------------------
// Shuffle Function
// ----------------------
function shuffle(array) {
    return array.sort(() => Math.random() - 0.5);
}

// Shuffle all questions and select only 20
const quizQuestions = shuffle([...questions]).slice(0, 20);

// ----------------------
// DOM Elements
// ----------------------
const startScreen = document.getElementById("startScreen");
const quizScreen = document.getElementById("quizScreen");
const resultScreen = document.getElementById("resultScreen");

const startBtn = document.getElementById("startBtn");
const nextBtn = document.getElementById("nextBtn");
const prevBtn = document.getElementById("prevBtn");

const questionEl = document.getElementById("question");
const answersEl = document.getElementById("answers");

const scoreEl = document.getElementById("score");

const timerEl = document.getElementById("timer");

const currentQuestion = document.getElementById("currentQuestion");
const totalQuestions = document.getElementById("totalQuestions");
const progressFill = document.getElementById("progressFill");

// ----------------------
// Variables
// ----------------------
let currentIndex = 0;
let score = 0;
let selectedAnswers = new Array(quizQuestions.length).fill(null);

let totalTime = 20 * 60;
let timer;

// ----------------------
// Initial Setup
// ----------------------
totalQuestions.textContent = quizQuestions.length;

// ----------------------
// Start Quiz
// ----------------------
startBtn.addEventListener("click", () => {

    startScreen.classList.add("hide");
    quizScreen.classList.remove("hide");

    startTimer();
    loadQuestion();

});

// ----------------------
// Timer
// ----------------------
function startTimer() {

    updateTimer();

    timer = setInterval(() => {

        totalTime--;

        updateTimer();

        if (totalTime <= 0) {
            clearInterval(timer);
            finishQuiz();
        }

    }, 1000);

}

function updateTimer() {

    const mins = Math.floor(totalTime / 60);
    const secs = totalTime % 60;

    timerEl.textContent =
        `${String(mins).padStart(2, "0")}:${String(secs).padStart(2, "0")}`;

}

// ----------------------
// Load Question
// ----------------------
function loadQuestion() {

    const q = quizQuestions[currentIndex];

    currentQuestion.textContent = currentIndex + 1;

    progressFill.style.width =
        ((currentIndex + 1) / quizQuestions.length) * 100 + "%";

    questionEl.textContent = q.question;

    answersEl.innerHTML = "";

    let options = [...q.options];
    shuffle(options);

    options.forEach(option => {

        const button = document.createElement("button");

        button.className = "answer";
        button.textContent = option;

        if (selectedAnswers[currentIndex] === option) {
            button.classList.add("selected");
        }

        button.onclick = () => {

            selectedAnswers[currentIndex] = option;

            document.querySelectorAll(".answer").forEach(btn => {
                btn.classList.remove("selected");
            });

            button.classList.add("selected");

        };

        answersEl.appendChild(button);

    });

    prevBtn.disabled = currentIndex === 0;

    if (currentIndex === quizQuestions.length - 1) {
        nextBtn.textContent = "Finish";
    } else {
        nextBtn.textContent = "Next";
    }

}

// ----------------------
// Next
// ----------------------
nextBtn.addEventListener("click", () => {

    if (selectedAnswers[currentIndex] === null) {
        alert("Please select an answer first.");
        return;
    }

    if (currentIndex < quizQuestions.length - 1) {

        currentIndex++;
        loadQuestion();

    } else {

        finishQuiz();

    }

});

// ----------------------
// Previous
// ----------------------
prevBtn.addEventListener("click", () => {

    if (currentIndex > 0) {

        currentIndex--;
        loadQuestion();

    }

});

// ----------------------
// Finish Quiz
// ----------------------
function finishQuiz() {

    clearInterval(timer);

    score = 0;

    quizQuestions.forEach((question, index) => {

        if (selectedAnswers[index] === question.answer) {
            score++;
        }

    });

    quizScreen.classList.add("hide");
    resultScreen.classList.remove("hide");

    const percentage = Math.round((score / quizQuestions.length) * 100);

    let message = "";

    if (percentage >= 90) {
        message = "🏆 Excellent!";
    } else if (percentage >= 75) {
        message = "🎉 Great Job!";
    } else if (percentage >= 50) {
        message = "👍 Good Attempt!";
    } else {
        message = "📚 Keep Practicing!";
    }

    let highScore = Number(localStorage.getItem("quizHighScore")) || 0;

    if (score > highScore) {
        highScore = score;
        localStorage.setItem("quizHighScore", highScore);
    }

    scoreEl.innerHTML = `
        <h2>${message}</h2>
        <br>
        <h1>${score} / ${quizQuestions.length}</h1>
        <br>
        <h3>${percentage}%</h3>
        <br>
        <p>Highest Score: ${highScore}</p>
    `;

}