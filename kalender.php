<?php 
  $activePage = 'kalender';
  include 'header.php'; 
?>

<header>
    <h1>Kalender</h1>
</header>

<main>
    <div id="loading">Kalender wordt geladen...</div>

    <div id="calendarWrapper" style="display: none;">
        <div class="calendar">
            <div class="calendar-header">
                <button id="prevMonth">&lt;</button>
                <div id="monthYear"></div>
                <button id="nextMonth">&gt;</button>
            </div>

            <div class="calendar-weekdays">
                <div>Ma</div><div>Di</div><div>Wo</div><div>Do</div><div>Vr</div><div style="color: red;">Za</div><div style="color: red;">Zo</div>
            </div>

            <div class="calendar-grid" id="calendarDays"></div>

            <button id="todayBtn">Vandaag</button>
        </div>

        <div id="monthPicker" class="month-popup hidden">
            <label for="monthSelect">Maand:
                <select id="monthSelect">
                    <option value="0">Januari</option>
                    <option value="1">Februari</option>
                    <option value="2">Maart</option>
                    <option value="3">April</option>
                    <option value="4">Mei</option>
                    <option value="5">Juni</option>
                    <option value="6">Juli</option>
                    <option value="7">Augustus</option>
                    <option value="8">September</option>
                    <option value="9">Oktober</option>
                    <option value="10">November</option>
                    <option value="11">December</option>
                </select>
            </label>
            <br />
            <label for="yearSelect">Jaar:
                <input type="number" id="yearSelect" min="2000" max="2100">
            </label>
            <br />
            <button id="goToDate">Ga</button>
        </div>
    </div>

    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="event-modal" id="eventModal">
        <h3 id="eventTitle"></h3>
        <p id="eventTime"></p>
        <p id="eventLocation"></p>
        <p id="eventDescription"></p>
        <button onclick="closeEventModal()" id="button">Sluiten</button>
    </div>

    <script src="kalender.js"></script>
</main>

<?php include 'footer.php'; ?>