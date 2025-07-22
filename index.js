  /* Wisselwoord */
  
  document.addEventListener("DOMContentLoaded", function () {
    const woorden = ["plezier", "vriendschap", "spel", "helpen", "leren", "actie"];
    const wisselEl = document.querySelector(".wisselwoord");
    let index = 0;

    setInterval(() => {
      wisselEl.style.opacity = 0;

      setTimeout(() => {
        index = (index + 1) % woorden.length;
        wisselEl.textContent = woorden[index];
        wisselEl.style.opacity = 1;
      }, 300);
    }, 2000);
  });



/* Automatische speciale activiteiten */

const SPECIAL_CALENDAR_ID = "0baaf1cea005548f41707e9942f8fe0733e31efe6b654b71f90ac65196da9fcf@group.calendar.google.com";
const API_KEY = "AIzaSyCEDTK2UrwicSEqgrjmY8QetAbGEYQGh6Q";

async function getSpecialeActiviteiten() {
  const now = new Date().toISOString();
  const url = `https://www.googleapis.com/calendar/v3/calendars/${SPECIAL_CALENDAR_ID}/events?key=${API_KEY}&timeMin=${now}&singleEvents=true&orderBy=startTime&maxResults=3`;

  const response = await fetch(url);
  const data = await response.json();
  return data.items || [];
}

function maakActiviteitCard(event) {
    const title = event.summary || "Geen titel";
    const beschrijving = event.description || "Geen beschrijving beschikbaar.";
    const datumRaw = event.start.date || event.start.dateTime;
    const datum = new Date(datumRaw).toLocaleDateString("nl-BE", {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric"
    });
    const locatie = event.location || "Locatie niet bekend";
  
    // 👇 formatteer datum in YYYY-MM-DD voor URL
    const datumVoorUrl = datumRaw.split("T")[0];
  
    const link = `/jrk/kalender.html?datum=${datumVoorUrl}`; // pas pad aan indien nodig
  
    return `
      <a class="activiteitkaart" href="${link}">
        <div>
          <h4>${title}</h4>
          <p><strong>${datum}</strong></p>
          <p><em>${locatie}</em></p>
          <p>${beschrijving}</p>
        </div>
      </a>
    `;
  }

async function laadSpecialeActiviteiten() {
  const container = document.getElementById("speciale-activiteiten-container");
  const activiteiten = await getSpecialeActiviteiten();
  container.innerHTML = activiteiten.map(maakActiviteitCard).join("");
}

document.addEventListener("DOMContentLoaded", laadSpecialeActiviteiten);

/* Automatische hoofdleiding */
fetch('leiding.json')
  .then(response => response.json())
  .then(data => {
    const hoofdleiding = data.filter(p => p.rol === "hoofdleiding");
    const container = document.getElementById("hoofdleidingContainer");

    hoofdleiding.forEach(persoon => {
      const div = document.createElement("div");
      div.className = "persoon";

      div.innerHTML = `
        <img src="${persoon.foto}" alt="Hoofdleiding ${persoon.naam}">
        <div class="persooninfo">
          <h4>${persoon.naam}</h4>
          <a href="tel:${persoon.telefoon}">
            📞 ${persoon.telefoon}
          </a>
          <a href="mailto:${persoon.email}">
            ✉️ ${persoon.email}
          </a>
        </div>
      `;

      container.appendChild(div);
    });
  })
  .catch(error => console.error("Fout bij ophalen leiding.json:", error));
