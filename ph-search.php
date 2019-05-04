<section class="container p-5">
  <?php
  /*
    $aPages = cPage::getSearchArray($vSText);
    $nCount = count($aPages);
    echo "Searching for : " . $vSText . "&nbsp;&nbsp;<strong>" . $nCount . "</strong>&nbsp;&nbsp;pages(s) found";
    if ($nCount > 0) {
    ?>
    <?php
    foreach ($aPages as $page) {
    ?>
    <div class="row">
    <div class="col col-12">
    <a class="ph-menu-link nav-link" data-mid="0" data-mode="0" data-page="<?php echo $page->Page_Id; ?>"><?php echo $page->Page_Name; ?></a>
    </div>
    <div class="col col-12 px-5">
    <div class="px-5">
    <?php echo $page->Page_Desc; ?></a>
    </div>
    </div>
    </div>
    <?php
    }
    }
   *
   */
  $aMenu = cMenu::getSearchArray($vSText);
  $nCount = count($aMenu);
  if ($nCount > 0) {
    ?>
    <?php
    echo "Searching for : " . $vSText . "&nbsp;&nbsp;<strong>" . $nCount . "</strong>&nbsp;&nbsp;pages(s) found";
    foreach ($aMenu as $menu) {
      $vBreadcrumb = cMenu::getBreadcrumb($menu->Menu_Id);
      $pMenu = cMenu::getInstance($menu->Menu_PId, false);
      $page = cPage::getInstance($menu->Page_Id);
      ?>
      <div class="row mt-5">
        <div class="col col-12">
    <!--          <a class="ph-menu-link nav-link search-link" data-mid="<?php echo $menu->Menu_Id; ?>" data-mode="<?php echo $menu->Mode_Id; ?>" data-page="<?php echo $menu->Page_Id; ?>"><?php echo $pMenu->Menu_Name; ?> > <?php echo $menu->Menu_Name; ?></a>-->
          <a class="ph-menu-link nav-link search-link" data-mid="<?php echo $menu->Menu_Id; ?>" data-mode="<?php echo $menu->Mode_Id; ?>" data-page="<?php echo $menu->Page_Id; ?>"><?php echo $vBreadcrumb; ?></a>
        </div>
        <div class="col col-12 px-5">
          <div class="px-5">
            <?php echo $page->Page_Desc; ?></a>
          </div>
        </div>
      </div>
      <?php
    }
  }
  ?>
</section>
