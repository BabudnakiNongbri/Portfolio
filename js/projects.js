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

    github: "#",

    demo: "http://localhost/employee-management/"
},
 {
        title: "Department Portal",

        description: "A dynamic department website with Home, About Us, Registration and Login functionality using HTML, CSS, JavaScript, PHP and MySQL.",

        image: "images/department-portal.png",

        github: "#",

        demo: "http://localhost/department-portal/"
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

                </div>

            </div>

        `;

    });

}