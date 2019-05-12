<?php
$PH_RELATIVE_PATH = "PhApps/";
?>
<?php include_once $PH_RELATIVE_PATH . "phcfg.php" ?>
<?php include_once $PH_RELATIVE_PATH . "phmysql.php" ?>
<?php include_once $PH_RELATIVE_PATH . "phfn.php" ?>
<?php include_once $PH_RELATIVE_PATH . "cpfn.php" ?>
<?php
global $dbKeys, $nPhCurrentLang;
// Prepare Request variables
ph_PrepareGets();
ph_PreparePosts();

// PhSoft Setting
$ph_Setting_SiteName = ph_Setting('Site-Name');
$ph_Setting_LeftMenu = ph_Setting('Main-Menu-Left');
$ph_Setting_RightMenu = ph_Setting('Main-Menu-Right');
$ph_Setting_DefSlider = ph_Setting('Default-Slider');
$ph_Setting_Header = ph_Setting('Disp-Header');
$ph_Setting_Footer = ph_Setting('Disp-Footer');
$ph_Setting_Home = ph_Setting('Disp-Home');
$ph_Setting_Search = ph_Setting('Disp-Facebook');
$ph_Setting_Facebook = ph_Setting('Disp-Facebook');
$ph_URL_Facebook = ph_Setting('URL-facebook');

if ($ph_Setting_SiteName == "") {
  $ph_Setting_SiteName = "DHL - Syria";
}

