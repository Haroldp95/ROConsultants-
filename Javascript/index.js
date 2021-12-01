//* Javascript by Harold.
console.log("Loaded")
//? Click event listener
//object.addEventListener("click", toHome); //deze lijn lijkt niet nodig te zijn voor de onclick eventlistener

pageURL = location.href;
console.log(pageURL);

//? Open home page.
function toHome() {
    if (location.href.includes("roconsultants")){
        console.log("Going Home...")
        location.replace("./index.html")
    }

}

function toLogin() {
    if (window.location.href == "/roconsultants/")
    console.log("Going to login page...")
    location.replace("./Webpages/login.php")
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