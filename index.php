<!--* HTML by Harold.-->

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Consulting</title>
    <link
      rel="shortcut icon"
      type="image/png"
      href="../plaatjes/Money Bag.png"
    />
    <!--CSS-->
    <link rel="stylesheet" href="css/style.css" />

    <!--<base href="/"> Deze lijn lijkt niet nodig te zijn en zorgde bij mij (Daan) voor server load errors. als het goed is heeft basefilepathing al een / erin zitten -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--Bootstrap-->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />

    <!--Icons Library-->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
      integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
      crossorigin="anonymous"
    />
    <link
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"
      rel="stylesheet"
    />

    <!--Roboto Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css"
      rel="stylesheet"
    />

          <!-- Javascript -->
          <script src="Javascript/index.js"></script>
  </head>

  <body>
  <!--?Navigation Bar-->
  <div class="container-fluid navContainer">
      <div class="navTexts">
        <div class="row">
          <div class="col-md-3 logo">
            <h1 onclick="toHome()"><i class="fas fa-user-friends"></i> ROConsultants </h1>
          </div>
  
          <div class="col-md-6">
  
          </div>
          
          <div class="col-md-1 navBtn">
            <p onclick="toHome()"><i class="fas fa-home"></i> Home</p>
          </div>
          <div class="col-md-1 navBtn">
            <p onclick="navigate('Contact')"><i class="fas fa-file-signature"></i> Contact</p>
          </div>
          <div class="col-md-1 navBtn">
            <p onclick="toLogin()" id="login"><i class="fas fa-address-card"></i> Inloggen</p>
          </div>
          
          </div>

          <div class="row">
            <div class="col-md-8">
  
            </div>
        </div>
      </div>

    <div id="login">
      <div class="container">
        <div class="row">
          <div class="loginContainer col-md-6">
            <div class="col-md-12">
              <form action="" method="post">
                <h3 class="loginText"><i class="fas fa-key"></i> Login</h3>
                <div class="form-group">
                  <label for="username" class="userText"
                    ><i class="fas fa-user-alt"></i> Gebruikersnaam:</label
                  ><br />
                  <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="password" class="userText"
                    ><i class="fas fa-unlock-alt"></i> Wachtwoord:</label
                  ><br />
                  <input
                    type="text"
                    name="password"
                    id="password"
                    class="form-control input"
                  />
                </div>
                <div class="form-group">
                  <label for="remember" class="userText"
                    ><span><i class="fas fa-bookmark"></i> Onthoud Mij </span
                    > <span
                      ><input
                        id="remember"
                        name="remember"
                        type="checkbox" /></span></label
                  ><br /><br />
                  <input
                    type="submit"
                    name="Inloggen"
                    class="btn btn-info btn-md submitBtn"
                    value="Inloggen"
                  />
                </div>
                <div id="aanmelden" class="text-right">
                  <a href="#" class="userText">Aanmelden</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ? Footer -->
<div class="bar">

</div>

<div class="container-fluid footerDiv">
  <div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-6">
      <p class="footerBtn" onclick="navigate('Contact')"><i class="fas fa-file-signature"></i> Contact</p>
    </div>
    <div class="col-md-3">

    </div>
    <div class="col-md-2">
      <p class="footerBtnStatic"> Harold de Boer</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-6">
      <p class="footerBtn" onclick="navigate('About')"><i class="fas fa-address-card"></i> Over Ons</p>
    </div>
    <div class="col-md-3">

    </div>
    <div class="col-md-2">
      <p class="footerBtnStatic"> Daan Smets</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-6">
      <p class="footerBtn" onclick="navigate('License')"><i class="fas fa-id-badge"></i> Licenties</p>
    </div>
    <div class="col-md-3">

    </div>
    <div class="col-md-2">
      <p class="footerBtnStatic"> Arend Kijk in De Vegte</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-6">
      <p class="footerBtn" onclick="navigate('Privacy')"><i class="fas fa-user-secret"></i> Privacy & Data</p>
    </div>
    <div class="col-md-3">

    </div>
    <div class="col-md-2">
      <p class="footerBtnStatic"> @2021 - Deltion</p>
    </div>
  </div>
</div>
  </body>
</html>
