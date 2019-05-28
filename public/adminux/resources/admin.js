feather.replace();

function modalDelete(action, title) {
    $('#deleteForm').prop('action', action);
    $('#modalCenterTitle').html(title);
}

$('#partner_select').on('change', function () {
    location = admin_url+'/adminpartner?partner_id='+$(this).val();
});
