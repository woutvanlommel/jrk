console.log("✅ kalender.js is geladen");

console.log(API_KEY); // 👉 dit werkt perfect (toont: abc123)

const CALENDAR_ID = [
  "woutvanlommel7@gmail.com",
  "9f8aecf23be1e8387aa31872f5df2a5308dde848a01f854f9db282cad285b683@group.calendar.google.com",
  "0baaf1cea005548f41707e9942f8fe0733e31efe6b654b71f90ac65196da9fcf@group.calendar.google.com",
  "b940058507355683160f31fa21ce080c434a4b3344447e355e402a7a4bfa7d84@group.calendar.google.com",
  "7b5c3807b7714e41c9260b40a1ae2ecde3042aa4c1f6dc23715c8b5d951b303c@group.calendar.google.com"
];

const calendarColors = {
  "woutvanlommel7@gmail.com": "#FFE135",
  "9f8aecf23be1e8387aa31872f5df2a5308dde848a01f854f9db282cad285b683@group.calendar.google.com": "#FF0000",
  "0baaf1cea005548f41707e9942f8fe0733e31efe6b654b71f90ac65196da9fcf@group.calendar.google.com": "#616F5F",
  "b940058507355683160f31fa21ce080c434a4b3344447e355e402a7a4bfa7d84@group.calendar.google.com": "#FFC107",
  "7b5c3807b7714e41c9260b40a1ae2ecde3042aa4c1f6dc23715c8b5d951b303c@group.calendar.google.com": "#734768"
};

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

modal.classList.add("hidden");
modalOverlay.classList.add("hidden");

const today = new Date();
let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
let selectedDay = null;

const monthNames = [
  "Januari", "Februari", "Maart", "April", "Mei", "Juni",
  "Juli", "Augustus", "September", "Oktober", "November", "December"
];

