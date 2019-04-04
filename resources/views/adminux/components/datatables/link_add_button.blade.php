<form method="post" action="{{ $params['action'] }}">
    @csrf
    <button type="submit" class="btn btn-primary badge badge-pill badge-primary">{{ __('adminux.add') }}</button>
    <input type="hidden" name="id" value="{{ $params['id'] }}">
    <input type="hidden" name="related" value="{{ $params['related_id'] }}">
</form>
