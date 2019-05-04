<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * (C) 2000-2018 PhSoft.
 */
class cPageBlock {

  var $PBlk_Id;
  var $Page_Id;
  var $Blk_Id;
  var $PBlk_Order;
  var $PBlk_Name;
  var $PBlk_Status;
  var $PBlk_BGColor;
  var $PBlk_SText;
  var $Block;

  public static function getArray($nPageId) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = 'SELECT `pblk_id`, `page_id`, `blk_id`, `pblk_order`, `pblk_name`, `pblk_status`, `pblk_bgcolor`, `pblk_stext`'
            . ' FROM `cpy_page_block`'
            . ' WHERE (`pblk_status`=1)';
    if ($nPageId != "") {
      $sSQL .= ' AND (`page_id`="' . $nPageId . '")';
    }
    $sSQL .= ' ORDER BY `pblk_order`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cPageBlock::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cPage();
    $sSQL = 'SELECT `pblk_id`, `page_id`, `blk_id`, `pblk_order`, `pblk_name`, `pblk_status`, `page_bgcolor`, `page_stext`'
            . ' FROM `cpy_page_block`'
            . ' WHERE (`pblk_id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cPageBlock::getFields($res);
        $res->Close();
      }
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cPageBlock();
    $cClass->PBlk_Id = $res->fields("pblk_id");
    $cClass->Page_Id = $res->fields("page_id");
    $cClass->Blk_Id = $res->fields("blk_id");
    $cClass->PBlk_Order = $res->fields("pblk_order");
    $cClass->PBlk_Name = $res->fields("pblk_name");
    $cClass->PBlk_Status = $res->fields("pblk_status");
    $cClass->PBlk_BGColor = $res->fields("pblk_bgcolor");
    $cClass->PBlk_Stext = $res->fields("pblk_stext");
    $cClass->Block = cBlock::getInstance($cClass->Blk_Id);
    return $cClass;
  }

}
