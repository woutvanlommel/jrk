<?php
/*
Template Name: Kalenderpagina
*/

if (!isset($activePage)) {
    $activePage = 'kalender';
}

if (function_exists('get_header')) {
    get_header();
} else {
    include 'header.php';
}
?>

<header>
    <h1>Kalender</h1>
</header>

<main>
    <!-- 📅 Lade-indicator -->
    <div id="loading">Kalender wordt geladen...</div>

    <!-- 📆 Kalenderblok -->
    <div id="calendarWrapper" style="display: none;">
        <div class="calendar">
            <!-- 🔼 Navigatie -->
            <div class="calendar-header">
                <button id="prevMonth" type="button">&lt;</button>
                <div id="monthYear"></div>
                <button id="nextMonth" type="button">&gt;</button>
            </div>

            <!-- 📅 Weekdagen -->
            <div class="calendar-weekdays">
                <div>Ma</div><div>Di</div><div>Wo</div><div>Do</div><div>Vr</div><div style="color: red;">Za</div><div style="color: red;">Zo</div>
            </div>

            <!-- 📆 Dagen -->
            <div class="calendar-grid" id="calendarDays"></div>

            <button id="todayBtn" type="button">Vandaag</button>
        </div>

        <!-- 📆 Maand/Jaar selector -->
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
            <button id="goToDate" type="button">Ga</button>
        </div>
    </div>

    <!-- 🔍 Modal voor eventdetails -->
    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="event-modal" id="eventModal">
        <h3 id="eventTitle"></h3>
        <p id="eventTime"></p>
        <p id="eventLocation"></p>
        <p id="eventDescription"></p>
        <button onclick="closeEventModal()" id="button" type="button">Sluiten</button>
    </div>
</main>

<?php
if (function_exists('get_footer')) {
    get_footer();
} else {
    include 'footer.php';
}
?>