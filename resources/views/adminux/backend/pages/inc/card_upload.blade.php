<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Files</h5>
        <form method="post" action="{{ str_replace('/file-manager', '', Request::url()) }}/file-upload" enctype="multipart/form-data">
            <div class="input-group my-n1">
                <div class="custom-file">
                    <input type="file" name="files[]" class="custom-file-input" data-toggle="tooltip" data-placement="top" title="Max File: {{ ini_get('upload_max_filesize') }}, Max Form: {{ini_get('post_max_size')}}" id="inputGroupFileUpload" aria-describedby="inputGroupFileAddon" multiple required>
                    <label class="custom-file-label" for="inputGroupFileUpload">Files...</label>
                </div>
                <div class="input-group-append w-25">
                    <input type="text" name="replace_name" class="px-3 border" placeholder="Replace Name...">
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
    <div class="card-body p-0 pl-2">
        <table class="table table-hover m-0">
            <thead>
                <tr>
                    <td class="w-75">Link</td>
                    <td class="text-right">Size</td>
                    <td class="text-center">Date</td>
                    <td></td>
                </tr>
            </thead>
            @foreach($files as $value)
                @php
                    $name = substr($value, strrpos($value, '/') + 1);
                    $size = @$size + Storage::size($value);
                @endphp
                <tr>
                    <td><a href="{{ Storage::url($value) }}" target="_blank">{{ $name }}</a></td>
                    <td class="text-nowrap text-right">{{ round(Storage::size($value) / 1000, 2) }} KB</td>
                    <td class="text-nowrap">{{ date('Y-m-d H:i:s', Storage::lastModified($value)) }}</td>
                    <td>
                        <a href="#deleteModal" class="badge bg-danger" data-bs-toggle="modal" onclick="modalDelete('{{ str_replace('/file-manager', '', Request::url()) }}/file-delete', 'Delete {{ $name }}?', '{{ $name }}')">{{ __('adminux.delete') }}</a>
                    </td>
                </tr>
            @endforeach
                @if(!empty($size))
                <tr>
                    <td></td>
                    <td class="text-nowrap text-info text-right">Total: {{ round($size / 1000, 2) }} KB</td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
        </table>
    </div>
</div>
<style>
.table thead td{border-top-width:0;border-bottom-width:0}
</style>
