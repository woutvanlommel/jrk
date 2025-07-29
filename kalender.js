console.log("✅ kalender.js is geladen");

// 🎯 REST endpoint
const API_KEY = jrkCalendar.apiKey;
const API_ENDPOINT = jrkCalendar.restUrl;

const calendarColors = {
  "9f8aecf23be1e8387aa31872f5df2a5308dde848a01f854f9db282cad285b683@group.calendar.google.com": "#FF0000",
  "0baaf1cea005548f41707e9942f8fe0733e31efe6b654b71f90ac65196da9fcf@group.calendar.google.com": "#616F5F",
  "b940058507355683160f31fa21ce080c434a4b3344447e355e402a7a4bfa7d84@group.calendar.google.com": "#FFC107",
  "7b5c3807b7714e41c9260b40a1ae2ecde3042aa4c1f6dc23715c8b5d951b303c@group.calendar.google.com": "#734768",
  "5578d000dbaac65888adf7dbd787d7c7187386ae40ca78e20f3859e5487ffa9e@group.calendar.google.com": "#FFFFE0"
};

// 🔗 DOM elementen
const calendarDays = document.getElementById("calendarDays");
const monthYear = document.getElementById("monthYear");
const prevMonth = document.getElementById("prevMonth");
const nextMonth = document.getElementById("nextMonth");
const todayBtn = document.getElementById("todayBtn");
const monthPopup = document.getElementById("monthPicker");
const monthSelect = document.getElementById("monthSelect");
const yearSelect = document.getElementById("yearSelect");
const goToDateBtn = document.getElementById("goToDate");
const modal = document.getElementById("eventModal");
const modalOverlay = document.getElementById("modalOverlay");
const eventTitle = document.getElementById("eventTitle");
const eventTime = document.getElementById("eventTime");
const eventLocation = document.getElementById("eventLocation");
const eventDescription = document.getElementById("eventDescription");
const closeModalBtn = modal.querySelector("button"); // ❌ Close button

modal.classList.add("hidden");
modalOverlay.classList.add("hidden");

const today = new Date();
let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);

const monthNames = [
  "Januari", "Februari", "Maart", "April", "Mei", "Juni",
  "Juli", "Augustus", "September", "Oktober", "November", "December"
];

// 📡 Events ophalen
async function fetchEvents(year, month) {
  console.log("🔄 fetchEvents start:", year, month + 1);
  const timeMin = new Date(year, month, 1).toISOString();
  const timeMax = new Date(year, month + 1, 0, 23, 59, 59).toISOString();

  try {
    const url = `${API_ENDPOINT}?timeMin=${encodeURIComponent(timeMin)}&timeMax=${encodeURIComponent(timeMax)}`;
    console.log("🌐 Fetch URL:", url);

    const response = await fetch(url);
    const data = await response.json();

    if (!Array.isArray(data)) {
      console.error("❌ API gaf geen array terug:", data);
      return [];
    }

    console.log(`📥 ${data.length} events opgehaald`);
    return data;
  } catch (error) {
    console.error("❌ Fout bij ophalen van events:", error);
    return [];
  }
}

