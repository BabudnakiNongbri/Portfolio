// 1) After deploying the PHP projects on Render, paste your Render URL here (no trailing slash).
const PHP_HOST = "https://portfolio-php-hntp.onrender.com";

const PHP_NOTE = "Backend runs on a free server - the first load can take up to a minute to wake up.";

const projects = [

    {
        title: "Football Jersey E-Commerce Website",

        description: "A responsive frontend e-commerce website for football jerseys built using HTML, CSS, and JavaScript.",

        image: "images/football-store.png",

        github: "https://github.com/BabudnakiNongbriB/football-store",

        demo: "projects/football-store/index.html"
    },

    {
        title: "Quiz Portal",

        description: "An interactive quiz application with 40 questions that randomly selects 20 questions for every attempt, with timer, scoring and high-score tracking.",

        image: "images/quiz-portal.png",

        github: "#",

        demo: "projects/quiz-portal/index.html"
    },
    {
    title: "Scientific Calculator",

    description: "A responsive scientific calculator with advanced mathematical functions, DEG/RAD modes, calculation history, keyboard support and real-time expression evaluation.",

    image: "images/scientific-calculator.png",

    github: "#",

    demo: "projects/scientific-calculator/index.html"
},
{
    title: "Employee Management System",

    description: "A web-based employee management system developed using HTML, PHP and MySQL.",

    image: "images/employee-management.png",

    github: "https://github.com/BabudnakiNongbri/Portfolio/tree/main/projects/employee-management",

    demo: PHP_HOST + "/employee-management/",
    note: PHP_NOTE
},
 {
        title: "Department Portal",

        description: "A dynamic department website with Home, About Us, Registration and Login functionality using HTML, CSS, JavaScript, PHP and MySQL.",

        image: "images/department-portal.png",

        github: "https://github.com/BabudnakiNongbri/Portfolio/tree/main/projects/department-portal",

        demo: PHP_HOST + "/department-portal/",
        note: PHP_NOTE
    },
{
    title: "Nexora – Company Portal",

    description: "A dynamic company portal with separate employee and admin authentication, registration, role-based access and database management using HTML, CSS, JavaScript, PHP and MySQL.",

    image: "images/nexora.png",

    github: "https://github.com/BabudnakiNongbri/Portfolio/tree/main/projects/nexora-company",

    demo: PHP_HOST + "/nexora-company/",
    note: PHP_NOTE
},
{
    title: "Contact Management Application",
    description: "A secure contact management application developed using HTML, CSS, JavaScript, PHP and MySQL with features to add, view, edit and delete contacts.",
    image: "images/contact-management.png",
    github: "https://github.com/BabudnakiNongbri/Portfolio/tree/main/projects/contact-management",
    demo: PHP_HOST + "/contact-management/",
    note: PHP_NOTE
},
{
    title: "Weather Dashboard",
    description: "A responsive weather dashboard using AJAX and JSON to fetch and display weather information for different cities without refreshing the page.",
    image: "images/weather-dashboard.png",
    github: "https://github.com/BabudnakiNongbri/Portfolio/tree/main/projects/weather-dashboard",
    demo: "projects/weather-dashboard/index.html",
    technologies: ["HTML", "CSS", "JavaScript", "AJAX", "JSON"]
},
{
    title: "Book Explorer",
    description: "A modern book discovery platform with live API search, AJAX, JSON, category filters, sorting and favorites.",
    image: "images/book-explorer.png",
    github: "https://github.com/BabudnakiNongbri/Portfolio/tree/main/projects/book-explorer",
    demo: "projects/book-explorer/index.html",
    technologies: ["HTML", "CSS", "JavaScript", "jQuery", "AJAX", "JSON"]
}
];

// Future projects will be added here.

const container = document.getElementById("projects-container");

if (projects.length === 0) {

    container.innerHTML = `

        <div class="project-card">

            <div class="project-content">

                <h2>🚀 Projects Coming Soon</h2>

                <p>

                    I'm currently working on exciting projects.

                    They'll be displayed here soon.

                </p>

            </div>

        </div>

    `;

}

else{

    projects.forEach(project=>{

        container.innerHTML += `

            <div class="project-card">

                <img src="${project.image}" class="project-image">

                <div class="project-content">

                    <h3>${project.title}</h3>

                    <p>${project.description}</p>

                    <div class="project-links">

                        <a href="${project.github}" target="_blank">

                        GitHub

                        </a>

                        <a href="${project.demo}" target="_blank">

                        Live Demo

                        </a>

                    </div>

                    ${project.note ? `<p class="project-note">${project.note}</p>` : ""}

                </div>

            </div>

        `;

    });

}

// Wake the free PHP server in the background so the demos open quickly
if (!PHP_HOST.includes("YOUR-SERVICE")) {
    fetch(PHP_HOST + "/health.php", { mode: "no-cors" }).catch(() => {});
}
