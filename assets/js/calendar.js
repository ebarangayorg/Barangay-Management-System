document.addEventListener("DOMContentLoaded", () => {
  const monthYear = document.getElementById("month-year");
  const calendarGrid = document.getElementById("calendar-grid");
  const prevBtn = document.getElementById("prev-month");
  const nextBtn = document.getElementById("next-month");

  let today = new Date();
  let currentMonth = today.getMonth();
  let currentYear = today.getFullYear();
  let calendarEvents = []; // NEW: holds events fetched from backend

  // FETCH EVENTS FROM BACKEND
  async function fetchCalendarEvents() {
    try {
      const res = await fetch("../../backend/calendar_events.php");
      calendarEvents = await res.json();
    } catch (error) {
      console.error("Error fetching events:", error);
      calendarEvents = [];
    }
  }

  function renderCalendar(month, year) {
    calendarGrid.innerHTML = "";

    const monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];

    const weekdayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    monthYear.textContent = `${monthNames[month]} ${year}`;

    // Render weekdays
    weekdayNames.forEach(day => {
      let w = document.createElement("div");
      w.textContent = day;
      w.style.fontWeight = "bold";
      w.style.textAlign = "center";
      calendarGrid.appendChild(w);
    });

    let firstDay = new Date(year, month).getDay();
    let daysInMonth = new Date(year, month + 1, 0).getDate();

    // Render blank days
    for (let i = 0; i < firstDay; i++) {
      let blank = document.createElement("div");
      blank.classList.add("calendar-day");
      blank.style.visibility = "hidden";
      calendarGrid.appendChild(blank);
    }

    // Render days with events
    for (let day = 1; day <= daysInMonth; day++) {
      let dayDiv = document.createElement("div");
      dayDiv.classList.add("calendar-day");
      dayDiv.textContent = day;

      // Highlight today
      if (
        day === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear()
      ) {
        dayDiv.classList.add("active");
      }

      // Check if there is an event on this day
      const fullDate = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
      const eventToday = calendarEvents.find(event => event.date === fullDate);

      if (eventToday) {
        dayDiv.classList.add("event");
        dayDiv.title = eventToday.title;
      }

      calendarGrid.appendChild(dayDiv);
    }
  }

  prevBtn.addEventListener("click", () => {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    renderCalendar(currentMonth, currentYear);
  });

  nextBtn.addEventListener("click", () => {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    renderCalendar(currentMonth, currentYear);
  });

  // INIT: fetch events first, then render calendar
  fetchCalendarEvents().then(() => {
    renderCalendar(currentMonth, currentYear);
  });
});
