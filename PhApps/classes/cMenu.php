<?php
header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cMenu {

  var $Menu_Id = 0;
  var $Menu_PId = 0;
  var $Menu_RId = 0;
  var $Mode_Id = 0;
  var $Type_Id = 0;
  var $Srch_Id = 0;
  var $Menu_Order = 0;
  var $Menu_Status = 1;
  var $Menu_Name = "";
  var $Menu_Icon = "";
  var $Page_Id = 0;
  var $Menu_URL = "#";
  var $aSubs = array();

  public static function getArray($nPId, $full = true) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `menu_id`, `menu_pid`, `menu_rid`, `mode_id`, `type_id`, `srch_id`, `menu_order`, `menu_status`, `menu_name`, `menu_icon`, `page_id`, `menu_href`'
            . ' FROM `cpy_menu`'
            . ' WHERE (`menu_status`=1)';
    if ($nPId != "") {
      $sSQL .= ' AND (`menu_pid`=' . $nPId . ')';
    }
    $sSQL .= ' ORDER BY `menu_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cMenu::getFields($res, $full);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getSearchArray($vKeyWords) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `menu_id`, `menu_pid`, `menu_rid`, `mode_id`, `type_id`, `srch_id`, `menu_order`, `menu_status`, `menu_name`, `menu_icon`, `page_id`, `menu_href`'
            . ' FROM `cpy_menu`'
            . ' WHERE (`menu_status`=1 AND `srch_id`=1)'
            . '   AND `page_id` IN '
            . ' (SELECT DISTINCT `page_id`'
            . '    FROM `cpy_vall`'
            . '   WHERE UPPER(`page_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . '      OR UPPER(`pblk_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . '      OR UPPER(`blk_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . '      OR UPPER(`dblk_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . ' )'
            . ' ORDER BY `menu_pid`, `menu_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cMenu::getFields($res, false);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId, $full = true) {
    $cClass = new cMenu();
    $sSQL = 'SELECT `menu_id`, `menu_pid`, `menu_rid`, `mode_id`, `type_id`, `srch_id`, `menu_order`, `menu_status`, `menu_name`, `menu_icon`, `page_id`, `menu_href`'
            . ' FROM `cpy_menu`'
            . ' WHERE (`menu_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cMenu::getFields($res, $full);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cMenu();
    $cClass->Menu_Id = $res->fields("menu_id");
    $cClass->Menu_PId = $res->fields("menu_pid");
    $cClass->Menu_RId = $res->fields("menu_rid");
    $cClass->Mode_Id = $res->fields("mode_id");
    $cClass->Type_Id = $res->fields("type_id");
    $cClass->Srch_Id = $res->fields("srch_id");
    $cClass->Menu_Order = $res->fields("menu_order");
    $cClass->Menu_Status = $res->fields("menu_status");
    $cClass->Menu_Name = $res->fields("menu_name");
    $cClass->Menu_Icon = $res->fields("menu_icon");
    $cClass->Page_Id = $res->fields("page_id");
    $cClass->Menu_URL = $res->fields("menu_href");
    if ($full) {
      $cClass->aSubs = cMenu::getArray($cClass->Menu_Id);
    }
    return $cClass;
  }

  public static function getBreadcrumb($nId) {
    $cClass = cMenu::getInstance($nId, false);
    $vRet = '';
    if (($cClass->Menu_Id != 100) && ($cClass->Menu_Id != 200)) {
      if (($cClass->Menu_PId != 100) && ($cClass->Menu_PId != 200) && ($cClass->Menu_PId != 0)) {
        $vRet = '&nbsp;&nbsp;&nbsp;>&nbsp;&nbsp;&nbsp;';
      }
      $vRet .= $cClass->Menu_Name;
    }
    if ($cClass->Menu_PId != 0) {
      $vRet = cMenu::getBreadcrumb($cClass->Menu_PId) . $vRet;
    }
    return $vRet;
  }

  public static function renderMenuItems($Menu, $vClass = "") {
    if (count($Menu->aSubs) > 0) {
      foreach ($Menu->aSubs as $cMnu) {
        if ($cMnu->Type_Id == 11) {
          if (count($cMnu->aSubs) > 0) {
            ?>
            <!-- Page Menu -->
            <li class="nav-item border-right hs-has-mega-menu u-header__nav-item <?php echo $vClass; ?>"
                data-event="click"
                data-animation-in="slideInUp"
                data-animation-out="fadeOut"
                data-position="left" style="line-height: 1">
              <a class="ph-nav-link nav-link pl-0 <?php echo $vClass; ?>" href="javascript:;"
                 aria-haspopup="true"
                 aria-expanded="false">
                   <?php echo $cMnu->Menu_Name; ?>
                <span class="glyphicon glyphicon-chevron-down u-header__nav-link-icon"></span>
              </a>
              <div class="hs-mega-menu u-header__sub-menu w-100 u-header__mega-menu-wrapper-v2 <?php echo $vClass; ?>" aria-labelledby="homeMegaMenu">
                <div class="row p-0 mr-0">
                  <div class="col-lg-12 u-header__mega-menu-wrapper-v3">
                    <div class="row u-header__mega-menu-wrapper-v1 justify-content-center">
                      <?php
                      foreach ($cMnu->aSubs as $cMenu) {
                        ?>
                        <div class="col-sm-2">
                          <div class="d-none d-sm-block col-12 text-center">
                            <a class="ph-menu-link ph-menu-image-link nav-link u-list__link" data-mid="<?php echo ($cMenu->Menu_RId == 0 ? $cMenu->Menu_Id : $cMenu->Menu_RId); ?>" data-mode="<?php echo $cMenu->Mode_Id; ?>" data-page="<?php echo $cMenu->Page_Id; ?>">
                              <img src="assets/img/icons/<?php echo $cMenu->Menu_Icon; ?>" style="width: 100%;">
                            </a>
                          </div>
                          <div class="d-none d-sm-block col-12 text-center">
                            <a class="ph-menu-link nav-link u-list__link" data-mid="<?php echo ($cMenu->Menu_RId == 0 ? $cMenu->Menu_Id : $cMenu->Menu_RId); ?>" data-mode="<?php echo $cMenu->Mode_Id; ?>" data-page="<?php echo $cMenu->Page_Id; ?>"><?php echo $cMenu->Menu_Name; ?></a>
                          </div>
                          <div class="col-12 d-block d-sm-none">
                            <a class="ph-menu-link nav-link u-list__link" data-mid="<?php echo ($cMenu->Menu_RId == 0 ? $cMenu->Menu_Id : $cMenu->Menu_RId); ?>" data-mode="<?php echo $cMenu->Mode_Id; ?>" data-page="<?php echo $cMenu->Page_Id; ?>"><?php echo $cMenu->Menu_Name; ?></a>
                          </div>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <!-- End Page Menu -->
            <?php
          }
        } elseif ($cMnu->Type_Id == 12) {
          if (count($cMnu->aSubs) > 0) {
            ?>
            <!-- Classic Menu -->
            <li class="nav-item border-right hs-has-sub-menu u-header__nav-item <?php echo $vClass; ?>"
                data-event="click"
                data-animation-in="slideInUp"
                data-animation-out="fadeOut" style="line-height: 1">
              <a class="ph-nav-link nav-link <?php echo $vClass; ?>" href="javascript:;" aria-haspopup="true" aria-expanded="false">
                <?php echo $cMnu->Menu_Name; ?>
                <span class="glyphicon glyphicon-chevron-down u-header__nav-link-icon"></span>
              </a>
              <ul class="list-inline hs-sub-menu u-header__sub-menu py-2 mb-0" style="min-width: 220px;">
                <?php
                foreach ($cMnu->aSubs as $cMenu) {
                  ?>
                  <li class="dropdown-item px-0">
                    <a class="ph-menu-link nav-link u-list__link px-4" data-mid="<?php echo ($cMenu->Menu_RId == 0 ? $cMenu->Menu_Id : $cMenu->Menu_RId); ?>" data-mode="<?php echo $cMenu->Mode_Id; ?>" data-page="<?php echo $cMenu->Page_Id; ?>"><?php echo $cMenu->Menu_Name; ?></a>
                  </li>
                  <?php
                }
                ?>
              </ul>
            </li>
            <!-- End Classic Menu -->
            <?php
          }
        } elseif ($cMnu->Type_Id == 13) {
          if (count($cMnu->aSubs) > 0) {
            ?>
            <!-- Columns Menu -->
            <li class="nav-item border-right hs-has-mega-menu u-header__nav-item <?php echo $vClass; ?>"
                data-event="click"
                data-animation-in="slideInUp"
                data-animation-out="fadeOut"
                data-position="right" style="line-height: 1">
              <a class="ph-nav-link nav-link <?php echo $vClass; ?>" href="javascript:;"
                 aria-haspopup="true"
                 aria-expanded="false">
                   <?php echo $cMnu->Menu_Name; ?>
                <span class="glyphicon glyphicon-chevron-down u-header__nav-link-icon"></span>
              </a>
              <div class="hs-mega-menu u-header__sub-menu w-auto p-4 u-header__mega-menu-wrapper-v3">
                <div class="row">
                  <?php
                  $leftBorder = "";
                  foreach ($cMnu->aSubs as $cMenu) {
                    if (count($cMenu->aSubs) > 0) {
                      ?>
                      <div class="col-sm-6 col-lg-6 mb-3 mb-lg-0" <?php echo $leftBorder; ?>>
                        <strong class="d-block mb-2"><?php echo $cMenu->Menu_Name; ?></strong>
                        <!-- Links -->
                        <ul class="list-unstyled u-list">
                          <?php
                          foreach ($cMenu->aSubs as $colMenu) {
                            ?>
                            <li><a class="ph-menu-link nav-link u-list__link py-2 px-0" data-mid="<?php echo ($colMenu->Menu_RId == 0 ? $colMenu->Menu_Id : $colMenu->Menu_RId); ?>" data-mode="<?php echo $colMenu->Mode_Id; ?>" data-page="<?php echo $colMenu->Page_Id; ?>"><?php echo $colMenu->Menu_Name; ?></a></li>
                            <?php
                          }
                          ?>
                        </ul>
                        <!-- End Links -->
                      </div>
                      <?php
                    }
                    $leftBorder = 'style="border-left: solid 1px #fc0;"';
                  }
                  ?>
                </div>
              </div>
            </li>
            <!-- End Columns Menu -->
            <?php
          }
        } elseif ($cMnu->Type_Id == 1) {
          ?>
          <li class="nav-item border-right <?php echo $vClass; ?>" style="line-height: 1">
            <a class="ph-nav-link ph-menu-link nav-link <?php echo $vClass; ?>" data-mid="<?php echo ($cMnu->Menu_RId == 0 ? $cMnu->Menu_Id : $cMnu->Menu_RId); ?>" data-mode="<?php echo $cMnu->Mode_Id; ?>" data-page="<?php echo $cMnu->Page_Id; ?>"><?php echo $cMnu->Menu_Name; ?></a>
          </li>
          <?php
        }
      }
    }
  }

}
