@section('title', "Registrar Conductor")

@section('content')
    <h1>Crear usuario</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <h6>Por favor corrige los errores debajo:</h6>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ url('drivers') }}">
        {{ csrf_field() }}

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" placeholder="Pedro" value="{{ old('name') }}">
        <br>
        <label for="last_name">Apellido:</label>
        <input type="text" name="last_name" id="last_name" placeholder="Perez" value="{{ old('last_name') }}">
        <br>
        <label for="document">DNI:</label>
        <input type="text" name="document" id="document" placeholder="Mayor a 6 caracteres">
        <br>
        <button type="submit">Crear usuario</button>
    </form>

    <p>
        <a href="{{ route('driver.index') }}">Regresar al listado de usuarios</a>
    </p>
