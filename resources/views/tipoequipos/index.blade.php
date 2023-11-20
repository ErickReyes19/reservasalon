<x-app-layout>
    <div class="container my-5 bg-light shadow p-3 mb-5 bg-body-tertiary rounded" style="border-radius: 15px; height: 100%">

        <div class="container py-5 px-5 ">
            <div class="row">
                <div class="col-12 mb-5" style="text-align: end">
                    <a href="{{ route('tipoequipo.create') }}">
                        <button class="btn btn-dark"><i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                            Nuevo tipo equipo
                        </button></a>
                </div>
            </div>
            <table id="table" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th style="text-align: end">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipoequipos as $tipoequipo)
                    <tr>
                        <td>{{ $tipoequipo->nombre }}</td>
                        <td>
                            @if($tipoequipo->estado == 1)
                            Activo
                            @else
                            Inactivo
                            @endif
                        </td>

                        <td style="text-align: end">
                            <a href="{{ route('tipoequipo.edit', $tipoequipo->id) }}"><button class="btn btn-dark"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button></a>
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

            $('.btn-eliminar').on('click', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: "Desactivar",
                    text: "¿Desea continuar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar",
                    customClass: {
                        confirmButton: 'btn btn-dark mx-2',
                        cancelButton: 'btn btn-secondary mx-2'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('tipoequipo.desactive', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({
                            type: 'get',
                            url: url,
                            success: function(response) {
                                Swal.fire(
                                    'Acción Exitosa',
                                    'La acción se realizó con éxito.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('tipoequipo.index') }}";
                                    }
                                });

                            },
                            error: function(xhr) {
                                // Maneja los errores de validación u otros errores
                                var errors = xhr.responseJSON;
                                Swal.fire(
                                    'Error',
                                    'No se pudo realizar la acción.',
                                    'error'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('tipoequipo.index') }}";
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>