function openRejectPopup(e){
    const popup = e.closest("td").querySelector(".rejectPopup");
    popup.classList.toggle("hidden");
    document.getElementById("table").classList.toggle("table-disabled");
    popup.classList.add("table-enabled")
}

