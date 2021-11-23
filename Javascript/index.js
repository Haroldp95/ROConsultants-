//* Javascript by Harold.

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

function navigate($link) {
    switch($link) {
        case "Contact":
            location.replace("./Webpages/contact.php");
            break;
        case "About":
            location.replace("./Webpages/aboutus.php");
            break;
        case "License":
            location.replace("./Webpages/license.php");
            break;
        case "Privacy":
            location.replace("./Webpages/privacy.php");
            break;
    }
}