// 📅 Kalender renderen
const renderCalendar = async () => {
  console.log("🛠️ Start renderCalendar()");
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();
  const events = await fetchEvents(year, month);

  calendarDays.innerHTML = "";
  monthYear.textContent = `${monthNames[month]} ${year}`;

  const firstDayOfMonth = new Date(year, month, 1);
  const lastDayOfMonth = new Date(year, month + 1, 0);
  const startWeekDay = (firstDayOfMonth.getDay() + 6) % 7;
  const prevMonthLastDate = new Date(year, month, 0).getDate();

  // Dagen vorige maand
  for (let i = startWeekDay - 1; i >= 0; i--) {
    calendarDays.innerHTML += `<div class="day other-month"><span class="date-number" style="color:#ccc;">${prevMonthLastDate - i}</span></div>`;
  }

  // Dagen huidige maand
  for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
    const date = new Date(year, month, i);
    const isoDatum = date.toISOString().split("T")[0];
    calendarDays.innerHTML += `<div class="day${today.toDateString()===date.toDateString()?" today":""}" data-datum="${isoDatum}"><span class="date-number">${i}</span></div>`;
  }

  // Dagen volgende maand
  const totalCells = calendarDays.children.length;
  const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
  for (let i = 1; i <= remaining; i++) {
    calendarDays.innerHTML += `<div class="day other-month"><span class="date-number" style="color:#ccc;">${i}</span></div>`;
  }

  // Events plaatsen
  events.forEach(ev => {
    const startDate = ev.start?.dateTime || ev.start?.date;
    const endDate = ev.end?.dateTime || ev.end?.date;
    if (!startDate || !endDate) return;

    const start = new Date(startDate);
    let end = new Date(endDate);
    if (!ev.start?.dateTime && ev.end?.date && !ev.end?.dateTime) {
      end = new Date(end.getTime() - 86400000);
    }

    const startStr = `${start.getDate()} ${monthNames[start.getMonth()]} ${start.getFullYear()}`;
    const endStr = `${end.getDate()} ${monthNames[end.getMonth()]} ${end.getFullYear()}`;
    const eventTitleText = ev.summary || "Activiteit";

    const currentMonthStart = new Date(year, month, 1);
    const currentMonthEnd = new Date(year, month + 1, 0);
    if (end < currentMonthStart || start > currentMonthEnd) return;

    const rangeStart = start < currentMonthStart ? 1 : start.getDate();
    const rangeEnd = end > currentMonthEnd ? lastDayOfMonth.getDate() : end.getDate();

    for (let d = rangeStart; d <= rangeEnd; d++) {
      const iso = new Date(year, month, d).toISOString().split("T")[0];
      const dayEl = document.querySelector(`[data-datum="${iso}"]`);
      if (!dayEl) continue;

      const activity = document.createElement("div");
      activity.className = "activity-range";
      activity.textContent = eventTitleText;
      activity.style.backgroundColor = calendarColors[ev.calendarId] || "#444";

      activity.addEventListener("click", () => {
        // Titel aanpassen op basis van duur
        if (startStr === endStr) {
          eventTitle.textContent = `${eventTitleText} van ${startStr}`;
        } else {
          eventTitle.textContent = `${eventTitleText}`;
        }

        // Tijd
        if (ev.start?.dateTime) {
          eventTime.textContent = `🕒 ${start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
        } else if (startStr !== endStr) {
          eventTime.textContent = `⏳ Van ${startStr} tot ${endStr}`;
        } else {
          eventTime.textContent = "⏳ Hele dag";
        }

        // Locatie & beschrijving
        eventLocation.textContent = `📍 ${ev.location || "Geen locatie"}`;
        eventDescription.textContent = `🗒️ ${ev.description || "Geen beschrijving"}`;

        modal.classList.remove("hidden");
        modalOverlay.classList.remove("hidden");
      });

      dayEl.appendChild(activity);
    }
  });

  console.log("✅ Kalender gerenderd voor", monthNames[month], year);
};

// 🔄 Navigatie
prevMonth.addEventListener("click", () => { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(); });
nextMonth.addEventListener("click", () => { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(); });
todayBtn.addEventListener("click", () => { currentDate = new Date(today.getFullYear(), today.getMonth(), 1); renderCalendar(); });

// ❌ Modal sluiten functies
function closeModal() {
  modal.classList.add("hidden");
  modalOverlay.classList.add("hidden");
}

// Klik op kruisje
closeModalBtn.addEventListener("click", closeModal);

// Klik op overlay
modalOverlay.addEventListener("click", closeModal);

// Druk op Escape
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") closeModal();
});

// 📅 Init
(() => {
  renderCalendar().then(() => {
    console.log("📅 Eerste render klaar");
    document.getElementById("calendarWrapper").style.display = "block";
    document.getElementById("loading").style.display = "none";
  });
})();
