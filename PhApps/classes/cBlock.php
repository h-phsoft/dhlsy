<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cBlock {

  var $Blk_Id;
  var $Blk_Name;
  var $Blk_Status;
  var $Blk_Type;
  var $Blk_SText;
  var $aDetails = array();

  public static function getArray($vCond) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `blk_id`, `blk_name`, `blk_status`, `blk_type`, `blk_stext`'
            . ' FROM `cpy_block`'
            . ' WHERE (`blk_status`=1)';
    if ($vCond != "") {
      $sSQL .= ' AND (' . $vCond . ')';
    }
    $sSQL .= ' ORDER BY `blk_name`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cBlock::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cBlock();
    $sSQL = 'SELECT `blk_id`, `blk_name`, `blk_status`, `blk_type`, `blk_stext`'
            . ' FROM `cpy_block`'
            . ' WHERE (`blk_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cBlock::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cBlock();
    $cClass->Blk_Id = $res->fields("blk_id");
    $cClass->Blk_Name = $res->fields("blk_name");
    $cClass->Blk_Status = $res->fields("blk_status");
    $cClass->Blk_Type = $res->fields("blk_type");
    $cClass->Blk_SText = $res->fields("blk_stext");
    $cClass->aDetails = cBlockDetail::getArray($cClass->Blk_Id);
    return $cClass;
  }

}
