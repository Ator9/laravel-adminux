feather.replace();

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function modalDelete(action, title, name) {
    $('#deleteForm').prop('action', action);
    $('#deleteName').val(name);
    $('#deleteModalCenterTitle').html(title);
}

function setTitle(txt) {
    if(txt) document.title = txt;
    // else document.title = $('ul ul a.active').text().replace('─', '');
    else document.title = $('.text-white').html();
}

$('#partner_select').on('change', function () {
    location = admin_url+'/adminpartner?partner_id='+$(this).val();
});

$('.continue_editing_form').on('click', function () {
    $(this).append('<input type="hidden" name="continue_editing_form" value="1">');
});

// Update selected files in input:
$('#inputGroupFileUpload').on('change',function() {
    $(this).next('.custom-file-label').html($(this).val());
});
