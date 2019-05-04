<?php

header("Access-Control-Allow-Origin: *");
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cSlide {

  var $TSlid_Id = -999;
  var $Slid_Id = -999;
  var $Slid_Order = 1;
  var $Slid_Header;
  var $Slid_Text;
  var $Slid_Photo;
  var $Slid_Link;

  public static function getArray($nPId) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `tslid_id`, `slid_id`, `slid_order`, `slid_header`, `slid_text`, `slid_photo`, `slid_link`'
            . ' FROM `cpy_slider_trn`'
            . ' WHERE (`slid_id`="' . $nPId . '")';
    $sSQL .= ' ORDER BY `slid_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cSlide::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cSlide();
    $sSQL = 'SELECT `tslid_id`, `slid_id`, `slid_order`, `slid_header`, `slid_text`, `slid_photo`, `slid_link`'
            . ' FROM `cpy_slider_trn`'
            . ' WHERE (`tslid_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cSlide::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cSlide();
    $cClass->TSlid_Id = $res->fields("tslid_id");
    $cClass->Slid_Id = $res->fields("slid_id");
    $cClass->Slid_Order = $res->fields("slid_order");
    $cClass->Slid_Header = $res->fields("slid_header");
    $cClass->Slid_Text = $res->fields("slid_text");
    $cClass->Slid_Photo = $res->fields("slid_photo");
    $cClass->Slid_Link = $res->fields("slid_link");
    return $cClass;
  }

}