$vSText = ph_Get('stext');
if ($vSText == '') {
  $vSText = ph_Post('stext');
}
$vSText = trim($vSText);
$nModeId = ph_Get('mode');
if ($nModeId == '') {
  $nModeId = ph_Post('mode');
}
if ($nModeId == "") {
  $nModeId = 0;
}
$nPageId = ph_Get('page');
if ($nPageId == '') {
  $nPageId = ph_Post('page');
}
if ($nPageId == "") {
  $nPageId = 0;
}
$nMenuId = ph_Get('menu');
if ($nMenuId == '') {
  $nMenuId = ph_Post('menu');
}
if ($nMenuId == "") {
  $nMenuId = 0;
}
$cLeftMenu = cMenu::getInstance($ph_Setting_LeftMenu);
$cRightMenu = cMenu::getInstance($ph_Setting_RightMenu);
$cPage = cPage::getInstance($nPageId);
$pageName = 'ph-page.php';
if ($nModeId == -1) {
  if ($vSText != "") {
    $pageName = 'ph-search.php';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Title -->
    <title><?php echo $ph_Setting_SiteName; ?></title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/vendor/glyphicon/glyphicons.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="assets/vendor/hs-megamenu/src/hs.megamenu.css">
    <link rel="stylesheet" href="assets/vendor/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="assets/vendor/slick-carousel/slick/slick.css">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
  </head>

  <body>
    <?php include 'ph-header-nav.php'; ?>
    <!-- ========== MAIN CONTENT ========== -->
    <main>
      <!-- Hero Section -->
      <?php include 'ph-header-top.php'; ?>
      <!-- End Hero Section -->
      <section id="mainSection" style="margin: 0; padding: 0;">
        <!-- Page Section -->
        <?php include $pageName; ?>
        <!-- End Page Section -->
      </section>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
    <!-- Go to Top -->
    <a class="js-go-to u-go-to" href="#"
       data-position='{"bottom": 15, "right": 15 }'
       data-type="fixed"
       data-offset-top="400"
       data-compensation="#header"
       data-show-effect="slideInUp"
       data-hide-effect="slideOutDown">
      <span class="glyphicon glyphicon-chevron-up u-go-to__inner"></span>
    </a>
    <!-- End Go to Top -->

    <!-- ========== FOOTER ========== -->
    <?php include 'ph-footer.php'; ?>
    <!-- ========== END FOOTER ========== -->

    <!-- JS Global Compulsory -->
    <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="assets/vendor/jquery/jquery.redirect.js"></script>
    <script src="assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="assets/vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/bootstrap.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="assets/vendor/hs-megamenu/src/hs.megamenu.js"></script>
    <script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="assets/vendor/fancybox/jquery.fancybox.min.js"></script>
    <script src="assets/vendor/slick-carousel/slick/slick.js"></script>

    <!-- JS -->
    <script src="assets/js/hs.core.js"></script>
    <script src="assets/js/components/hs.header.js"></script>
    <script src="assets/js/helpers/hs.focus-state.js"></script>
    <script src="assets/js/components/hs.validation.js"></script>
    <!--<script src="assets/js/components/hs.fancybox.js"></script>-->
    <script src="assets/js/components/hs.slick-carousel.js"></script>
    <script src="assets/js/components/hs.go-to.js"></script>

    <!-- JS Plugins Init. -->
    <script>
      function getViewPort() {
        var $w = $(window);
        var viewport = 'xs';
        var breakpointsMap = {
          'md': 768,
          'sm': 576,
          'lg': 992,
          'xl': 1200
        };
        if ($w.width() >= breakpointsMap['xl']) {
          viewport = 'xl';
        } else if ($w.width() > breakpointsMap['lg'] && $w.width() < breakpointsMap['xl']) {
          viewport = 'lg';
        } else if ($w.width() > breakpointsMap['md'] && $w.width() < breakpointsMap['lg']) {
          viewport = 'md';
        } else if ($w.width() > breakpointsMap['sm'] && $w.width() < breakpointsMap['md']) {
          viewport = 'sm';
        }
        return viewport;
      }

      $(window).on('load', function () {
        // initialization of HSMegaMenu component
        $('.js-mega-menu').HSMegaMenu({
          event: 'click',
          pageContainer: $('.container'),
          breakpoint: 767,
          hideTimeOut: 0,
          animationIn: true,
          animationOut: true
        });
      });
      $(document).on('ready', function () {

        // initialization of header
        $.HSCore.components.HSHeader.init($('#header'));
        $('.carousel').carousel();
        $('.newsBtn').click(function () {
          var id = $(this).data('id');
          $('#newsDiv').addClass('d-none');
          $('#newsDiv').removeClass('d-block');
          $('#activityDiv').addClass('d-none');
          $('#activityDiv').removeClass('d-block');
          $('#' + id).removeClass('d-none');
          $('#' + id).addClass('d-block');
          $('.newsBtn').removeClass('active');
          $(this).addClass('active');
        });
        $('.ph-menu-link').click(function () {
          var params = {
            mode: $(this).data('mode'),
            page: $(this).data('page'),
            menu: $(this).data('mid')
          };
          $.redirect("index.php", params, 'POST');
        });
        // Custom function which toggles between sticky class (is-sticky)
        var stickySubToggle = function (sticky, stickyWrapper, scrollElement) {
          var stickyHeight = sticky.outerHeight();
          var stickyTop = stickyWrapper.offset().top - 35;
          sticky.removeClass("is-subSticky");
          stickyWrapper.height('auto');
          if (getViewPort() !== 'sm') {
            if (scrollElement.scrollTop() >= stickyTop) {
              stickyWrapper.height(stickyHeight);
              sticky.addClass("is-subSticky");
            }
          }
        };
        $('[data-toggle="sticky-onscroll-sub"]').each(function () {
          var sticky = $(this);
          var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
          sticky.before(stickyWrapper);
          sticky.addClass('sticky');
          // Scroll & resize events
          $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function () {
            stickySubToggle(sticky, stickyWrapper, $(this));
          });
          // On page load
          stickySubToggle(sticky, stickyWrapper, $(window));
        });
        $('.newsimage').click(function () {
          getGallery($(this).data('id'));
        });
      });

      function getGallery(nId) {
        $.ajax({
          type: 'POST',
          async: false,
          url: 'PhApps/phNImages.php',
          data: {
            "nId": nId
          },
          success: function (data) {
            var oRet = JSON.parse(data);
            if (oRet.Status === true) {
              $.fancybox.open(oRet.Data, {
                nextEffect: 'none',
                prevEffect: 'none',
                padding: 0,
                playSpeed: 500,
                loop: true,
                autoSize: true,
                autoResize: true,
                aspectRatio: true,
                helpers: {
                  title: {
                    type: 'over'
                  },
                  thumbs: {
                    width: 75,
                    height: 50,
                    source: function (item) {
                      return item.href;
                    }
                  }
                }
              });
            }
          },
          error: function (data) {
          }
        });
      }
      // initialization of go to
      $.HSCore.components.HSGoTo.init('.js-go-to');
    </script>
  </body>
</html>