const projects = [

    {
        title: "Football Jersey E-Commerce Website",

        description: "A responsive frontend e-commerce website for football jerseys built using HTML, CSS, and JavaScript.",

        image: "images/football-store.png",

        github: "https://github.com/BabudnakiNongbriB/football-store",

        demo: "projects/football-store/index.html"
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