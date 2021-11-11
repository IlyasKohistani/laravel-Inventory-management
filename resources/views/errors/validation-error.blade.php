@if ($errors->any())
<div class="alert alert-light-danger color-danger">
        <ul class="m-0 p-0" style="list-style: none">
            @foreach ($errors->all() as $error)
                <li><i class="bi bi-exclamation-circle"></i> {{ $error }}</li>
            @endforeach
        </ul>
</div>
@endif