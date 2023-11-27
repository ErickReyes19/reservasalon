<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-5">
                <form id="editAccesorio" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="Accesorio">Accesorio:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required value="{{$accesorio->nombre}}">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required value="{{$accesorio->descripcion}}">
                    </div>
                    <div class="form-group">
                        <label for="tipo_accesorios_id">Tipo accesorio:</label>
                        <select class="form-control" name="tipo_accesorios_id" id="tipo_accesorios_id">
                            @foreach ($tipoAccesorios as $tipoAccesorio)
                            <option value="{{ $tipoAccesorio->id }}" {{ $tipoAccesorio->id == $accesorio->tipo_accesorios_id ? 'selected' : '' }}>
                                {{ $tipoAccesorio->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estado" value="0">
                            <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" {{$accesorio->estado ? 'checked' : ''}}>
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
            $('#editAccesorio').submit(function(e) {
                e.preventDefault();

                // Obtén los datos del formulario
                var formData = $(this).serialize();

                // Realiza la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('accesorio.update', $accesorio->id) }}",
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('accesorio.index') }}";
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