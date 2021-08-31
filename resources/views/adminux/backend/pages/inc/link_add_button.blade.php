<form method="post" action="{{ $params['action'] }}">
    @csrf
    <input type="hidden" name="table" value="{{ $params['table'] }}">
    <input type="hidden" name="id" value="{{ $params['id'] }}">
    <input type="hidden" name="related_id" value="{{ $params['related_id'] }}">
    <button type="submit" class="btn btn-primary badge rounded-pill bg-primary">{{ __('adminux.add') }}</button>
</form>
