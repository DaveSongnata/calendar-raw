const calendarE1 = document.getElementById("calendar");
const monthYearE1 = document.getElementById("monthYear");
const modalE1 = document.getElementById("eventModal");
let currentDate = new Date();

function renderCalendar(date = new Date()) {
    calendarE1.innerHTML = '';

    const year = date.getFullYear();
    const month = date.getMonth();
    const today = new Date();

    const totalDays = new Date(year, month + 1, 0).getDate();
    const firstDayOfMonth = new Date(year, month, 1).getDay();

    // Mostrar mês e ano
    monthYearE1.textContent = date.toLocaleDateString("pt-BR", {
        month: 'long',
        year: 'numeric'
    });

    const weekDays = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"];
    weekDays.forEach(day => {
        const dayE1 = document.createElement("div");
        dayE1.className = "day-name";
        dayE1.textContent = day;
        calendarE1.appendChild(dayE1);
    });

    // Espaços antes do primeiro dia do mês
    for (let i = 0; i < firstDayOfMonth; i++) {
        calendarE1.appendChild(document.createElement("div"));
    }

    // Loop dos dias do mês
    for (let day = 1; day <= totalDays; day++) {
        const dateStr = `${String(day).padStart(2, '0')}-${String(month + 1).padStart(2, '0')}-${year}`;
        const cell = document.createElement("div");
        cell.className = "day";

        // Marca o dia atual
        if (
            day === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear()
        ) {
            cell.classList.add("today");
        }

        const dateE1 = document.createElement("div");
        dateE1.className = "date-number";
        dateE1.textContent = day;
        cell.appendChild(dateE1);

        const eventToday = events.filter(e => e.date === dateStr);
        const eventBox = document.createElement("div");
        eventBox.className = "events";

        // Renderizar eventos do dia
        eventToday.forEach(event => {
            const ev = document.createElement("div");
            ev.className = "event";

            const courseE1 = document.createElement("div");
            courseE1.className = "course";
            courseE1.textContent = event.title.split(" - ")[0];

            const instructorE1 = document.createElement("div");
            instructorE1.className = "instructor";
            // Corrigido split para pegar índice 1 corretamente
            instructorE1.textContent = event.title.split(" - ")[1] || "";

            const timeE1 = document.createElement("div");
            timeE1.className = "time";
            // Corrigido concatenação de horários
            timeE1.textContent = `${event.start_time} - ${event.end_time}`;

            ev.appendChild(courseE1);
            ev.appendChild(instructorE1);
            ev.appendChild(timeE1);
            eventBox.appendChild(ev);
        });

        // Botões de sobreposição
        const overlay = document.createElement("div");
        overlay.className = "day-overlay";

        const addBtn = document.createElement("button");
        addBtn.className = "overlay-btn";
        addBtn.textContent = "+ Add";
        addBtn.onclick = e => {
            e.stopPropagation();
            openModalForAdd(dateStr);
        };
        overlay.appendChild(addBtn);

        if (eventToday.length > 0) {
            const editBtn = document.createElement("button");
            editBtn.className = "overlay-btn";
            editBtn.textContent = "Edit";
            editBtn.onclick = e => {
                e.stopPropagation();
                openModalForEdit(eventToday);
            };
            overlay.appendChild(editBtn);
        }

        cell.appendChild(overlay);
        cell.appendChild(eventBox);
        calendarE1.appendChild(cell);
    }
}

// Modal para adicionar evento
function openModalForAdd(dateStr) {
    document.getElementById("formAction").value = "add"; // Corrigido nome do input (formAction)
    document.getElementById("eventId").value = ""; // Corrigido id (eventId)
    document.getElementById("deleteEventId").value = "";
    document.getElementById("courseName").value = "";
    document.getElementById("instructorName").value = "";
    document.getElementById("startDate").value = dateStr;
    document.getElementById("endDate").value = dateStr;

    document.getElementById("startTime").value = "09:00";
    document.getElementById("endTime").value = "10:00";

    const selector = document.getElementById("eventSelector");
    const wrapper = document.getElementById("eventSelectorWrapper");
    if (selector && wrapper) {
        selector.innerHTML = "";
        wrapper.style.display = "none";
    }

    modalE1.style.display = "flex";
}

// Modal para editar eventos
function openModalForEdit(eventsOnDate) {
    document.getElementById("formAction").value = "edit";
    modalE1.style.display = "flex";

    const selector = document.getElementById("eventSelector");
    const wrapper = document.getElementById("eventSelectorWrapper");
    selector.innerHTML = '<option disabled selected>Selecione um Evento...</option>';

    eventsOnDate.forEach(e => {
        const option = document.createElement("option");
        option.value = JSON.stringify(e);
        option.textContent = `${e.title} (${e.start_date} -> ${e.end_date})`;
        selector.appendChild(option);
    });

    if (eventsOnDate.length > 1) {
        wrapper.style.display = "block";
    } else {
        wrapper.style.display = "none";
    }

    handleEventSelection(JSON.stringify(eventsOnDate[0]));
}

// Handle seleção de evento no select do modal
function handleEventSelection(eventJson) {
    const event = JSON.parse(eventJson); // Corrigido JSON.parse (maiúsculo)
    document.getElementById("eventId").value = event.id;
    document.getElementById("deleteEventId").value = event.id;

    const [course, instructor] = event.title.split(" - ").map(e => e.trim());
    document.getElementById("courseName").value = course || "";
    document.getElementById("instructorName").value = instructor || "";
    document.getElementById("startDate").value = event.start_date || "";
    document.getElementById("endDate").value = event.end_date || "";
    document.getElementById("startTime").value = event.start_time || "";
    document.getElementById("endTime").value = event.end_time || "";
}

function closeModal() {
    modalE1.style.display = "none";
}

// Navegação entre meses
function changeMonth(offset) {
    currentDate.setMonth(currentDate.getMonth() + offset); // Corrigido método setMonth
    renderCalendar(currentDate);
}

function updateClock() {
    const now = new Date();
    const clock = document.getElementById("clock");

    clock.textContent = [
        now.getHours().toString().padStart(2, "0"),
        now.getMinutes().toString().padStart(2, "0"),
        now.getSeconds().toString().padStart(2, "0"),
    ].join(":");
}

// Inicializações
renderCalendar(currentDate);
updateClock();
setInterval(updateClock, 1000);
