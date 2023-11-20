<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-2">
                <p class="fs-2">Crear Set</p>
                <form id="crearSet" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="competencia">Nombre Set:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="competencia">Descripcion:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-dark">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#crearSet').submit(function(e) {
                e.preventDefault();

                // Obtén los datos del formulario
                var formData = $(this).serialize();

                // Realiza la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('set.store') }}", // Asegúrate de que la ruta sea correcta
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('set.index') }}";
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
                                window.location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>


</x-app-layout>