<!-- ========== FOOTER ========== -->
<footer>
  <div class="container-fluid p-5">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-6 pl-5 follow" style="margin-top: 10px;">
          <?php
          if ($ph_Setting_Facebook == 1) {
            ?>
            Follow Us
            <a class="ml-3" href="<?php echo $ph_URL_Facebook; ?>" target="_BLANK">
              <img height="30" src="assets/img/icons/Facebook_Red.png">
            </a>
            <?php
          }
          ?>
        </div>
        <div class="col-12 col-sm-6 text-right pr-5 pt-4">
          <!-- Copyright -->
          <p class="small copyrights mb-0"><?php echo date("Y"); ?> &copy; Nazha Logistics LLC, exclusive agent of DHL Global Forwarding in Syria</p>
          <!-- End Copyright -->
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- ========== END FOOTER ========== -->
