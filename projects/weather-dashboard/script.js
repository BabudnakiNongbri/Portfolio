const cityInput = document.getElementById("cityInput");

const loading = document.getElementById("loading");

const errorBox = document.getElementById("error");

const weatherCard = document.querySelector(".weather-card");


function getWeather() {

    let city = cityInput.value.trim();

    if (city === "") {

        city = "Shillong";

        cityInput.value = city;

    }


    loading.style.display = "flex";

    errorBox.style.display = "none";

    weatherCard.style.opacity = "0.5";


    /*
        AJAX / Fetch request
        Fetches JSON data from the hypothetical API
    */

    fetch("api/weather.json")

        .then(response => {

            if (!response.ok) {

                throw new Error("Could not fetch weather data.");

            }

            return response.json();

        })

        .then(data => {

            /*
                Find selected city
            */

            const weather = data[city];


            if (!weather) {

                throw new Error(
                    "Weather data for " + city + " is not available."
                );

            }


            /*
                Update location
            */

            document.getElementById("location").textContent =
                city;


            /*
                Update weather information
            */

            document.getElementById("temperature").textContent =
                weather.temperature;


            document.getElementById("condition").textContent =
                weather.condition;


            document.getElementById("description").textContent =
                weather.description;


            document.getElementById("weatherIcon").textContent =
                weather.icon;


            /*
                Update statistics
            */

            document.getElementById("humidity").textContent =
                weather.humidity + "%";


            document.getElementById("wind").textContent =
                weather.wind + " km/h";


            document.getElementById("pressure").textContent =
                weather.pressure + " hPa";


            document.getElementById("visibility").textContent =
                weather.visibility + " km";


            /*
                Feels like
            */

            document.getElementById("feelsLike").textContent =
                weather.feels_like + "°";


            /*
                UV index
            */

            document.getElementById("uv").textContent =
                weather.uv;


            updateUV(weather.uv);


            /*
                Current date
            */

            updateDate();


            /*
                Finish loading
            */

            loading.style.display = "none";

            weatherCard.style.opacity = "1";

        })

        .catch(error => {

            console.error(error);

            loading.style.display = "none";

            weatherCard.style.opacity = "1";

            errorBox.textContent = error.message;

            errorBox.style.display = "block";

        });

}


/* =========================
   UV INDEX
========================= */

function updateUV(value) {

    const progress =
        document.getElementById("uvProgress");

    const text =
        document.getElementById("uvText");


    let width = value * 10;


    if (width > 100) {

        width = 100;

    }


    progress.style.width = width + "%";


    if (value <= 2) {

        text.textContent = "Low";

    }

    else if (value <= 5) {

        text.textContent = "Moderate";

    }

    else if (value <= 7) {

        text.textContent = "High";

    }

    else {

        text.textContent = "Very High";

    }

}


/* =========================
   DATE
========================= */

function updateDate() {

    const today = new Date();


    const options = {

        weekday: "long",

        month: "long",

        day: "numeric",

        year: "numeric"

    };


    document.getElementById("date").textContent =
        today.toLocaleDateString("en-IN", options);

}


/* =========================
   ENTER KEY
========================= */

cityInput.addEventListener("keydown", function(event) {

    if (event.key === "Enter") {

        getWeather();

    }

});


/* =========================
   INITIAL LOAD
========================= */

window.addEventListener("load", function() {

    cityInput.value = "Shillong";

    getWeather();

});