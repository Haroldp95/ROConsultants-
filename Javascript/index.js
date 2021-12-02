//* Javascript by Harold.
console.log("Loaded")
//click event listener
//object.addEventListener("click", toHome); //deze lijn lijkt niet nodig te zijn voor de onclick eventlistener

//debug lines
pageURL = location.href; 
console.log(pageURL);

//open home page.
function toHome() {
    if (location.href.includes("Webpages")){
        console.log("Going Home...")
        location.assign('/Scripts/ROConsultants-/index.php')
    }
    else
    {
        location.assign('./index.php')
    }

}

//navigates to links from buttons in header/footers
function navigate($link) {
    
    if (location.href.includes("Webpages"))
    {
        switch($link) {
            case "Contact":
                location.assign("./contact.php");
                break;
            case "About":
                location.assign("./aboutus.php");
                break;
            case "License":
                location.assign("./license.php");
                break;
            case "Privacy":
                location.assign("./privacy.php");
                break;
        }
    }    
    else if (!location.href.includes("Webpages"))
    {
        switch($link) {
            case "Contact":
                location.assign("./Webpages/contact.php");
                break;
            case "About":
                location.assign("./Webpages/aboutus.php");
                break;
            case "License":
                location.assign("./Webpages/license.php");
                break;
            case "Privacy":
                location.assign("./Webpages/privacy.php");
                break;
        }
    }

}