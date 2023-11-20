<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-2">
                <div class="row">
                    <p class="fs-2 col-md-5">Crear Reserva</p>
                    <div id="mensaje" style="display:none;" class="alert p-4 col-md-7" role="alert"></div>
                </div>
                <form id="validarReserva" method="post" class="row">
                    @csrf
                    <div class="form-group col-md-4">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_inicio">Hora de Inicio:</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_final">Hora de Fin:</label>
                        <input type="time" class="form-control" id="hora_final" name="hora_final" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="button" class="btn btn-dark" onclick="validarDisponibilidad()">Validar Reserva</button>
                    </div>

                    <div id="camposReserva" style="display:none;">

                        <div class="form-group col-md-12">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="descripcion">Descripcion:</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <!-- Aquí se agregarán dinámicamente los checkboxes -->
                        <div class="border rounded p-4 shadow m-4">

                            <h4>Equipos:</h4>
                            <input type="text" id="searchEquipos" class="form-control mb-2" placeholder="Buscar Equipos">
                            <div class="checkbox-list d-flex flex-wrap p-4" id="equipos-list">
                                <!-- Aquí se agregarán los checkboxes de Equipos -->
                            </div>
                        </div>
                        <div class="border rounded p-4 shadow m-4">

                            <h4>Sets:</h4>
                            <input type="text" id="searchSets" class="form-control mb-2" placeholder="Buscar Sets">
                            <div class="checkbox-list d-flex flex-wrap p-4" id="sets-list">
                                <!-- Aquí se agregarán los checkboxes de Sets -->
                            </div>
                        </div>
                        <div class="border rounded p-4 shadow m-4">

                            <h4>Extras:</h4>
                            <input type="text" id="searchExtras" class="form-control mb-2" placeholder="Buscar Extras">
                            <div class="checkbox-list d-flex flex-wrap p-4" id="extras-list">
                                <!-- Aquí se agregarán los checkboxes de Extras -->
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-dark">Crear</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#validarReserva').submit(function(e) {
                e.preventDefault();
                // Obtén los datos del formulario
                var formData = $(this).serialize();

                // Realiza la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('reserva.store') }}", // Asegúrate de que la ruta sea correcta
                    data: formData,
                    success: function(response) {
                        Swal.fire(
                            'Acción Exitosa',
                            'La acción se realizó con éxito.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('extra.index') }}";
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




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el elemento de entrada de fecha
            var inputFecha = document.getElementById("fecha");

            // Obtener la fecha y hora actuales
            var fechaActual = new Date();

            // Establecer la zona horaria a GMT-6 (Honduras)
            fechaActual.setUTCHours(fechaActual.getUTCHours());

            // Formatear la fecha como YYYY-MM-DD
            // Formatear la fecha como YYYY-MM-DD
            var fechaFormateada = fechaActual.toISOString().split('T')[0];

            // Reducir 6 horas a la fecha formateada
            var fechaReducida = new Date(fechaFormateada);
            fechaReducida.setHours(fechaReducida.getHours() - 6);

            // Obtener la fecha y hora formateadas después de reducir 6 horas
            var fechaFormateadaReducida = fechaReducida.toISOString().split('T')[0];


            // Formatear la hora como HH:mm
            var horas = fechaActual.getHours().toString().padStart(2, '0');
            var minutos = fechaActual.getMinutes().toString().padStart(2, '0');
            var horaFormateada = horas + ':' + minutos;
            console.log(fechaActual)
            // Establecer la fecha y la hora formateadas en los campos respectivos
            inputFecha.value = fechaFormateadaReducida;
            document.getElementById("hora_inicio").value = horaFormateada;
            document.getElementById("hora_final").value = horaFormateada;
        });
    </script>





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function validarDisponibilidad() {
            var fecha = $("#fecha").val();
            var horaInicio = $("#hora_inicio").val();
            var horaFin = $("#hora_final").val();

            $.ajax({
                type: "GET",
                url: "{{ route('reserva.validarReserva') }}",
                data: {
                    fecha: fecha,
                    hora_inicio: horaInicio,
                    hora_final: horaFin
                },
                success: function(response) {
                    var mensajeDiv = $("#mensaje");

                    mensajeDiv.removeClass("alert-danger").addClass("alert-success");
                    mensajeDiv.text(response.message);
                    $("#camposReserva").show();
                    $("#mensaje").show();

                    // Generar dinámicamente los checkboxes y agregarlos al div camposReserva
                    generarCheckboxes("equipos-list", response.equipos, "equipos[]");
                    generarCheckboxes("sets-list", response.sets, "sets[]");
                    generarCheckboxes("extras-list", response.extras, "extras[]");

                    setTimeout(function() {
                        mensajeDiv.hide();
                    }, 3000);
                },

                error: function(xhr) {
                    var mensajeDiv = $("#mensaje");

                    if (xhr.status === 404) {
                        mensajeDiv.removeClass("alert-success").addClass("alert-danger");
                        mensajeDiv.text(xhr.responseJSON.message);


                        // Ocultar el formulario en caso de conflicto
                        $("#camposReserva").hide();
                        $("#mensaje").show();

                        // Establecer un temporizador para volver a mostrar el formulario después de 3 segundos
                        setTimeout(function() {
                            mensajeDiv.hide();
                        }, 3000);
                    } else {
                        mensajeDiv.removeClass("alert-success").addClass("alert-danger");
                        mensajeDiv.text('Error al validar la disponibilidad. Inténtalo de nuevo.');
                        $("#camposReserva").hide();
                        $("#mensaje").show();

                        // Establecer un temporizador para volver a mostrar el formulario después de 3 segundos
                        setTimeout(function() {
                            mensajeDiv.hide();
                        }, 3000);
                    }
                }
            });
        }

        function generarCheckboxes(containerId, items, name) {
            var container = $("#" + containerId);
            container.empty();
            $.each(items, function(index, item) {
                container.append(`
                    <div class="custom-control custom-checkbox mr-3 mb-3 col-md-4">
                        <input type="checkbox" class="custom-control-input" id="${name}-${index}" name="${name}" value="${item.id}">
                        <label class="custom-control-label" for="${name}-${index}">${item.nombre}</label>
                    </div>
                `);
            });
        }

        // Agregar funciones para manejar la búsqueda
        $("#searchEquipos").on("input", function() {
            filtrarCheckboxes("equipos-list", this.value);
        });

        $("#searchSets").on("input", function() {
            filtrarCheckboxes("sets-list", this.value);
        });

        $("#searchExtras").on("input", function() {
            filtrarCheckboxes("extras-list", this.value);
        });

        function filtrarCheckboxes(containerId, filtro) {
            $("#" + containerId + " .custom-control-label").each(function() {
                var label = $(this);
                var labelText = label.text().toLowerCase();
                if (labelText.includes(filtro.toLowerCase())) {
                    label.parent().show();
                } else {
                    label.parent().hide();
                }
            });
        }
    </script>
</x-app-layout>