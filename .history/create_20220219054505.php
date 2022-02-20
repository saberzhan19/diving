<?php 

require "functions.php";

if (get_user_by_email($_POST['email'])) {
    set_flash_message('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirect_to('create_user.');
}
if ($_FILES['file']) {
    $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $upload_dir = 'public/upload/user-' . $_POST['id'] . '.' . $file_extension;

    if (!move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir)) {
        set_flash_message('danger', 'ошибка загрузки автара.');
        redirect_to('create_user.');
    }
    $_POST['avatar'] = $upload_dir;
}
if (create_user($_POST)) {
    set_flash_message('success', 'Профиль успешно добавлен.');
};
redirect_to('users');