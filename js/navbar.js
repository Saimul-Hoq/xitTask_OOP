

function openDropdown(e){
    document.getElementsByClassName("navbar-dropdown")[0].classList.add("dropdown-open");
    document.getElementById("open-menu").classList.add("hidden");
    document.getElementById("close-menu").classList.add("show");

}



const desktopQuery = window.matchMedia("(min-width: 851px)");

function closeDropdown() {
    document.getElementsByClassName("navbar-dropdown")[0].classList.remove("dropdown-open");
    document.getElementById("open-menu").classList.remove("hidden");
    document.getElementById("close-menu").classList.remove("show");
}

desktopQuery.addEventListener("change", (e) => {
    if (e.matches) closeDropdown();
});