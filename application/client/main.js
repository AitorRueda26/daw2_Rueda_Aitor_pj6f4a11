function validateLogin() {
    const name = document.querySelector('input[name="name"]').value.trim();
    const pass = document.querySelector('input[name="passwd"]').value.trim();

    if (name === '' || pass === '') {
        alert('Please enter your username and password.');
        return false;
    }
    return true;
}
