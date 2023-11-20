<x-app-layout>
    <div class="row justify-content-center ">
        <div class="col-md-6 bg-white my-4 py-4 shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="container mt-2">
                <p class="fs-2">Actualizar Extra</p>
                <form id="editExtra" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="competencia">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required value="{{$extra->nombre}}">
                    </div>
                    <div class="form-group">
                        <label for="competencia">Descripcion:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required value="{{$extra->descripcion}}">
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="estado" value="0"> <!-- Campo oculto con valor predeterminado de 0 -->
                            <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" {{$extra->estado ? 'checked' : ''}}>
                            <label class="form-check-label" for="estado">Estado</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="disponible" value="0"> <!-- Campo oculto con valor predeterminado de 0 -->
                            <input class="form-check-input" type="checkbox" id="disponible" name="disponible" value="1" {{$extra->estado ? 'checked' : ''}}>
                            <label class="form-check-label" for="disponible">Disponible</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-dark">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</x-app-layout>