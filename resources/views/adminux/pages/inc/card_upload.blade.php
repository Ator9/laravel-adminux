<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Files</h5>
        <button type="button" class="btn btn-primary btn-sm my-n1" onclick="modalUpload('{{ Request::url() }}', 'Upload Files #{{ $model->id }}')" data-toggle="modal" data-target="#uploadModal">
            <span class="feather-adminux" data-feather="upload"></span> Upload
        </button>
    </div>
    <div class="card-body">
        3
    </div>
</div>
