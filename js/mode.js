

const lightModeBtn = document.getElementById("lightMode-btn");
const darkModeBtn = document.getElementById("darkMode-btn");
const savedTheme = localStorage.getItem("theme") || "dark";

if(savedTheme){
    document.documentElement.setAttribute("data-theme", savedTheme);
    if(savedTheme==="light"){
        lightModeBtn.classList.add("hidden");
        darkModeBtn.classList.remove("hidden");
    }
    else{
        lightModeBtn.classList.remove("hidden");
        darkModeBtn.classList.add("hidden");
    }
}

function toggleMode(e){

    const currentTheme = document.documentElement.getAttribute("data-theme");
    const newTheme = currentTheme === "light"? "dark" : "light";
    document.documentElement.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);

    if(newTheme==="light"){
        lightModeBtn.classList.add("hidden");
        darkModeBtn.classList.remove("hidden");
    }
    else{
        lightModeBtn.classList.remove("hidden");
        darkModeBtn.classList.add("hidden");
    }
    
}

