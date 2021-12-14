<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

<!-- ? Error Box -->
<div id="error">
      <div class="container">
        <div class="row">
          <div class="loginContainer col-md-6">
            <div class="col-md-12">
              <form action="" method="post">
                <h3 class="loginText loginTextError"><i class="fas fa-exclamation-triangle"></i> FOUTMELDING</h3>
                <p class="hippo"><i class="fas fa-hippo"></i></p>
                  <label for="username" class="userText"
                    > Helaas hebben wij het probleem niet kunnen oplossen. Vraag uw administrator voor hulp.</label>
                </br></br>
                <div id="terug" class="text-right">
                  <a href="#" class="backText"><i class="fas fa-arrow-left"></i> Terug naar vorige pagina.</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php include_once '../Referencepages/footer.php' ?>