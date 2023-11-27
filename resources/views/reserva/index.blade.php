<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-10 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded" style="height: 90%;">
            <div id="calendar"></div>
        </div>
    </div>
    <!-- Incluir los archivos de FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var reservas = @json($reservas);
            var events = reservas.map(function(reserva) {
                return {
                    title: reserva.nombre, // Ajusta según el campo que deseas mostrar como título
                    start: reserva.fecha + ' ' + reserva.hora_inicio,
                    end: reserva.fecha + ' ' + reserva.hora_final
                };
            });
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },

                initialView: 'dayGridMonth',
                events: events,

            });
            calendar.setOption('locale', 'es');
            calendar.render();
        });
    </script>
</x-app-layout>