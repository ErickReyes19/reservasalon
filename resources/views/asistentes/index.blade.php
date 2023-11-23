<x-app-layout>
    <div class="container my-5 bg-light shadow p-3 mb-5 bg-body-tertiary rounded" style="border-radius: 15px; height: 100%">

        <div class="container py-5 px-5 ">
            <div class="row">
                <div class="col-12 mb-5" style="text-align: end">
                    <a href="{{ route('asistente.create') }}">
                        <button class="btn btn-dark">
                            <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i> Nuevo asistente
                        </button>
                    </a>
                </div>
            </div>
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                // Remover el banner después de 3 segundos
                setTimeout(function(){
                    $('.alert').alert('close');
                }, 3000);
            </script>
            @endif
            
            <table id="table" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th style="text-align: end">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asistentes as $asistente)
                    <tr>
                        <td>{{ $asistente->nombre }}</td>
                        <td>
                            @if($asistente->estado == 1)
                            Activo
                            @else
                            Inactivo
                            @endif
                        </td>
                        <td style="text-align: end">
                            <a href="{{ route('asistente.edit', $asistente->id) }}">
                                <button class="btn btn-dark">
                                    <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let table = new DataTable('#table');
        });
    </script>
</x-app-layout>
