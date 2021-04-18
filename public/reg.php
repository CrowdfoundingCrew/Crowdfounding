<?php
$title = "HomePage";
include('header.php');
?>
<link rel="stylesheet" href="../css/reg.scss">
<div class="logmod">
  <div class="logmod__wrapper">
    <span class="logmod__close">Close</span>
    <div class="logmod__container">
      <ul class="logmod__tabs">
        <li data-tabtar="lgm-2"><a href="#">Donatore</a></li>
        <li data-tabtar="lgm-1"><a href="#">Onlus</a></li>
      </ul>
      <div class="logmod__tab-wrapper">
        <div class="logmod__tab lgm-1">
          <!-- <div class="logmod__heading">
          <span class="logmod__heading-subtitle">Enter your personal details <strong>to create an acount</strong></span>
        </div>-->
          <div class="logmod__form">
            <form accept-charset="utf-8" action="../config/addonlus.php" class="simform" method="POST" enctype="multipart/form-data">
              <div class="sminputs">
                <div class="input string optional">
                  <label class="string optional" for="user-name">Email *</label>
                  <input name="Email" class="string optional" maxlength="255" id="onlus-email" placeholder="Email" type="email" size="50" required />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="user-name">Username *</label>
                  <input  name="Username" class="string optional" maxlength="255" id="onlus-usrname" placeholder="Username" type="text" size="50" required />
                </div>

              </div>
              <div class="sminputs">
                <div class="input string optional">
                  <label class="string optional" for="user-pw">Password *</label>
                  <input name="Password" class="string optional" maxlength="255" id="onlus-pw" placeholder="Password" type="password" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="user-pw-repeat">Repeat password *</label>
                  <input name="Password2" class="string optional" maxlength="255" id="user-pw-repeat" placeholder="Repeat password" type="password" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="onlus-name">Nome *</label>
                  <input name="Name" class="string optional" maxlength="255" id="onlus-tel" placeholder="Nome" type="text" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="user-pw-repeat">Telefono *</label>
                  <input name="Tel" class="string optional" maxlength="10" id="onlus-tel" placeholder="Telefono" type="text" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="onlus-piva">Partita Iva *</label>
                  <input name="Piva" class="string optional" maxlength="11" id="onlus-piva" placeholder="Partita Iva" type="text" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="onlus-cf">Codice fiscale *</label>
                  <input name="CDF" class="string optional" maxlength="16" id="onlus-cf" placeholder="Codice fiscale" type="text" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="onlus-rea">REA *</label>
                  <input name="REA"class="string optional" maxlength="11" id="user-pw" placeholder="REA" type="text" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="onlus-logo">Logo *</label>
                  <input name="Logo" class="string optional" id="onlus-logo" type="file" size="50" />
                </div>
                <div class="input full">
                  <label class="string optional" for="user-cdf">Indirizzo</label>
                  <input name="Address" class="string optional" maxlength="255" id="user-ind" placeholder="Indirizzo" type="text" size="50" />
                </div>
              </div>
              <div class="simform__actions">
                <input class="sumbit" name="commit" type="submit" id="btn_submit" value="Crea Account">
                <span class="simform__actions-sidetext">By creating an account you agree to our <a class="special" href="#" target="_blank" role="link">Terms & Privacy</a></span>
              </div>
            </form>
          </div>

        </div>
        <div class="logmod__tab lgm-2">

          <div class="logmod__form">
            <form accept-charset="utf-8" action="../config/adddonator.php" class="simform" method="POST">
              <div class="sminputs">
                <div class="input string optional">
                  <label class="string optional" for="user-name">Email *</label>
                  <input name="Email" class="string optional" maxlength="255" id="user-email" placeholder="Email" type="email" size="50" required />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="user-name">Username *</label>
                  <input name="Username" class="string optional" maxlength="255" id="user-usrname" placeholder="Username" type="text" size="50" required />
                </div>
              </div>
              <div class="sminputs">
                <div class="input string optional">
                  <label class="string optional" for="user-pw">Password *</label>
                  <input name="Password" class="string optional" maxlength="255" id="user-pw" placeholder="Password" type="text" size="50" required />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="user-pw-repeat">Repeat password *</label>
                  <input name="Password2" class="string optional" maxlength="255" id="user-pw-repeat" placeholder="Repeat password" type="text" size="50" required />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="user-name">Nome</label>
                  <input name="Name" class="string optional" maxlength="255" id="user-name" placeholder="Nome" type="text" size="50" />
                </div>
                <div class="input string optional">
                  <label class="string optional" for="user-surname">Cognome</label>
                  <input name="Surn" class="string optional" maxlength="255" id="user-surname" placeholder="Cognome" type="text" size="50" />
                </div>
                <div class="input full">
                  <label class="string optional" for="user-cdf">Codice fiscale</label>
                  <input name="CDF" class="string optional" maxlength="16" id="user-cdf" placeholder="Codice fiscale" type="text" size="50" />
                </div>
                <div class="input full">
                  <label class="string optional" for="user-cdf">Indirizzo</label>
                  <input name="Address" class="string optional" maxlength="255" id="user-ind" placeholder="Indirizzo" type="text" size="50" />
                </div>
              </div>
              <div class="simform__actions">
                <input class="sumbit" name="commit" type="submit" id="btn_submit" value="Crea Account">
                <span class="simform__actions-sidetext">By creating an account you agree to our <a class="special" href="#" target="_blank" role="link">Terms & Privacy</a></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="../js/reg.js"></script>