@if ($errors->any())
    <div class="alert alert-danger">
        {{ implode('\n', $errors->all()) }}
    </div>
@endif