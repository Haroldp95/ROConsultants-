//? Click event listener
object.addEventListener("click", toHome);

//? Open home page.
function toHome() {
    console.log("Going Home...")
    location.replace("./index.html")
}

//? Open Login Screen.
function toLogin() {

    //Clear innertext
    document.getElementById("login").innerText = "";

    //Add Icon and new text.
    var tag = document.createElement("i");
    tag.className = "fas fa-user-alt";
    tag.innerText = " Uitloggen"
    var element = document.getElementById("login");
    element.appendChild(tag);
    
    //Change Class.
    document.getElementById("login").className = "login";
}