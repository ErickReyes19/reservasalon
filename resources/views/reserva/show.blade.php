<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-10 bg-white shadow p-3 my-4 bg-body-tertiary rounded" style="height: 100%;">
            <div class="col-12 row">

                <h1 class="col-md-12"> Detalles de Reserva - {{ $reserva->users->name }}</h1>

                <label> Nombre: {{$reserva->nombre}}</label>
                <label> Descripcion: {{$reserva->descripcion}}</label>
                <label>Fecha: {{ \Carbon\Carbon::parse($reserva->fecha)->locale('es')->isoFormat('LL') }}</label>
                <label>Hora de inicio: {{ \Carbon\Carbon::parse($reserva->hora_inicio)->locale('es')->format('h:i A') }}</label>
                <label>Hora de finalización: {{ \Carbon\Carbon::parse($reserva->hora_final)->locale('es')->format('h:i A') }}</label>
            </div>
        </div>
        <div class="col-md-10 bg-white shadow p-3 my-4 bg-body-tertiary rounded" style="height: 100%;">
            <h1>Equipo</h1>

            <table id="tableEquipo" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Propietario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->equipos as $equipo)
                    <tr>
                        <td>{{$equipo->nombre}}</td>
                        <td>{{$equipo->descripcion}}</td>
                        <td>{{$equipo->usuario->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-10 bg-white shadow p-3 my-4 bg-body-tertiary rounded" style="height: 100%;">
            <h1>Sets</h1>

            <table id="tableSets" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->sets as $set)
                    <tr>
                        <td>{{$set->nombre}}</td>
                        <td>{{$set->descripcion}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-10 bg-white shadow p-3 my-4 bg-body-tertiary rounded" style="height: 100%;">
            <h1>Extras</h1>

            <table id="tableExtras" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->extras as $extra)
                    <tr>
                        <td>{{$extra->nombre}}</td>
                        <td>{{$extra->descripcion}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-5 bg-white shadow p-3 m-4 bg-body-tertiary rounded" style="height: 100%;">
            <h1>Asistentes</h1>

            <table id="tableAsistentes" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->asistentes as $asistente)
                    <tr>
                        <td>{{$asistente->nombre}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-5 bg-white shadow p-3 m-4 bg-body-tertiary rounded" style="height: 100%;">
            <h1>Usuarios</h1>

            <table id="tableUsuarios" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reserva->usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready(function() {
                let table = new DataTable('#tableEquipo');
                let tableSets = new DataTable('#tableSets');
                let tableExtras = new DataTable('#tableExtras');
                let tableAsistentes = new DataTable('#tableAsistentes');
                let tableUsuarios = new DataTable('#tableUsuarios');
            });
        </script>

</x-app-layout>