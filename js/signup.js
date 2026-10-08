

let successStatus = document.getElementById("status").textContent;
if(successStatus === "true"){
    document.getElementById("successPopup").classList.add("open");
    document.getElementById("signup-form").classList.add("success");
    // document.getElementById("fieldset").disabled = true;
    document.getElementById("signup-back-btn").removeAttribute("href");
    // document.getElementById("signup-register-btn").disabled = true;

}

const eyeOpen = document.getElementById('eye-open');
const eyeClose = document.getElementById('eye-close');
const passwordInput = document.getElementById('signup-password');



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
