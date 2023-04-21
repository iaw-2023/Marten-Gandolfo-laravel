<form action="{{$action}}" method="POST">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input id="name" name="name" type="text" class="form-control" tabindex="1" maxlength="255" value="{{ $name ?? '' }}" required>
    </div>
    <a href="/categories" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>
</form>