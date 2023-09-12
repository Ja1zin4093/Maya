const prevButton = document.getElementById("prevMonth");
const nextButton = document.getElementById("nextMonth");
const monthYear = document.getElementById("monthYear");
const daysContainer = document.querySelector(".days");
const scheduleTimeButton = document.getElementById("scheduleTime");
const selectProfessional = document.getElementById("selectProfessional");
const selectService = document.getElementById("selectService");
const selectTimeSlot = document.getElementById("selectTimeSlot");
const selectDate = document.getElementById("selectDate");

let currentDate = new Date();
let appointments = {}; // Armazena os agendamentos

const timeSlots = [
    "09:00 - 10:00",
    "10:00 - 11:00",
    "11:00 - 12:00",
    // Adicione mais horários disponíveis conforme necessário
];

function renderCalendar() {
    const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    const daysInMonth = lastDayOfMonth.getDate();
    const startDayOfWeek = firstDayOfMonth.getDay(); // Dia da semana do primeiro dia do mês
    const endDayOfWeek = lastDayOfMonth.getDay(); // Dia da semana do último dia do mês
    const lastDayPrevMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
    const lastDayCurrMonth = daysInMonth;

    monthYear.textContent = `${currentDate.toLocaleString("default", { month: "long" })} ${currentDate.getFullYear()}`;

    daysContainer.innerHTML = "";

    // Preencher os dias restantes do mês anterior
    for (let i = startDayOfWeek; i > 0; i--) {
        const dayElement = createDayElement(lastDayPrevMonth - i + 1, true);
        daysContainer.appendChild(dayElement);
    }

    // Preencher os dias do mês atual
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = createDayElement(day);
        daysContainer.appendChild(dayElement);
    }

    // Preencher os dias do próximo mês
    for (let i = 1; i <= 6 - endDayOfWeek; i++) {
        const dayElement = createDayElement(i, true);
        daysContainer.appendChild(dayElement);
    }
}

function createDayElement(day, isDisabled = false) {
    const dayElement = document.createElement("div");
    dayElement.textContent = day;
    dayElement.classList.add("day");

    const currentDateYear = currentDate.getFullYear();
    const currentDateMonth = currentDate.getMonth();
    const today = new Date();
    const todayYear = today.getFullYear();
    const todayMonth = today.getMonth();
    const todayDate = today.getDate();

    if (isDisabled) {
        dayElement.classList.add("disabled");
    } else {
        dayElement.addEventListener("click", () => {
            if (!dayElement.classList.contains("event") && !dayElement.classList.contains("disabled")) {
                selectDate.value = new Date(currentDateYear, currentDateMonth, day).toISOString().split("T")[0];
            }
        });

        if (
            (currentDateYear === todayYear && currentDateMonth === todayMonth && day <= todayDate) ||
            (currentDateYear < todayYear || (currentDateYear === todayYear && currentDateMonth < todayMonth))
        ) {
            dayElement.classList.add("disabled");
        }

        if (day === todayDate && currentDateMonth === todayMonth && currentDateYear === todayYear) {
            dayElement.classList.add("today");
        }
    }

    if (new Date(currentDateYear, currentDateMonth, day).getDay() === 0) {
        dayElement.classList.add("sunday");
    }

    return dayElement;
}

prevButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

scheduleTimeButton.addEventListener("click", () => {
    const selectedDate = selectDate.value;
    const selectedTimeSlot = selectTimeSlot.value;
    const selectedProfessional = selectProfessional.value;
    const selectedService = selectService.value;

    if (selectedDate && selectedTimeSlot && selectedProfessional && selectedService) {
        const day = new Date(selectedDate).getDate();
        appointments[day] = {
            date: selectedDate,
            timeSlot: selectedTimeSlot,
            professional: selectedProfessional,
            service: selectedService
        };
        renderAppointments();
    }
});

// Função para renderizar os agendamentos
function renderAppointments() {
    const eventElements = document.querySelectorAll(".event");
    eventElements.forEach(element => {
        element.classList.remove("event");
    });

    for (const day in appointments) {
        const dayElement = document.querySelector(`.day:not(.empty-day):not(.disabled):not(.sunday):not(.today)[data-day="${day}"]`);
        if (dayElement) {
            dayElement.classList.add("event");
        }
    }
}

// Preencher as opções de horários disponíveis
timeSlots.forEach(slot => {
    const option = document.createElement("option");
    option.textContent = slot;
    selectTimeSlot.appendChild(option);
});

renderCalendar();