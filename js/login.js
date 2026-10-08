const eyeOpen = document.getElementById('eye-open');
const eyeClose = document.getElementById('eye-close');
const passwordInput = document.getElementById('login-password');



function eyeOpenFn(e){
    passwordInput.type = 'text';
    eyeOpen.classList.add('hidden');
    eyeClose.classList.remove('hidden');
}

function eyeCloseFn(e){
    passwordInput.type = 'password';
    eyeClose.classList.add('hidden');
    eyeOpen.classList.remove('hidden');
}

