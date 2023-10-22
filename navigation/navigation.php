<?php

echo '
<nav class="navbarm">
        <ul class="navbar-navm">
          <!-- Logotip -->
          <li class="logo">
            <a href="../reservations/reservations.php" class="nav-linkm nav-linkm-logo">
              <span class="link-text logo-text">Porat</span>
              <img class="icon logo-icon" src="../img/Logo.png" alt="">
            </a>
          </li>
          <!-- Raspored -->
          <li class="nav-item">
            <a href="../reservations/reservations.php" class="nav-linkm">
              <lord-icon class="icon ico"
                  src="../icon/calendar.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#ffffff"
                  state="hover">
              </lord-icon>
              <span class="link-text">Raspored</span>
            </a>
          </li>
          <!-- Novi Unos -->
          <li class="nav-item">
            <a href="../addReservation/addReservation.php" class="nav-linkm">
              <lord-icon class="icon"
                  src="../icon/addReservation.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#ffffff"">
              </lord-icon>
              <span class="link-text">Novi unos</span>
            </a>
          </li>
          <!-- Blagajna -->
          <li class="nav-item">
            <a href="../books/books.php" class="nav-linkm">
              <lord-icon class="icon"
                  src="../icon/book.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#ffffff,secondary:#ffffff"
                  stroke="105"
                  state="hover">
              </lord-icon>
              <span class="link-text">Blagajna</span>
            </a>
          </li>
          <!-- Maps -->
          <li class="nav-item">
            <a href="../maps/index.php" class="nav-linkm">
              <img class="icon"
                  src="../icon/maps.png"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#ffffff,secondary:#ffffff"
                  stroke="105"
                  state="hover">
              </img>
              <span class="link-text">Karta</span>
            </a>
          </li>
          <!-- Setting -->
          <li class="nav-item bottom" id="themeButton">
            <a href="../settings/settings.php" class="nav-linkm">
              <lord-icon class="icon"
                  src="../icon/settings.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#ffffff">
              </lord-icon>
              <span class="link-text">Postavke</span>
            </a>
          </li>
          <!-- Korisnik -->
          <!--
          <li class="nav-item">
            <a href="../logout.php" class="nav-linkm">
              <lord-icon class="icon"
                  src="../icon/switchUser.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#ffffff"
                  state="hover">
              </lord-icon>
              <span class="link-text">Odjava</span>
            </a>
          </li>
          -->
        </ul>
      </nav>
';

?>