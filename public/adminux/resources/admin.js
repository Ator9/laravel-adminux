feather.replace();

function modalDelete(action, title) {
    $('#deleteForm').prop('action', action);
    $('#modalCenterTitle').html(title);
}

function setTitle(txt)
{
    if(txt) document.title = txt;
    else document.title = $('.text-white').html();
}

$('#partner_select').on('change', function () {
    location = admin_url+'/adminpartner?partner_id='+$(this).val();
});
