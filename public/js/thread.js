function errorForm() {
    var name = document.getElementById('name');
    var message = document.getElementById('message');

    if (name.value == '' || message.value == '') {
        alert('すべての項目を入力してください');
        return false;
    }
    return true;
}