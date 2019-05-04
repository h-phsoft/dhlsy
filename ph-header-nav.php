<!-- === === ====HEADER === === ====-->
<header id="header" class="u-header u-header--floating-md">
  <div id="logoAndNav" class="container-fluid">
    <div class="u-header__section u-header--floating-md__inner">
      <div id="ph-top" class="u-header-top d-none d-md-block hide-on-fixed">
        <div class="row">
          <div class="col-6 pt-2 pl-3 d-flex justify-content-start">
            <a href="?i=0"><img style="height: 70px;" src="assets/img/logos/NAZHA_Logo.svg"></a>
          </div>
          <div class="col-6 p-5 d-flex justify-content-end align-text-bottom">
            <div>
              <img style="height: 15px;" src="assets/img/icons/Globe.png">
              <span class="mr-5" style="font-size: 10px;">Syria</span>
              <img style="width: 150px;" src="assets/img/logos/DHL_logo.svg">
            </div>
          </div>
        </div>
      </div>
      <!--Nav -->
      <nav class="u-header-nav js-mega-menu navbar navbar-expand-md u-header__navbar">
        <!-- Logo -->
        <a class="navbar-brand u-header__navbar-brand d-block d-md-none" href="?i=0" aria-label="Front">
          <img width="200" height="75" src="assets/img/logos/Nazha_Logistics_Logo.svg" alt="Logo">
        </a>
        <!-- End Logo -->

        <!--Responsive Toggle Button -->
        <button type="button" class="navbar-toggler btn u-hamburger"
                aria-label="Toggle navigation"
                aria-expanded="false"
                aria-controls="navBar"
                data-toggle="collapse"
                data-target="#navBar">
          <span id="hamburgerTrigger" class="u-hamburger__box">
            <span class="u-hamburger__inner"></span>
          </span>
        </button>
        <!--End Responsive Toggle Button -->

        <!--Navigation -->
        <div id="navBar" class="collapse navbar-collapse py-0 pl-md-5">
          <ul class="navbar-nav u-header__navbar-nav mt-2 mt-lg-0 ml-md-5">
            <?php
            if ($ph_Setting_Home == 1) {
              ?>
              <!-- Home -->
              <li class="nav-item border-right">
                <a class="ph-nav-link nav-link" href="?i=0">
                  Home
                </a>
              </li>
              <!-- End Home -->
              <?php
            }
            ?>
            <?php
            cMenu::renderMenuItems($cLeftMenu);
            ?>
          </ul>

          <ul class="navbar-nav u-header__navbar-nav ml-auto mt-2 mt-lg-0 right">
            <?php
            cMenu::renderMenuItems($cRightMenu, "right");
            ?>

            <?php
            if ($ph_Setting_Facebook == 1) {
              ?>
              <!-- facebook -->
              <li class="nav-item border-right">
                <a class="ph-nav-link nav-link py-1" href="<?php echo $ph_URL_Facebook; ?>" target="_BLANK">
                  <img height="20" src="assets/img/icons/Facebook_Grey.png">
                </a>
              </li>
              <!-- End facebook -->
              <?php
            }
            ?>

            <?php
            if ($ph_Setting_Search == 1) {
              ?>
              <!-- Search Button -->
              <li class="hs-has-mega-menu u-header__nav-item nav-item d-none d-md-inline-block p-0"
                  data-event="click"
                  data-animation-in="slideInUp"
                  data-animation-out="fadeOut"
                  data-position="right">
                <!--<a class="ph-nav-link transition-3d-hover glyphicon glyphicon-search"></a>-->
                <a class="ph-nav-link nav-link py-1"
                   aria-haspopup="true"
                   aria-expanded="false">
                  <img height="20" src="assets/img/icons/Search.png">
                </a>
                <div class="hs-mega-menu u-header__sub-menu w-auto p-3 u-header__mega-menu-wrapper-v3" style="margin-top: -10px">
                  <form class="js-validate js-form-message" method="post">
                    <div class="js-focus-state input-group u-form">
                      <input type="hidden" name="mode" value="-1">
                      <input type="hidden" name="page" value="0">
                      <input type="text" class="form-control u-form__input" name="stext" required>
                      <span class="input-group-append u-form__append">
                        <button type="submit" class="btn btn-primary btn-danger">Search</button>
                      </span>
                    </div>
                  </form>
                </div>
              </li>
              <!-- End Search Button -->
              <?php
            }
            ?>
          </ul>
        </div>
        <!-- End Navigation -->
      </nav>
      <!-- End Nav -->
      <div id="ph-bottom" class="u-header-bottom d-none d-md-block hide-on-fixed">
        &nbsp;
      </div>
    </div>
  </div>
</header>
<!-- ========== END HEADER ========== -->
