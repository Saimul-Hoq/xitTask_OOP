function toggleCurrentPassword(e){
    const parent = e.closest(".input-wrapper");
    const input = parent.querySelector("#edit-currentPassword");
    const eyeOpen = parent.querySelector(".eye-open");
    const eyeClose = parent.querySelector(".eye-close");

    input.type = input.type === "password" ? "text" : "password";

    eyeOpen.classList.toggle("hidden");
    eyeClose.classList.toggle("hidden");
}

function toggleNewPassword(e){
    const parent = e.closest(".input-wrapper");
    const input = parent.querySelector("#edit-newPassword");
    const eyeOpen = parent.querySelector(".eye-open");
    const eyeClose = parent.querySelector(".eye-close");

    input.type = input.type === "password" ? "text" : "password";

    eyeOpen.classList.toggle("hidden");
    eyeClose.classList.toggle("hidden");
}

function toggleConfirmPassword(e){
    const parent = e.closest(".input-wrapper");
    const input = parent.querySelector("#edit-confirmPassword");
    const eyeOpen = parent.querySelector(".eye-open");
    const eyeClose = parent.querySelector(".eye-close");

    input.type = input.type === "password" ? "text" : "password";

    eyeOpen.classList.toggle("hidden");
    eyeClose.classList.toggle("hidden");
}