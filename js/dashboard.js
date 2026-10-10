//Change Avatar
const editAvatarBtn = document.getElementById("edit-avatar-btn");
const editAvatarInput = document.getElementById("edit-avatar");

function openEditAvatar(e){
    if(editAvatarBtn.innerText === "Change Avatar"){
        editAvatarBtn.innerText = "Cancel";
        editAvatarInput.classList.remove("hidden");
        editAvatarInput.removeAttribute("disabled");
    }
    else{
        editAvatarBtn.innerText = "Change Avatar";
        editAvatarInput.classList.add("hidden");
        editAvatarInput.setAttribute("disabled", "");
        document.getElementById("edit-avatar-error").textContent = "";
        editAvatarInput.classList.remove("input-error");
    }
}


//Change Password 
const editPasswordBtn = document.getElementById("edit-password-btn");
const editPasswordSection = document.getElementById("edit-password-fields");
function removeDisabled(){
    document.querySelectorAll("#edit-password-fields .input").forEach((input) => {
        input.removeAttribute("disabled");
    })
}
function addDisabled(){
    document.querySelectorAll("#edit-password-fields .input").forEach((input) => {
        input.setAttribute("disabled", "");
        input.value = "";
        input.classList.remove("input-error");
    })
}
function removeErrorMessage(){
    document.querySelectorAll("#edit-password-fields [id$='error']").forEach(errorMsg => {
        errorMsg.textContent = "";
    })
}

function openEditPassword(e){
    if(editPasswordBtn.innerText === "Set new password"){
        editPasswordBtn.innerText = "Cancel";
        editPasswordSection.classList.remove("hidden");
        removeDisabled();
    }
    else{
        editPasswordBtn.innerText = "Set new password";
        editPasswordSection.classList.add("hidden");
        addDisabled();
        removeErrorMessage();
    }
}

const editForm = document.getElementById("edit-form");

if (editForm.dataset.openPassword === "true") {
    openEditPassword();
}
if (editForm.dataset.openAvatar === "true") {
    openEditAvatar();
}
