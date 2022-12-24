<?php

include ("../header-footer/header.php");
include ("../navigation/navigation.php");

echo '
<main id="blur">
  <div class="spacer"></div>
  <div class="add-glass-container blurForClearFormPopup" id="blurForClearFormPopup">
    <!--LIJEVI DIO-->
    <div class="add-glass-left">

      <div class="add-title-container">
        <div class="add-title">
          Nova Rezervacija
        </div>
      </div>

      <div class="add-panel-left">
        <div class="add-panel-left-content">

        <form id="reservationForm" style="height:100%" action="">

          <!-- dropdown -->
          <div class="addBrodovi-dropdown-container">
            <select id="addBrodovi-dropdown" required>
              <option value="">Odaberite svoj brod...</option>
              <option value="orca">Orca</option>
              <option value="shark">Shark</option>
              <option value="dolphin">Dolphin</option>
              <option value="barracuda">Barracuda</option>
            </select>
          </div>

        <!-- content-top -->


          <div class="add-panel-left-content-top">

            <div class="add-inputs-top">
              <label class="add-date-label" for="addreserv-datum-od">Od datuma:</label>
              <input type="date" id="addreserv-datum-od" required>
              <label class="add-date-label" for="addreserv-datum-do">Do datuma:</label>
              <input type="date" id="addreserv-datum-do">
            </div>

            <div class="add-radio-button-container">
              <label class="add-date-label" for="ad-radio-button">Vraćam brod isti dan </label>
              <input type="checkbox" id="ad-radio-button">
            </div>

            <div class="add-time-input-container">
              <label class="add-time-label" for="addreserv-vrijeme-od">Od sati:</label>
              <input type="time" id="addreserv-vrijeme-od" required>
              <label class="add-time-label" for="addreserv-vrijeme-do">Do sati:</label>
              <input type="time" id="addreserv-vrijeme-do" required>
            </div>

          </div>

          <!-- content-bottom -->

          <div class="add-panel-left-content-bottom">

            <!-- lijeva strana bottom contenta -->
            <div class="add-panel-left-content-bottom-left-side">
              <div>
                <label for="add-input-ime">Ime: </label>
                <input type="text" id="add-input-ime" class="add-input-field" required>
              </div>
              <div>
                <label for="add-input-prezime">Prezime: </label>
                <input type="text" id="add-input-prezime" class="add-input-field" required>
              </div>
              <div>
                <label for="add-input-mobitel">Mobitel: </label>
                <input type="text" id="add-input-mobitel" class="add-input-field" required>
              </div>
              <div>
                <label for="add-input-oib">OIB: </label>
                <input type="number" id="add-input-oib" class="add-input-field">
              </div>
            </div>

              <!-- desna strana bottom contenta -->
            <div class="add-panel-left-content-bottom-right-side">
              <div class="addDjelatnici-dropdown-container">
                <select id="addDjelatnici-dropdown" required>
                  <option value="">Rezervirao...</option>
                  <option value="orca">Jan Jurjec</option>
                  <option value="shark">Goran Bratoš</option>
                  <option value="dolphin">Cohinator 3000</option>
                  <option value="barracuda">Barack Obama</option>
                </select>
              </div>
              <div class="add-input-bottomright-container">
                <label for="addInput-cijena">Cijena: </label>
                <input type="number" id="addInput-cijena"  required>
              </div>
              <div class="add-input-bottomright-container">
                <label for="addInput-akontacija">Akontacija: </label>
                <input type="number" id="addInput-akontacija">
              </div>
              <div class="add-input-bottomright-container">
                <label for="addInput-razlika">Razlika: </label>
                <input type="number" id="addInput-razlika">
              </div>
            </div>

          </div>

          <!-- buttoni -->

          <div class="add-panel-left-content-buttons">
            <div class="add-button-half">
              <div class="add-button-container">
                <input type="button" value="Očisti" class="add-button-ocisti" onclick="delete_popup()">
              </div>
            </div>
            <div class="add-button-half">
              <div class="add-button-container">
                <input type="submit" id="submitButton" value="Rezerviraj" class="add-button-rezerviraj">
              </div>
            </div>
          </div>
        </div>

        </form> 
        
      </div>    
    </div>

  <!--DESNI DIO-->

    <div class="add-glass-right">

      <div class="add-title-container">
        <div class="add-title">
          Kalendar Rezervacija
        </div>
      </div>

      <div class="add-panel-right">
        <div class="add-panel-right-content">
        ';
        
        echo '
        </div>
      </div>

    </div>
</div>

<div id="clearFormPopup" class="clearFormPopup">
    <div class="deleteWindow-rows">
        <div class="popup-title h4">Potvrdi čišćenje unosa</div>
        <div class="row">
            <div class="popup-col-flex-buttons">
                <a href="#" onclick="clearForm()" class="button-delete-deletePopup">
                    <lord-icon
                        src="../icon/delete.json"
                        target=".button-delete-deletePopup"
                        trigger="loop-on-hover"
                        delay="500"
                        colors="primary:#da1a20"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <div class="button-text">Očisti</div>
                </a> 
                <a href="#" onclick="delete_popup()" class="button-edit">
                    <lord-icon class="rotate-arrow"
                        src="../icon/dateArrow.json"
                        target=".button-edit"
                        trigger="loop-on-hover"
                        delay="500"
                        colors="primary:#337895"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <div class="button-text">Odustani</div>
                </a>   
            </div>
        </div>
    </div>
</div>
<div class="spacer"></div>

</main>

';


include ("../header-footer/footer-addReservation.php");
include ("../header-footer/footer.php");

?>