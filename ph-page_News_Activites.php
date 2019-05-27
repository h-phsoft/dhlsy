<?php
if ($nMenuId != "" && $nMenuId != 0) {
  $currentMenu = cMenu::getInstance($nMenuId);
  $parentMenu = cMenu::getInstance($currentMenu->Menu_PId);
  if ($currentMenu->Menu_PId != $ph_Setting_LeftMenu && $currentMenu->Menu_PId != $ph_Setting_RightMenu) {
    ?>
    <section class="text-center container-fluid">
      <div class="px-2">
        <div class="breadcrumb" style="background-color: transparent !important;">
          <span class="breadcrumb-item"><?php echo $parentMenu->Menu_Name; ?></span><span class="breadcrumb-item"><?php echo $currentMenu->Menu_Name; ?></span>
        </div>
      </div>
    </section>
    <?php
    $nSize = count($parentMenu->aSubs);
    if ($nSize > 0) {
      ?>
      <section class="container-fluid mb-3 px-5 p-0 hidden-xs-down">
        <div class="sub-nav navbar-expand-lg mt-0 p-2 hidden-xs-down" data-toggle="sticky-onscroll-sub">
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <?php
              $nIdx = 0;
              $vActive = "";
              $vBorder = "border-right";
              foreach ($parentMenu->aSubs as $cMenu) {
                if ($cMenu->Menu_Id == $currentMenu->Menu_Id) {
                  $vActive = "active";
                }
                if ($nIdx == ($nSize - 1)) {
                  $vBorder = "";
                }
                ?>
                <li class="nav-item <?php echo $vBorder; ?> sub-nav-item px-1 <?php echo $vActive; ?>">
                  <a class="ph-menu-link nav-link" data-mid="<?php echo $cMenu->Menu_Id; ?>" data-mode="<?php echo $cMenu->Mode_Id; ?>" data-page="<?php echo $cMenu->Page_Id; ?>"><?php echo $cMenu->Menu_Name; ?></a>
                </li>
                <?php
                $vActive = "";
                $nIdx ++;
              }
              ?>
            </ul>
          </div>
        </div>
      </section>
      <?php
    }
  }
}
$nBlocks = count($cPage->aBlocks);
if ($nBlocks > 0) {
  $nPBlkType = 1;
  $nOpenBlockFlg = false;
  $vCloseBlock = "";
  $vBGColor = "";
  foreach ($cPage->aBlocks as $cPageBlock) {
    $nBlkType = $cPageBlock->Block->Blk_Type;
    if ($nBlkType != $nPBlkType) {
      echo $vCloseBlock;
      $vCloseBlock = "";
      $nOpenBlockFlg = false;
    }
    $vBGColor = "";
    if ($cPageBlock->PBlk_BGColor != '0') {
      $vBGColor = ' style="background-color: ' . $cPageBlock->PBlk_BGColor . ';"';
    }
    $nPBlkType = $nBlkType;
    if ($nBlkType == 1) {
      // Text
      ?>
      <section class="text-center container-fluid p-3" <?php echo $vBGColor; ?>>
        <div class="text-center container p-0">
          <?php
          if (count($cPageBlock->Block->aDetails) > 0) {
            foreach ($cPageBlock->Block->aDetails as $cBlockDetail) {
              $vCols = "";
              if ($cBlockDetail->DBlk_Type != 12) {
                if (!$nOpenBlockFlg) {
                  echo "<div class='row'>";
                  $nOpenBlockFlg = true;
                }
                $vCols = " class='col-12 col-md-" . $cBlockDetail->DBlk_Type . "'";
                $vCloseBlock = "</div>";
              } elseif ($nOpenBlockFlg) {
                echo $vCloseBlock;
              }
              ?>
              <div <?php echo $vCols; ?>>
                <?php
                echo $cBlockDetail->DBlk_Text;
                ?>
              </div>
              <?php
            }
          }
          ?>
        </div>
      </section>
      <?php
    } elseif ($nBlkType == 2) {
      // Slider
      ?>
      <section class="text-center container-fluid p-3" <?php echo $vBGColor; ?>>
        <div class="text-center container p-0">
          <div class="px-5">
            <?php
            $nSlides = count($cPageBlock->Block->aDetails);
            if ($nSlides > 0) {
              ?>
              <div id="Slider<?php echo $cPageBlock->PBlk_Id; ?>" class="carousel slide w-100" data-ride="carousel">
                <ol class="carousel-indicators">
                  <?php
                  $vActive = 'class="active"';
                  for ($index = 0; $index < $nSlides; $index++) {
                    ?>
                    <li data-target="#Slider<?php echo $cPageBlock->PBlk_Id; ?>" data-slide-to="<?php echo $index; ?>" <?php echo $vActive; ?>></li>
                    <?php
                    $vActive = "";
                  }
                  ?>
                </ol>
                <div class="carousel-inner">
                  <?php
                  $vActive = "active";
                  foreach ($cPageBlock->Block->aDetails as $cBlockDetail) {
                    if ($cBlockDetail->DBlk_Image) {
                      ?>
                      <div class="carousel-item <?php echo $vActive; ?>">
                        <img class="d-block w-100 h-75" src="assets/img/blkImages/<?php echo $cBlockDetail->DBlk_Image; ?>">
                      </div>
                      <?php
                      $vActive = "";
                    }
                  }
                  ?>
                  <a class="carousel-control-prev" href="#Slider<?php echo $cPageBlock->PBlk_Id; ?>" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#Slider<?php echo $cPageBlock->PBlk_Id; ?>" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </section>
      <?php
    } elseif ($nBlkType == 3) {
      // Images
      ?>
      <section class="text-center container-fluid p-3" <?php echo $vBGColor; ?>>
        <div class="text-center container p-0">
          <?php
          if (count($cPageBlock->Block->aDetails) > 0) {
            foreach ($cPageBlock->Block->aDetails as $cBlockDetail) {
              $vCols = "";
              if ($cBlockDetail->DBlk_Type != 12) {
                if (!$nOpenBlockFlg) {
                  echo "<div class='row'>";
                  $nOpenBlockFlg = true;
                }
                $vCols = " class='col col-md-" . $cBlockDetail->DBlk_Type . "'";
                $vCloseBlock = "</div>";
              } elseif ($nOpenBlockFlg) {
                echo $vCloseBlock;
              }
              ?>
              <div <?php echo $vCols; ?>>
                <img src="assets/img/blkImages/<?php echo $cBlockDetail->DBlk_Image; ?>" style="width: 100%">
              </div>
              <?php
            }
          }
          ?>
        </div>
      </section>
      <?php
    } elseif ($nBlkType == 4) {
      // Wide Image
      ?>
      <section class="text-center container-fluid px-0 py-3" <?php echo $vBGColor; ?>>
        <?php
        if (count($cPageBlock->Block->aDetails) > 0) {
          foreach ($cPageBlock->Block->aDetails as $cBlockDetail) {
            if ($cBlockDetail->DBlk_Image) {
              ?>
              <img src="assets/img/blkImages/<?php echo $cBlockDetail->DBlk_Image; ?>" style="width: 100%">
              <?php
            }
          }
        }
        ?>
      </section>
      <?php
    } elseif ($nBlkType == 5) {
      // News
      $aNews = cNews::getArray("`type_id`=1");
      $aActivities = cNews::getArray("`type_id`=2");
      $nCountNews = count($aNews);
      $nCountActivities = count($aActivities);
      if ($nCountNews > 0 || $nCountActivities > 0) {
        ?>
        <section class="text-center container-fluid p-3" <?php echo $vBGColor; ?>>
          <div class="text-center container p-0">
            <div class="row">
              <div class="col-12 col-md-7 col-12 d-flex justify-content-end">
                <h1 class="news-title">NEWS & ACTIVITIES</h1>
              </div>
              <div class="col-12 col-md-5 col-12 d-flex justify-content-end px-6">
                <div class="d-flex align-items-center">
                  <div class="newsBtn d-inline p-1 btn btn-sm bg-news text-white mr-1 active" data-id="newsDiv">NEWS</div>
                  <div class="newsBtn d-inline p-1 btn btn-sm bg-news text-white mr-1" data-id="activityDiv">Activities</div>
                </div>
              </div>
            </div>
            <?php
            if ($nCountNews > 0) {
              ?>
              <div id="newsDiv" class="row d-block">
                <div id="logger"></div>
                <div id="newsSlider<?php echo $cPageBlock->PBlk_Id; ?>" class="carousel slide w-100" style="min-height: 60vh;" data-ride="carousel">
                  <ol id="newsOL<?php echo $cPageBlock->PBlk_Id; ?>" class="carousel-indicators">
                    <?php
                    $vActive = "active";
                    for ($index1 = 0; $index1 < $nCountNews; $index1++) {
                      ?>
                      <li data-target="#newsSlider<?php echo $cPageBlock->PBlk_Id; ?>" data-slide-to="<?php echo $index1; ?>" class="<?php echo $vActive; ?>"></li>
                      <?php
                      $vActive = "";
                    }
                    ?>
                  </ol>
                  <div id="newsInner<?php echo $cPageBlock->PBlk_Id; ?>" class="carousel-inner w-100">
                    <?php
                    $vActive = "active";
                    foreach ($aNews as $news) {
                      ?>
                      <div class="carousel-item <?php echo $vActive; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-12 col-md-6 p-5">
                              <h5><?php echo $news->News_Title; ?></h5>
                              <div>
                                <?php echo $news->News_Text; ?>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 p-5">
                              <img class="newsimage" data-id="<?php echo $news->News_Id; ?>" style="width: 100%" src="assets/img/newsImages/<?php echo $news->News_Image; ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                      $vActive = "";
                    }
                    ?>
                    <a class="carousel-control-prev" href="#newsSlider<?php echo $cPageBlock->PBlk_Id; ?>" role="button" data-slide="prev" style="width: 5% !important;">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#newsSlider<?php echo $cPageBlock->PBlk_Id; ?>" role="button" data-slide="next" style="width: 5% !important;">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
              </div>
              <?php
            }
            if ($nCountActivities > 0) {
              ?>
              <div id="activityDiv" class="row d-none">
                <div id="logger"></div>
                <div id="activitySlider<?php echo $cPageBlock->PBlk_Id; ?>" class="carousel slide w-100" style="min-height: 60vh;" data-ride="carousel">
                  <ol id="activityOL<?php echo $cPageBlock->PBlk_Id; ?>" class="carousel-indicators">
                    <?php
                    $vActive = "active";
                    for ($index1 = 0; $index1 < $nCountActivities; $index1++) {
                      ?>
                      <li data-target="#activitySlider<?php echo $cPageBlock->PBlk_Id; ?>" data-slide-to="<?php echo $index1; ?>" class="<?php echo $vActive; ?>"></li>
                      <?php
                      $vActive = "";
                    }
                    ?>
                  </ol>
                  <div id="activityInner<?php echo $cPageBlock->PBlk_Id; ?>" class="carousel-inner w-100">
                    <?php
                    $vActive = "active";
                    foreach ($aActivities as $news) {
                      ?>
                      <div class="carousel-item <?php echo $vActive; ?>">
                        <div class="container">
                          <div class="row">
                            <div class="col-12 col-md-6 p-5">
                              <h5><?php echo $news->News_Title; ?></h5>
                              <div>
                                <?php echo $news->News_Text; ?>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 p-5">
                              <img class="newsimage" data-id="<?php echo $news->News_Id; ?>" style="width: 100%" src="assets/img/newsImages/<?php echo $news->News_Image; ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                      $vActive = "";
                    }
                    ?>
                    <a class="carousel-control-prev" href="#activitySlider<?php echo $cPageBlock->PBlk_Id; ?>" role="button" data-slide="prev" style="width: 5% !important;">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#activitySlider<?php echo $cPageBlock->PBlk_Id; ?>" role="button" data-slide="next" style="width: 5% !important;">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </section>
        <?php
      }
    } elseif ($nBlkType == 6) {

    }
  }
}
