<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 shadow p-3 mb-5 bg-body-tertiary rounded my-4">
            <div class="container mt-5">
                <form id="editTipoEquipo" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="competencia">Tipo Equipo:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{$tipoEquipo->nombre}}">
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estado" value="0"> <!-- Campo oculto con valor predeterminado de 0 -->
                            <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" {{$tipoEquipo->estado ? 'checked' : ''}}>
                            <label class="form-check-label" for="estado">Estado</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-dark">Actualizar</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editTipoEquipo').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('tipoequipo.update', $tipoEquipo->id) }}",
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('tipoequipo.index') }}";
                            }
                        });

                    },
                    error: function(xhr) {
                        // Maneja los errores de validación u otros errores
                        var errors = xhr.responseJSON;
                        console.log(xhr);
                        Swal.fire(
                            'Error',
                            'No se pudo realizar la acción.',
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>


</x-app-layout>