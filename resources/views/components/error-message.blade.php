@if ($errors->any())
    <div class="alert alert-danger">
        {!! implode('<br>', $errors->all()) !!}
    </div>
@endif