<!DOCTYPE html>
<html>

<?php include_once '../Referencepages/htmlhead.php' ?>
<?php include_once '../Referencepages/header.php' ?>

    <div class="text-container">
            
        <div class="text">
        <h1>CONTACT EN INFORMATIE</h1>
        <br>
            
        <div class="row">
            <div class="column">
                <h3>Contact?</h3>

                <form class="contactform" action="includes/mail.php" method="post">
                <label for="naam">Uw naam *<br></label>
                <input class="input" type="text" id="naam" name="naam" placeholder="">

                <label for="email"><br>Uw e-mailadres *<br></label>
                <input class="input" type="text" id="email" name="email" placeholder="">

                <label for="bericht"><br>Uw bericht *<br></label>
                <textarea id="text" name="text" placeholder=""></textarea><br>

                <input class="submitbtn" type="submit" value="submit">

                </form>
            </div>
            <div class="column">
                <a href="https://www.google.nl/maps/place/Mozartlaan+15,+8031+AB+Zwolle/@52.5214563,6.081906,17z/data=!3m1!4b1!4m5!3m4!1s0x47c7d8caa3f93b91:0xe688896255f4ea72!8m2!3d52.5214531!4d6.0840947"><img src="static/images/adres.png"></a>
                <h3>Bezoekadres</h3>
                <p>Mozartlaan 15<br>8031AB Zwolle</p>
                <p><u>Postadres</u><br>Postbus 038<br>8031AB</p>
            </div>
            <div class="column">
                <h3>Email/Telefoon</h3>
                <p><b>T: </b>038-53663337</p>
                <p><b>F: </b>038-5333658</p>
                <p><b>E: </b>B.Barneveld@ROConsultants.nl</p>
            </div>
        </div>
                
        <div class="img-footer">Locatie Drektoren in Google maps.</div>
        <div class="maps"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2427.662145189126!2d6.081906015807543!3d52.521453079814556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7d8caa3f93b91%3A0xe688896255f4ea72!2sMozartlaan%2015%2C%208031%20AB%20Zwolle!5e0!3m2!1snl!2snl!4v1638207041092!5m2!1snl!2snl" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>
            

        
        </div>
    </div>

<?php include_once '../Referencepages/footer.php' ?>
</html>