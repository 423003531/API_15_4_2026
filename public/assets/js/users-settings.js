$(document).ready(function() {
    $(".btnAdd").click(function() {
        $('#formUserModalLabel').html('Create New User');
        $('.modal-footer button[type=submit]').html('Save Role');
        $('#userID').val('');
        $('#inputFullname').val('');
        $('#inputUsername').val('');
        $('#inputRole').val('');
    });
    $(".btnEdit").click(function() {
        const userId = $(this).data('id');
        const fullname = $(this).data('fullname');
        const username = $(this).data('username');
        const role = $(this).data('role');
        $('#modalTitle').html('form Data User');
        $('.modal-footer button[type=submit]').html('Update User');
        $('.modal-content form').attr('action', baseUrl + 'users/update-user');
        $('#userID').val(userId);
        $('#inputFullname').val(fullname);
        $('#inputUsername').val(username);
        $('#inputUsername').attr('readonly', true);
        $('#inputPassword').attr('required', false);
        $('#inputRole').val(role);
    });

    $(".btnAddRole").click(function() {
        $('#formUserModalLabel').html('Create New Role');
        $('.modal-content form').attr('action', baseUrl + 'users/create-role');
        $('.modal-footer button[type=submit]').html('Save Role');
        $('#roleID').val('');
        $('#inputRoleName').val('');
    });
    $(".btnEditRole").click(function() {
        const roleID = $(this).data('id');
        const inputRoleName = $(this).data('role');
        $('#modalTitle').html('Update Data Role');
        $('.modal-footer button[type=submit]').html('Update role');
        $('.modal-content form').attr('action', baseUrl + 'users/update-role');
        $('#roleID').val(roleID);
        $('#inputRoleName').val(inputRoleName);
    });
});
