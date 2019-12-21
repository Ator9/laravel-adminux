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
    <div class="card-body">
        {{ print_r($files) }}
    </div>
</div>
