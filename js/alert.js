// function hideAlert(e)
// {
//     document.querySelector(".alert").classList.add("hidden");
// }

function hideAlert(btn)
{
    btn.closest(".alert").remove();
}