<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <main class="container my-4">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title h4">Vehículos registrados</h1>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoVehiculo">
            Nuevo vehículo
          </button>

          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Placa</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Tipo</th>
                  <th>Color</th>
                  <th>Capacidad</th>
                  <th>Precio/día</th>
                  <th>Estado</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($vehicles as $vehicle)
                  <tr>
                    <th scope="row">{{ $vehicle->id }}</th>
                    <td>{{ $vehicle->plate_number }}</td>
                    <td>{{ $vehicle->brand }}</td>
                    <td>{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->vehicle_type }}</td>
                    <td>{{ $vehicle->color }}</td>
                    <td>{{ $vehicle->capacity }}</td>
                    <td>${{ number_format($vehicle->daily_rate, 2) }}</td>
                    <td>{{ $vehicle->status }}</td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $vehicle->id }}">
                        Editar
                      </button>

                      <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este vehículo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="10" class="text-center">No hay vehículos registrados.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <div class="modal fade" id="modalNuevoVehiculo" tabindex="-1" aria-labelledby="modalNuevoVehiculoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNuevoVehiculoLabel">Nuevo vehículo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('vehicles.store') }}" method="POST">
              @csrf
              <input class="form-control mb-2" type="text" name="plate_number" placeholder="Placa" maxlength="15" required>
              <input class="form-control mb-2" type="text" name="brand" placeholder="Marca" maxlength="50" required>
              <input class="form-control mb-2" type="text" name="model" placeholder="Modelo" maxlength="80" required>
              <input class="form-control mb-2" type="text" name="vehicle_type" placeholder="Tipo de vehículo" maxlength="50" required>
              <input class="form-control mb-2" type="text" name="color" placeholder="Color" maxlength="30" required>
              <input class="form-control mb-2" type="number" name="capacity" placeholder="Capacidad" min="1" required>
              <input class="form-control mb-2" type="number" step="0.01" min="0" name="daily_rate" placeholder="Precio por día" required>
              <select class="form-select mb-2" name="status" required>
                <option value="Disponible">Disponible</option>
                <option value="No disponible">No disponible</option>
              </select>
              <button type="submit" class="btn btn-success">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @foreach ($vehicles as $vehicle)
      <div class="modal fade" id="modalEditar{{ $vehicle->id }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $vehicle->id }}" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditarLabel{{ $vehicle->id }}">Editar vehículo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input class="form-control mb-2" type="text" name="plate_number" value="{{ $vehicle->plate_number }}" maxlength="15" required>
                <input class="form-control mb-2" type="text" name="brand" value="{{ $vehicle->brand }}" maxlength="50" required>
                <input class="form-control mb-2" type="text" name="model" value="{{ $vehicle->model }}" maxlength="80" required>
                <input class="form-control mb-2" type="text" name="vehicle_type" value="{{ $vehicle->vehicle_type }}" maxlength="50" required>
                <input class="form-control mb-2" type="text" name="color" value="{{ $vehicle->color }}" maxlength="30" required>
                <input class="form-control mb-2" type="number" name="capacity" value="{{ $vehicle->capacity }}" min="1" required>
                <input class="form-control mb-2" type="number" step="0.01" min="0" name="daily_rate" value="{{ $vehicle->daily_rate }}" required>
                <select class="form-select mb-2" name="status" required>
                  <option value="Disponible" @selected($vehicle->status === 'Disponible')>Disponible</option>
                  <option value="No disponible" @selected($vehicle->status === 'No disponible')>No disponible</option>
                </select>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>