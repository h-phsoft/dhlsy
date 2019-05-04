<?php
$slider = cSlider::getInstanceByName($ph_Setting_DefSlider);
if ($cPage != "") {
  if ($cPage->Slider != "") {
    $slider = $cPage->Slider;
  }
}
$nSlides = count($slider->aSlides);
if ($nSlides > 0) {
  ?>
  <!-- Hero Section -->
  <!--  <section id="heroSection" class="d-none d-md-block d-lg-flex align-items-lg-center position-relative u-bg-img-hero u-space-3 u-space-5-top--md u-space-0--lg">-->
  <section id="heroSection" class="d-lg-flex align-items-lg-center position-relative u-bg-img-hero u-space-5-top--md u-space-0--lg">
    <?php
    if ($nSlides == 1) {
      echo '<img class="d-block w-100 h-75" src="assets/img/mainSlider/' . $slider->aSlides[0]->Slid_Photo . '">';
    } else {
      ?>
      <div id="mainSlider<?php echo $slider->Slid_Id; ?>" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <?php
          $vActive = 'class="active"';
          for ($index = 0; $index < $nSlides; $index++) {
            ?>
            <li data-target="#mainSlider<?php echo $slider->Slid_Id; ?>" data-slide-to="<?php echo $index; ?>" <?php echo $vActive; ?>></li>
            <?php
            $vActive = "";
          }
          ?>
        </ol>
        <div class="carousel-inner">
          <?php
          $vActive = "active";
          foreach ($slider->aSlides as $cSlide) {
            ?>
            <div class="carousel-item <?php echo $vActive; ?>">
              <img class="d-block w-100 h-75" src="assets/img/mainSlider/<?php echo $cSlide->Slid_Photo; ?>">
            </div>
            <?php
            $vActive = "";
          }
          ?>
          <a class="carousel-control-prev" href="#mainSlider<?php echo $slider->Slid_Id; ?>" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#mainSlider<?php echo $slider->Slid_Id; ?>" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <?php
    }
    ?>
  </section>
  <!-- End Hero Section -->
  <?php
}
