<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Files</h5>
        <form method="post" action="{{ Request::url() }}/file-upload" enctype="multipart/form-data">
            <div class="input-group my-n1">
                <div class="custom-file">
                    <input type="file" name="files[]" class="custom-file-input" id="inputGroupFileUpload" aria-describedby="inputGroupFileAddon" multiple required>
                    <label class="custom-file-label" for="inputGroupFileUpload">Files...</label>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="submit" id="inputGroupFileAddon">
                        <span class="feather-adminux" data-feather="upload"></span> Upload
                    </button>
                </div>
            </div>
            @csrf
        </form>
    </div>
    <div class="card-body py-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>URL</td>
                    <td>Date</td>
                </tr>
            </thead>
            @foreach($files as $value)
                <tr>
                    <td>{{ substr($value, strrpos($value, '/') + 1) }}</td>
                    <td><a href="{{ url(str_replace('public', '', $value)) }}" target="_blank">{{ $value }}</a></td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<style>
.table thead td{border-top-width:0;border-bottom-width:0}
</style>
