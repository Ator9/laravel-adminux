@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-3 mb-0" role="alert">
        @foreach($errors->all() as $error)
            &bull; {{ $error }}<br>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
