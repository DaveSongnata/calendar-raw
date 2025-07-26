<?php include "calendar.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MasterCrono</title>
    <meta name="description" content="MasterCrono - Gerenciador de Tarefas e Cronograma de Estudos" />
    <link rel="stylesheet" href="/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
</head>

<body>

    <header>
        <h1>MasterCrono</h1>
        <br />Meu Calendário<br />
    </header>

    <!-- Relógio -->
    <div class="clock-container">
        <div id="clock"></div>
    </div>

    <!-- Calendário -->
    <div class="calendar">
        <div class="nav-btn-container">
            <button class="nav-btn" onclick="changeMonth(-1)">&lt;</button>
            <h2 id="monthYear" style="margin: 0"></h2>
            <button class="nav-btn" onclick="changeMonth(1)">&gt;</button>
        </div>
        <!-- Corrigido 'clendar-grid' para 'calendar-grid' -->
        <div class="calendar-grid" id="calendar"></div>
    </div>

    <!-- Modal para CRUD -->
    <div class="modal" id="eventModal">
        <div class="modal-content">

            <div id="eventSelectorWrapper" style="display:none;">
                <label for="eventSelector"><strong>Selecione um Evento:</strong></label>
                <select id="eventSelector" onchange="handleEventSelection(this.value)">
                    <option disabled selected>Selecione</option>
                </select>
            </div>

            <!-- Main Form -->
            <form method="POST" id="eventForm">
                <input type="hidden" name="action" id="formAction" value="add" />
                <input type="hidden" name="event_id" id="eventId" />

                <label for="courseName">Título do curso:</label>
                <input type="text" name="course_name" id="courseName" required />

                <label for="instructorName">Professor:</label>
                <input type="text" name="instructor_name" id="instructorName" required />

                <label for="startDate">Data de Início:</label>
                <input type="date" name="start_date" id="startDate" required />

                <label for="endDate">Data Final:</label>
                <input type="date" name="end_date" id="endDate" required />

                <label for="startTime">Hora Inicial:</label>
                <input type="time" name="start_time" id="startTime" required />

                <label for="endTime">Hora Final:</label>
                <input type="time" name="end_time" id="endTime" required />

                <button type="submit">Enviar</button>
            </form>

            <!-- Delete Formulário -->
            <form method="POST" onsubmit="return confirm('Vai mesmo me deletar? :/')">
                <input type="hidden" name="action" value="delete" />
                <input type="hidden" name="event_id" id="deleteEventId" />
                <button type="submit" class="submit-btn">Deletar</button>
            </form>

            <!-- Cancelar -->
            <button type="button" class="submit-btn" onclick="closeModal()">Cancelar</button>

        </div>
    </div>

    <script>
        const events = <?= json_encode($eventsFromDB, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="calendar.js"></script>

</body>

</html>
