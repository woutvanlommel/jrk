/* ===================== */
/* 🔁 Wisselwoord (dynamisch uit WordPress) */
/* ===================== */
document.addEventListener("DOMContentLoaded", function () {
  if (typeof wisselData === "undefined" || !Array.isArray(wisselData.woorden) || wisselData.woorden.length === 0) {
    console.warn("⚠️ Geen wisselwoorden gevonden in wisselData");
    return;
  }

  const woorden = wisselData.woorden;
  const wisselEl = document.querySelector(".wisselwoord");
  let index = 0;

  if (wisselEl) {
    console.log("🎯 Wisselwoord-element gevonden");
    setInterval(() => {
      wisselEl.style.opacity = 0;

      setTimeout(() => {
        index = (index + 1) % woorden.length;
        wisselEl.textContent = woorden[index];
        wisselEl.style.opacity = 1;
        console.log(`🔄 Wisselwoord veranderd naar: ${woorden[index]}`);
      }, 300);
    }, 2000);
  } else {
    console.warn("⚠️ Geen .wisselwoord element gevonden");
  }
});

/* ============================== */
/* 📆 Speciale activiteiten ophalen */
/* ============================== */
const SPECIAL_CALENDAR_ID = "0baaf1cea005548f41707e9942f8fe0733e31efe6b654b71f90ac65196da9fcf@group.calendar.google.com";

async function getSpecialeActiviteiten() {
  const now = new Date().toISOString();
  const url = `https://www.googleapis.com/calendar/v3/calendars/${SPECIAL_CALENDAR_ID}/events?key=${API_KEY}&timeMin=${now}&singleEvents=true&orderBy=startTime&maxResults=3`;

  try {
    const response = await fetch(url);
    const data = await response.json();
    console.log("✅ Activiteiten opgehaald van Google Calendar:", data.items);
    return data.items || [];
  } catch (err) {
    console.error("❌ Fout bij ophalen Google Calendar-data:", err);
    return [];
  }
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
  const datumVoorUrl = datumRaw.split("T")[0];

  const baseUrl = (typeof jrkData !== "undefined" && jrkData.siteUrl) ? jrkData.siteUrl : ".";
  const link = `${baseUrl}/kalender/?datum=${datumVoorUrl}`;

  console.log(`📝 Activiteitkaart aangemaakt voor ${title} op ${datum}`);

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
  if (!container) {
    console.warn("⚠️ Geen container gevonden voor speciale activiteiten");
    return;
  }

  const activiteiten = await getSpecialeActiviteiten();
  container.innerHTML = activiteiten.map(maakActiviteitCard).join("");

  console.log(`📌 ${activiteiten.length} activiteit(en) toegevoegd aan de container`);
}

document.addEventListener("DOMContentLoaded", laadSpecialeActiviteiten);

/* =============================== */
/* 👥 Hoofdleiding automatisch laden */
/* =============================== */
function laadHoofdleiding() {
  const container = document.getElementById("hoofdleidingContainer");
  if (!container) {
    console.warn("⚠️ Geen hoofdleidingContainer gevonden");
    return;
  }

  if (typeof leidingData === "undefined" || !Array.isArray(leidingData.leiding)) {
    console.error("❌ Leidingdata niet gevonden of ongeldig");
    return;
  }

  const hoofdleiding = leidingData.leiding.filter(p =>
    Array.isArray(p.rollen)
      ? p.rollen.includes("hoofdleiding")
      : p.rollen === "hoofdleiding"
  );

  console.log(`👥 ${hoofdleiding.length} hoofdleiding(en) gevonden`);

  if (hoofdleiding.length === 0) {
    container.innerHTML = "<p>Er is momenteel geen hoofdleiding beschikbaar.</p>";
    return;
  }

  hoofdleiding.forEach(persoon => {
    const div = document.createElement("div");
    div.className = "persoon";

    div.innerHTML = `
      <img src="${persoon.foto}" alt="Hoofdleiding ${persoon.naam}">
      <div class="persooninfo">
        <h4>${persoon.naam}</h4>
        <a href="tel:${persoon.telefoon}">📞 ${persoon.telefoon}</a>
        <a href="mailto:${persoon.email}">✉️ ${persoon.email}</a>
      </div>
    `;

    container.appendChild(div);
    console.log(`➕ ${persoon.naam} toegevoegd aan hoofdleidingContainer`);
  });
}

document.addEventListener("DOMContentLoaded", laadHoofdleiding);