async function fetchEvents(year, month) {
  console.log("🔄 fetchEvents start:", year, month + 1);
  const timeMin = new Date(year, month, 1).toISOString();
  const timeMax = new Date(year, month + 1, 0, 23, 59, 59).toISOString();
  let allEvents = [];

  for (const calendarId of CALENDAR_ID) {
    const url = `https://www.googleapis.com/calendar/v3/calendars/${encodeURIComponent(calendarId)}/events?key=${API_KEY}&timeMin=${timeMin}&timeMax=${timeMax}&singleEvents=true&orderBy=startTime`;

    try {
      const response = await fetch(url);
      const data = await response.json();
      const items = data.items || [];
      console.log(`📥 Events van ${calendarId}:`, items.length);

      items.forEach(item => {
        item.calendarId = calendarId;
      });

      allEvents = allEvents.concat(items);
    } catch (error) {
      console.error(`❌ Fout bij ophalen van events (${calendarId}):`, error);
    }
  }

  console.log("📊 Totaal aantal events opgehaald:", allEvents.length);
  return allEvents;
}

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

  for (let i = startWeekDay - 1; i >= 0; i--) {
    const dayDiv = document.createElement("div");
    dayDiv.className = "day other-month";
    dayDiv.innerHTML = `<span class="date-number" style="color: #ccc;">${prevMonthLastDate - i}</span>`;
    calendarDays.appendChild(dayDiv);
  }

  for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
    const date = new Date(year, month, i);
    const isoDatum = date.toISOString().split("T")[0];
    const dayDiv = document.createElement("div");
    dayDiv.className = "day";
    dayDiv.setAttribute("data-datum", isoDatum);

    const dateLabel = document.createElement("span");
    dateLabel.className = "date-number";
    dateLabel.textContent = i;
    dayDiv.appendChild(dateLabel);

    if (today.toDateString() === date.toDateString()) {
      dayDiv.classList.add("today");
    }

    calendarDays.appendChild(dayDiv);
  }

  const totalCells = calendarDays.children.length;
  const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);

  for (let i = 1; i <= remaining; i++) {
    const dayDiv = document.createElement("div");
    dayDiv.className = "day other-month";
    dayDiv.innerHTML = `<span class="date-number" style="color: #ccc;">${i}</span>`;
    calendarDays.appendChild(dayDiv);
  }

  events.forEach(ev => {
    const start = new Date(ev.start?.dateTime || ev.start?.date);
    let end = new Date(ev.end?.dateTime || ev.end?.date);
    const isAllDay = !ev.start?.dateTime;

    if (isAllDay && ev.end?.date && !ev.end?.dateTime) {
      end = new Date(new Date(ev.end.date).getTime() - 86400000);
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
      const eventDate = new Date(year, month, d);
      const iso = eventDate.toISOString().split("T")[0];
      const dayEl = document.querySelector(`[data-datum="${iso}"]`);
      if (!dayEl) continue;

      const activity = document.createElement("div");
      activity.className = "activity-range";
      activity.textContent = eventTitleText;
      activity.style.backgroundColor = calendarColors[ev.calendarId] || "#444";

      activity.addEventListener("click", (e) => {
        e.stopPropagation();
      
        const eventTitleText = ev.summary || "Activiteit";
        const startStr = `${start.getDate()} ${monthNames[start.getMonth()]} ${start.getFullYear()}`;
        const endStr = `${end.getDate()} ${monthNames[end.getMonth()]} ${end.getFullYear()}`;
      
        if (startStr === endStr) {
          eventTitle.textContent = `${eventTitleText} van ${startStr}`;
        } else {
          eventTitle.textContent = `${eventTitleText}`;
        }
      
        if (ev.start?.dateTime) {
          eventTime.textContent = `🕒 ${start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
        } else if (startStr !== endStr) {
          eventTime.textContent = `⏳ Van ${startStr} tot ${endStr}`;
        } else {
          eventTime.textContent = "⏳ Hele dag";
        }
      
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

prevMonth.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
});
nextMonth.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
});
todayBtn.addEventListener("click", () => {
  currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
  selectedDay = null;
  renderCalendar();
});

monthYear.addEventListener("click", (e) => {
  const rect = e.target.getBoundingClientRect();
  monthPopup.classList.remove("hidden");
  monthPopup.style.top = `${rect.bottom + window.scrollY}px`;
  monthPopup.style.left = `${rect.left}px`;

  monthSelect.value = currentDate.getMonth();
  yearSelect.value = currentDate.getFullYear();
});

window.addEventListener("click", (e) => {
  if (!monthPopup.contains(e.target) && !monthYear.contains(e.target)) {
    monthPopup.classList.add("hidden");
  }
});

goToDateBtn.addEventListener("click", () => {
  const m = parseInt(monthSelect.value);
  const y = parseInt(yearSelect.value);
  currentDate = new Date(y, m, 1);
  selectedDay = null;
  monthPopup.classList.add("hidden");
  renderCalendar();
});

function closeEventModal() {
  modal.classList.add("hidden");
  modalOverlay.classList.add("hidden");
  const highlighted = document.querySelector(".highlight");
  if (highlighted) highlighted.classList.remove("highlight");
  const url = new URL(window.location);
  url.searchParams.delete("datum");
  window.history.replaceState({}, document.title, url.pathname);
}

document.getElementById("eventModal").querySelector("button").addEventListener("click", closeEventModal);
modalOverlay.addEventListener("click", closeEventModal);

document.addEventListener("keydown", (e) => {
  if (!modal.classList.contains("hidden") && (e.key === "Escape" || e.key === "Enter")) {
    closeEventModal();
  }
});

function scrollNaarDatum(datum) {
  const geselecteerde = new Date(datum);
  const datumPlus1 = new Date(geselecteerde.getTime() - 1);
  const iso = datumPlus1.toISOString().split("T")[0];

  const dayEl = document.querySelector(`[data-datum="${iso}"]`) || document.querySelector(`[data-datum="${datum}"]`);
  if (!dayEl) return;

  dayEl.scrollIntoView({ behavior: "smooth", block: "center" });
  dayEl.classList.add("highlight");

  const firstActivity = dayEl.querySelector(".activity-range");
  if (firstActivity) {
    firstActivity.click();
  }
}

(() => {
  const params = new URLSearchParams(window.location.search);
  const geselecteerdeDatum = params.get("datum");

  if (geselecteerdeDatum) {
    const datumParts = geselecteerdeDatum.split("-");
    if (datumParts.length === 3) {
      const jaar = parseInt(datumParts[0]);
      const maand = parseInt(datumParts[1]) - 1;
      currentDate = new Date(jaar, maand, 1);
    }
  }

  renderCalendar().then(() => {
    console.log("📅 Eerste render klaar");
    document.getElementById("calendarWrapper").style.display = "block";
    document.getElementById("loading").style.display = "none";

    if (geselecteerdeDatum) {
      scrollNaarDatum(geselecteerdeDatum);
    }
  });
})();