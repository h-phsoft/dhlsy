<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cBlockDetail {

  var $DBlk_Id;
  var $Blk_Id;
  var $DBlk_Order;
  var $DBlk_Status;
  var $DBlk_Type;
  var $DBlk_Name;
  var $DBlk_Image;
  var $DBlk_Text;
  var $DBlk_SText;

  public static function getArray($nPId) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `dblk_id`, `blk_id`, `dblk_order`, `dblk_status`, `dblk_type`, `dblk_name`, `dblk_image`, `dblk_text`, `dblk_stext`'
            . ' FROM `cpy_block_detail`'
            . ' WHERE (`dblk_status`=1)';
    if ($nPId != "") {
      $sSQL .= ' AND (`blk_id`=' . $nPId . ')';
    }
    $sSQL .= ' ORDER BY `dblk_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cBlockDetail::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cBlockDetail();
    $sSQL = 'SELECT `dblk_id`, `blk_id`, `dblk_order`, `dblk_status`, `dblk_type`, `dblk_name`, `dblk_image`, `dblk_text`, `dblk_stext`'
            . ' FROM `cpy_block_detail`'
            . ' WHERE (`dblk_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cBlockDetail::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cBlockDetail();
    $cClass->DBlk_Id = $res->fields("dblk_id");
    $cClass->Blk_Id = $res->fields("blk_id");
    $cClass->DBlk_Order = $res->fields("dblk_order");
    $cClass->DBlk_Status = $res->fields("dblk_status");
    $cClass->DBlk_Type = $res->fields("dblk_type");
    $cClass->DBlk_Name = $res->fields("dblk_name");
    $cClass->DBlk_Image = $res->fields("dblk_image");
    $cClass->DBlk_Text = $res->fields("dblk_text");
    $cClass->DBlk_SText = $res->fields("dblk_stext");
    return $cClass;
  }

}
