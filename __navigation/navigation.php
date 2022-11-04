<?php

echo '
<nav class="navbarm">
        <ul class="navbar-navm">
          <!-- Logotip -->
          <li class="logo">
            <a href="#" class="nav-linkm nav-linkm-logo">
              <span class="link-text logo-text">Porat</span>
              <img class="icon logo-icon" src="__img/Logo.png" alt="">
            </a>
          </li>
         <!-- Raspored -->
          <li class="nav-item">
            <a href="#" class="nav-linkm">
              <lord-icon class="icon"
                  src="__icons/calendar.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#F89B3E"
                  state="hover"
                  style="width:48px;height:48px">
              </lord-icon>
              <span class="link-text">Raspored</span>
            </a>
          </li>
          <!-- Novi Unos -->
          <li class="nav-item">
            <a href="#" class="nav-linkm">
              <lord-icon class="icon"
                  src="__icons/addReservation.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#F89B3E"
                  style="width:48px;height:48px">
              </lord-icon>
              <span class="link-text">Novi unos</span>
            </a>
          </li>
          <!-- Setting -->
          <li class="nav-item bottom" id="themeButton">
            <a href="#" class="nav-linkm">
              <lord-icon class="icon"
                  src="__icons/settings.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#F89B3E"
                  style="width:48px;height:48px">
              </lord-icon>
              <span class="link-text">Tema</span>
            </a>
          </li>
          <!-- Korisnik -->
          <li class="nav-item">
            <a href="__login/index.html" class="nav-linkm">
              <lord-icon class="icon"
                  src="__icons/switchUser.json"
                  target="a.nav-linkm"
                  trigger="loop-on-hover"
                  delay="500"
                  colors="primary:#F89B3E"
                  state="hover"
                  style="width:48px;height:48px">
              </lord-icon>
              <span class="link-text">Korisnik</span>
            </a>
          </li>
        </ul>
      </nav>
';

?>