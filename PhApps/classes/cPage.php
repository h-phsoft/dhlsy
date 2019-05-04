<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cPage {

  var $Page_Id;
  var $Page_Name;
  var $Page_Status;
  var $Slid_Id;
  var $Page_SText;
  var $Page_Desc;
  var $Slider;
  var $aBlocks = array();

  public static function getArray($vCond) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `page_id`, `page_name`, `page_status`, `slid_id`, `page_stext`, `page_desc`'
            . ' FROM `cpy_page`'
            . ' WHERE (`page_status`=1)';
    if ($vCond != "") {
      $sSQL .= ' AND (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `page_id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cPage::getFields($res, true);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getSearchArray($vKeyWords, $full = false) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `page_id`, `page_name`, `page_status`, `slid_id`, `page_stext`, `page_desc`'
            . ' FROM `cpy_page`'
            . ' WHERE `page_id` IN'
            . ' (SELECT DISTINCT `page_id`'
            . '    FROM `cpy_vall`'
            . '   WHERE UPPER(`page_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . '      OR UPPER(`pblk_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . '      OR UPPER(`blk_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . '      OR UPPER(`dblk_stext`) LIKE UPPER("%' . $vKeyWords . '%")'
            . ' )'
            . ' ORDER BY `page_name`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cPage::getFields($res, $full);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cPage();
    $sSQL = 'SELECT `page_id`, `page_name`, `page_status`, `slid_id`, `page_stext`, `page_desc`'
            . ' FROM `cpy_page`'
            . ' WHERE (`page_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cPage::getFields($res, true);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res, $full = true) {
    $cClass = new cPage();
    $cClass->Page_Id = $res->fields("page_id");
    $cClass->Slide_Id = $res->fields("slid_id");
    $cClass->Page_Status = $res->fields("page_status");
    $cClass->Page_Name = $res->fields("page_name");
    $cClass->Page_SText = $res->fields("page_stext");
    $cClass->Page_Desc = $res->fields("page_desc");
    if ($full) {
      $cClass->Slider = cSlider::getInstanceById($cClass->Slide_Id);
      $cClass->aBlocks = cPageBlock::getArray($cClass->Page_Id);
    }
    return $cClass;
  }

}
