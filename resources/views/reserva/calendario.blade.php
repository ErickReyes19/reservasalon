<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-10 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded" style="height: 100%;">
            <div class="col-12 mb-5" style="text-align: end">
                <a href="{{ route('reserva.create') }}">
                    <button class="btn btn-dark"><i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                        Nueva Reserva
                    </button></a>
            </div>
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
                    id: reserva.id,
                    title: reserva.nombre,
                    start: reserva.fecha + ' ' + reserva.hora_inicio,
                    end: reserva.fecha + ' ' + reserva.hora_final,
                    description: reserva.descripcion
                };
            });

            



            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                selectable: true,
                initialView: 'dayGridMonth',
                events: events,


                eventClick: (info) => {

                    var url = "{{ route('reserva.show', ':id') }}";
                    url = url.replace(':id', info.event.id);

                    window.location.href = url;

                }
            });

            calendar.setOption('locale', 'es');
            calendar.render();
        });
    </script>
</x-app-layout>