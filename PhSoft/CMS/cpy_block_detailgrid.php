<?php include_once "phs_usersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_block_detail_grid)) $cpy_block_detail_grid = new ccpy_block_detail_grid();

// Page init
$cpy_block_detail_grid->Page_Init();

// Page main
$cpy_block_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_block_detail_grid->Page_Render();
?>
<?php if ($cpy_block_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcpy_block_detailgrid = new ew_Form("fcpy_block_detailgrid", "grid");
fcpy_block_detailgrid.FormKeyCountName = '<?php echo $cpy_block_detail_grid->FormKeyCountName ?>';

// Validate form
fcpy_block_detailgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_blk_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->blk_id->FldCaption(), $cpy_block_detail->blk_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_order->FldCaption(), $cpy_block_detail->dblk_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_block_detail->dblk_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dblk_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_type->FldCaption(), $cpy_block_detail->dblk_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_status->FldCaption(), $cpy_block_detail->dblk_status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_name->FldCaption(), $cpy_block_detail->dblk_name->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcpy_block_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "blk_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dblk_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dblk_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dblk_status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dblk_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dblk_image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dblk_stext", false)) return false;
	return true;
}

// Form_CustomValidate event
fcpy_block_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_block_detailgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_block_detailgrid.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_block_detailgrid.Lists["x_blk_id"].Data = "<?php echo $cpy_block_detail_grid->blk_id->LookupFilterQuery(FALSE, "grid") ?>";
fcpy_block_detailgrid.Lists["x_dblk_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_block_detailgrid.Lists["x_dblk_type"].Options = <?php echo json_encode($cpy_block_detail_grid->dblk_type->Options()) ?>;
fcpy_block_detailgrid.Lists["x_dblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_block_detailgrid.Lists["x_dblk_status"].Options = <?php echo json_encode($cpy_block_detail_grid->dblk_status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($cpy_block_detail->CurrentAction == "gridadd") {
	if ($cpy_block_detail->CurrentMode == "copy") {
		$bSelectLimit = $cpy_block_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cpy_block_detail_grid->TotalRecs = $cpy_block_detail->ListRecordCount();
			$cpy_block_detail_grid->Recordset = $cpy_block_detail_grid->LoadRecordset($cpy_block_detail_grid->StartRec-1, $cpy_block_detail_grid->DisplayRecs);
		} else {
			if ($cpy_block_detail_grid->Recordset = $cpy_block_detail_grid->LoadRecordset())
				$cpy_block_detail_grid->TotalRecs = $cpy_block_detail_grid->Recordset->RecordCount();
		}
		$cpy_block_detail_grid->StartRec = 1;
		$cpy_block_detail_grid->DisplayRecs = $cpy_block_detail_grid->TotalRecs;
	} else {
		$cpy_block_detail->CurrentFilter = "0=1";
		$cpy_block_detail_grid->StartRec = 1;
		$cpy_block_detail_grid->DisplayRecs = $cpy_block_detail->GridAddRowCount;
	}
	$cpy_block_detail_grid->TotalRecs = $cpy_block_detail_grid->DisplayRecs;
	$cpy_block_detail_grid->StopRec = $cpy_block_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $cpy_block_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_block_detail_grid->TotalRecs <= 0)
			$cpy_block_detail_grid->TotalRecs = $cpy_block_detail->ListRecordCount();
	} else {
		if (!$cpy_block_detail_grid->Recordset && ($cpy_block_detail_grid->Recordset = $cpy_block_detail_grid->LoadRecordset()))
			$cpy_block_detail_grid->TotalRecs = $cpy_block_detail_grid->Recordset->RecordCount();
	}
	$cpy_block_detail_grid->StartRec = 1;
	$cpy_block_detail_grid->DisplayRecs = $cpy_block_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cpy_block_detail_grid->Recordset = $cpy_block_detail_grid->LoadRecordset($cpy_block_detail_grid->StartRec-1, $cpy_block_detail_grid->DisplayRecs);

	// Set no record found message
	if ($cpy_block_detail->CurrentAction == "" && $cpy_block_detail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_block_detail_grid->setWarningMessage(ew_DeniedMsg());
		if ($cpy_block_detail_grid->SearchWhere == "0=101")
			$cpy_block_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_block_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cpy_block_detail_grid->RenderOtherOptions();
?>
<?php $cpy_block_detail_grid->ShowPageHeader(); ?>
<?php
$cpy_block_detail_grid->ShowMessage();
?>
<?php if ($cpy_block_detail_grid->TotalRecs > 0 || $cpy_block_detail->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_block_detail_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_block_detail">
<div id="fcpy_block_detailgrid" class="ewForm ewListForm form-inline">
<?php if ($cpy_block_detail_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($cpy_block_detail_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_cpy_block_detail" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_cpy_block_detailgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_block_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_block_detail_grid->RenderListOptions();

// Render list options (header, left)
$cpy_block_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($cpy_block_detail->blk_id->Visible) { // blk_id ?>
	<?php if ($cpy_block_detail->SortUrl($cpy_block_detail->blk_id) == "") { ?>
		<th data-name="blk_id" class="<?php echo $cpy_block_detail->blk_id->HeaderCellClass() ?>"><div id="elh_cpy_block_detail_blk_id" class="cpy_block_detail_blk_id"><div class="ewTableHeaderCaption"><?php echo $cpy_block_detail->blk_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="blk_id" class="<?php echo $cpy_block_detail->blk_id->HeaderCellClass() ?>"><div><div id="elh_cpy_block_detail_blk_id" class="cpy_block_detail_blk_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_block_detail->blk_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_block_detail->blk_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_block_detail->blk_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_block_detail->dblk_order->Visible) { // dblk_order ?>
	<?php if ($cpy_block_detail->SortUrl($cpy_block_detail->dblk_order) == "") { ?>
		<th data-name="dblk_order" class="<?php echo $cpy_block_detail->dblk_order->HeaderCellClass() ?>"><div id="elh_cpy_block_detail_dblk_order" class="cpy_block_detail_dblk_order"><div class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dblk_order" class="<?php echo $cpy_block_detail->dblk_order->HeaderCellClass() ?>"><div><div id="elh_cpy_block_detail_dblk_order" class="cpy_block_detail_dblk_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_block_detail->dblk_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_block_detail->dblk_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_block_detail->dblk_type->Visible) { // dblk_type ?>
	<?php if ($cpy_block_detail->SortUrl($cpy_block_detail->dblk_type) == "") { ?>
		<th data-name="dblk_type" class="<?php echo $cpy_block_detail->dblk_type->HeaderCellClass() ?>"><div id="elh_cpy_block_detail_dblk_type" class="cpy_block_detail_dblk_type"><div class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dblk_type" class="<?php echo $cpy_block_detail->dblk_type->HeaderCellClass() ?>"><div><div id="elh_cpy_block_detail_dblk_type" class="cpy_block_detail_dblk_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_block_detail->dblk_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_block_detail->dblk_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_block_detail->dblk_status->Visible) { // dblk_status ?>
	<?php if ($cpy_block_detail->SortUrl($cpy_block_detail->dblk_status) == "") { ?>
		<th data-name="dblk_status" class="<?php echo $cpy_block_detail->dblk_status->HeaderCellClass() ?>"><div id="elh_cpy_block_detail_dblk_status" class="cpy_block_detail_dblk_status"><div class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dblk_status" class="<?php echo $cpy_block_detail->dblk_status->HeaderCellClass() ?>"><div><div id="elh_cpy_block_detail_dblk_status" class="cpy_block_detail_dblk_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_block_detail->dblk_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_block_detail->dblk_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_block_detail->dblk_name->Visible) { // dblk_name ?>
	<?php if ($cpy_block_detail->SortUrl($cpy_block_detail->dblk_name) == "") { ?>
		<th data-name="dblk_name" class="<?php echo $cpy_block_detail->dblk_name->HeaderCellClass() ?>"><div id="elh_cpy_block_detail_dblk_name" class="cpy_block_detail_dblk_name"><div class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dblk_name" class="<?php echo $cpy_block_detail->dblk_name->HeaderCellClass() ?>"><div><div id="elh_cpy_block_detail_dblk_name" class="cpy_block_detail_dblk_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_block_detail->dblk_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_block_detail->dblk_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_block_detail->dblk_image->Visible) { // dblk_image ?>
	<?php if ($cpy_block_detail->SortUrl($cpy_block_detail->dblk_image) == "") { ?>
		<th data-name="dblk_image" class="<?php echo $cpy_block_detail->dblk_image->HeaderCellClass() ?>"><div id="elh_cpy_block_detail_dblk_image" class="cpy_block_detail_dblk_image"><div class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dblk_image" class="<?php echo $cpy_block_detail->dblk_image->HeaderCellClass() ?>"><div><div id="elh_cpy_block_detail_dblk_image" class="cpy_block_detail_dblk_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_block_detail->dblk_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_block_detail->dblk_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_block_detail->dblk_stext->Visible) { // dblk_stext ?>
	<?php if ($cpy_block_detail->SortUrl($cpy_block_detail->dblk_stext) == "") { ?>
		<th data-name="dblk_stext" class="<?php echo $cpy_block_detail->dblk_stext->HeaderCellClass() ?>"><div id="elh_cpy_block_detail_dblk_stext" class="cpy_block_detail_dblk_stext"><div class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_stext->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dblk_stext" class="<?php echo $cpy_block_detail->dblk_stext->HeaderCellClass() ?>"><div><div id="elh_cpy_block_detail_dblk_stext" class="cpy_block_detail_dblk_stext">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_block_detail->dblk_stext->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_block_detail->dblk_stext->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_block_detail->dblk_stext->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_block_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cpy_block_detail_grid->StartRec = 1;
$cpy_block_detail_grid->StopRec = $cpy_block_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_block_detail_grid->FormKeyCountName) && ($cpy_block_detail->CurrentAction == "gridadd" || $cpy_block_detail->CurrentAction == "gridedit" || $cpy_block_detail->CurrentAction == "F")) {
		$cpy_block_detail_grid->KeyCount = $objForm->GetValue($cpy_block_detail_grid->FormKeyCountName);
		$cpy_block_detail_grid->StopRec = $cpy_block_detail_grid->StartRec + $cpy_block_detail_grid->KeyCount - 1;
	}
}
$cpy_block_detail_grid->RecCnt = $cpy_block_detail_grid->StartRec - 1;
if ($cpy_block_detail_grid->Recordset && !$cpy_block_detail_grid->Recordset->EOF) {
	$cpy_block_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $cpy_block_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $cpy_block_detail_grid->StartRec > 1)
		$cpy_block_detail_grid->Recordset->Move($cpy_block_detail_grid->StartRec - 1);
} elseif (!$cpy_block_detail->AllowAddDeleteRow && $cpy_block_detail_grid->StopRec == 0) {
	$cpy_block_detail_grid->StopRec = $cpy_block_detail->GridAddRowCount;
}

// Initialize aggregate
$cpy_block_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_block_detail->ResetAttrs();
$cpy_block_detail_grid->RenderRow();
if ($cpy_block_detail->CurrentAction == "gridadd")
	$cpy_block_detail_grid->RowIndex = 0;
if ($cpy_block_detail->CurrentAction == "gridedit")
	$cpy_block_detail_grid->RowIndex = 0;
while ($cpy_block_detail_grid->RecCnt < $cpy_block_detail_grid->StopRec) {
	$cpy_block_detail_grid->RecCnt++;
	if (intval($cpy_block_detail_grid->RecCnt) >= intval($cpy_block_detail_grid->StartRec)) {
		$cpy_block_detail_grid->RowCnt++;
		if ($cpy_block_detail->CurrentAction == "gridadd" || $cpy_block_detail->CurrentAction == "gridedit" || $cpy_block_detail->CurrentAction == "F") {
			$cpy_block_detail_grid->RowIndex++;
			$objForm->Index = $cpy_block_detail_grid->RowIndex;
			if ($objForm->HasValue($cpy_block_detail_grid->FormActionName))
				$cpy_block_detail_grid->RowAction = strval($objForm->GetValue($cpy_block_detail_grid->FormActionName));
			elseif ($cpy_block_detail->CurrentAction == "gridadd")
				$cpy_block_detail_grid->RowAction = "insert";
			else
				$cpy_block_detail_grid->RowAction = "";
		}

		// Set up key count
		$cpy_block_detail_grid->KeyCount = $cpy_block_detail_grid->RowIndex;

		// Init row class and style
		$cpy_block_detail->ResetAttrs();
		$cpy_block_detail->CssClass = "";
		if ($cpy_block_detail->CurrentAction == "gridadd") {
			if ($cpy_block_detail->CurrentMode == "copy") {
				$cpy_block_detail_grid->LoadRowValues($cpy_block_detail_grid->Recordset); // Load row values
				$cpy_block_detail_grid->SetRecordKey($cpy_block_detail_grid->RowOldKey, $cpy_block_detail_grid->Recordset); // Set old record key
			} else {
				$cpy_block_detail_grid->LoadRowValues(); // Load default values
				$cpy_block_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cpy_block_detail_grid->LoadRowValues($cpy_block_detail_grid->Recordset); // Load row values
		}
		$cpy_block_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_block_detail->CurrentAction == "gridadd") // Grid add
			$cpy_block_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cpy_block_detail->CurrentAction == "gridadd" && $cpy_block_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cpy_block_detail_grid->RestoreCurrentRowFormValues($cpy_block_detail_grid->RowIndex); // Restore form values
		if ($cpy_block_detail->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_block_detail->EventCancelled) {
				$cpy_block_detail_grid->RestoreCurrentRowFormValues($cpy_block_detail_grid->RowIndex); // Restore form values
			}
			if ($cpy_block_detail_grid->RowAction == "insert")
				$cpy_block_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_block_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_block_detail->CurrentAction == "gridedit" && ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT || $cpy_block_detail->RowType == EW_ROWTYPE_ADD) && $cpy_block_detail->EventCancelled) // Update failed
			$cpy_block_detail_grid->RestoreCurrentRowFormValues($cpy_block_detail_grid->RowIndex); // Restore form values
		if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_block_detail_grid->EditRowCnt++;
		if ($cpy_block_detail->CurrentAction == "F") // Confirm row
			$cpy_block_detail_grid->RestoreCurrentRowFormValues($cpy_block_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cpy_block_detail->RowAttrs = array_merge($cpy_block_detail->RowAttrs, array('data-rowindex'=>$cpy_block_detail_grid->RowCnt, 'id'=>'r' . $cpy_block_detail_grid->RowCnt . '_cpy_block_detail', 'data-rowtype'=>$cpy_block_detail->RowType));

		// Render row
		$cpy_block_detail_grid->RenderRow();

		// Render list options
		$cpy_block_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_block_detail_grid->RowAction <> "delete" && $cpy_block_detail_grid->RowAction <> "insertdelete" && !($cpy_block_detail_grid->RowAction == "insert" && $cpy_block_detail->CurrentAction == "F" && $cpy_block_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $cpy_block_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_block_detail_grid->ListOptions->Render("body", "left", $cpy_block_detail_grid->RowCnt);
?>
	<?php if ($cpy_block_detail->blk_id->Visible) { // blk_id ?>
		<td data-name="blk_id"<?php echo $cpy_block_detail->blk_id->CellAttributes() ?>>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_block_detail->blk_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_blk_id" class="form-group cpy_block_detail_blk_id">
<span<?php echo $cpy_block_detail->blk_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->blk_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_blk_id" class="form-group cpy_block_detail_blk_id">
<select data-table="cpy_block_detail" data-field="x_blk_id" data-value-separator="<?php echo $cpy_block_detail->blk_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id"<?php echo $cpy_block_detail->blk_id->EditAttributes() ?>>
<?php echo $cpy_block_detail->blk_id->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_blk_id" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_block_detail->blk_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_blk_id" class="form-group cpy_block_detail_blk_id">
<span<?php echo $cpy_block_detail->blk_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->blk_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_blk_id" class="form-group cpy_block_detail_blk_id">
<select data-table="cpy_block_detail" data-field="x_blk_id" data-value-separator="<?php echo $cpy_block_detail->blk_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id"<?php echo $cpy_block_detail->blk_id->EditAttributes() ?>>
<?php echo $cpy_block_detail->blk_id->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_blk_id" class="cpy_block_detail_blk_id">
<span<?php echo $cpy_block_detail->blk_id->ViewAttributes() ?>>
<?php echo $cpy_block_detail->blk_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_blk_id" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_blk_id" name="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" id="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_blk_id" name="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" id="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_id" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_id" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_id" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT || $cpy_block_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_id" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_block_detail->dblk_order->Visible) { // dblk_order ?>
		<td data-name="dblk_order"<?php echo $cpy_block_detail->dblk_order->CellAttributes() ?>>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_order" class="form-group cpy_block_detail_dblk_order">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_order" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_order->EditValue ?>"<?php echo $cpy_block_detail->dblk_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_order" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_order" class="form-group cpy_block_detail_dblk_order">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_order" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_order->EditValue ?>"<?php echo $cpy_block_detail->dblk_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_order" class="cpy_block_detail_dblk_order">
<span<?php echo $cpy_block_detail->dblk_order->ViewAttributes() ?>>
<?php echo $cpy_block_detail->dblk_order->ListViewValue() ?></span>
</span>
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_order" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_order" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_order" name="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_order" name="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_type->Visible) { // dblk_type ?>
		<td data-name="dblk_type"<?php echo $cpy_block_detail->dblk_type->CellAttributes() ?>>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_type" class="form-group cpy_block_detail_dblk_type">
<select data-table="cpy_block_detail" data-field="x_dblk_type" data-value-separator="<?php echo $cpy_block_detail->dblk_type->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type"<?php echo $cpy_block_detail->dblk_type->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_type->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type") ?>
</select>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_type" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_type->OldValue) ?>">
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_type" class="form-group cpy_block_detail_dblk_type">
<select data-table="cpy_block_detail" data-field="x_dblk_type" data-value-separator="<?php echo $cpy_block_detail->dblk_type->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type"<?php echo $cpy_block_detail->dblk_type->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_type->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_type" class="cpy_block_detail_dblk_type">
<span<?php echo $cpy_block_detail->dblk_type->ViewAttributes() ?>>
<?php echo $cpy_block_detail->dblk_type->ListViewValue() ?></span>
</span>
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_type" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_type->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_type" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_type->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_type" name="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" id="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_type->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_type" name="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" id="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_type->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_status->Visible) { // dblk_status ?>
		<td data-name="dblk_status"<?php echo $cpy_block_detail->dblk_status->CellAttributes() ?>>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_status" class="form-group cpy_block_detail_dblk_status">
<select data-table="cpy_block_detail" data-field="x_dblk_status" data-value-separator="<?php echo $cpy_block_detail->dblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status"<?php echo $cpy_block_detail->dblk_status->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_status->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_status" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_status->OldValue) ?>">
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_status" class="form-group cpy_block_detail_dblk_status">
<select data-table="cpy_block_detail" data-field="x_dblk_status" data-value-separator="<?php echo $cpy_block_detail->dblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status"<?php echo $cpy_block_detail->dblk_status->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_status->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_status" class="cpy_block_detail_dblk_status">
<span<?php echo $cpy_block_detail->dblk_status->ViewAttributes() ?>>
<?php echo $cpy_block_detail->dblk_status->ListViewValue() ?></span>
</span>
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_status" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_status->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_status" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_status" name="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" id="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_status->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_status" name="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" id="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_name->Visible) { // dblk_name ?>
		<td data-name="dblk_name"<?php echo $cpy_block_detail->dblk_name->CellAttributes() ?>>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_name" class="form-group cpy_block_detail_dblk_name">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_name" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_name->EditValue ?>"<?php echo $cpy_block_detail->dblk_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_name" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->OldValue) ?>">
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_name" class="form-group cpy_block_detail_dblk_name">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_name" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_name->EditValue ?>"<?php echo $cpy_block_detail->dblk_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_name" class="cpy_block_detail_dblk_name">
<span<?php echo $cpy_block_detail->dblk_name->ViewAttributes() ?>>
<?php echo $cpy_block_detail->dblk_name->ListViewValue() ?></span>
</span>
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_name" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_name" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_name" name="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_name" name="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_image->Visible) { // dblk_image ?>
		<td data-name="dblk_image"<?php echo $cpy_block_detail->dblk_image->CellAttributes() ?>>
<?php if ($cpy_block_detail_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_cpy_block_detail_dblk_image" class="form-group cpy_block_detail_dblk_image">
<div id="fd_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image">
<span title="<?php echo $cpy_block_detail->dblk_image->FldTitle() ? $cpy_block_detail->dblk_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_block_detail->dblk_image->ReadOnly || $cpy_block_detail->dblk_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_block_detail" data-field="x_dblk_image" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image"<?php echo $cpy_block_detail->dblk_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fn_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fs_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fx_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fm_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_image" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_image->OldValue) ?>">
<?php } elseif ($cpy_block_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_image" class="cpy_block_detail_dblk_image">
<span>
<?php echo ew_GetFileViewTag($cpy_block_detail->dblk_image, $cpy_block_detail->dblk_image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_image" class="form-group cpy_block_detail_dblk_image">
<div id="fd_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image">
<span title="<?php echo $cpy_block_detail->dblk_image->FldTitle() ? $cpy_block_detail->dblk_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_block_detail->dblk_image->ReadOnly || $cpy_block_detail->dblk_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_block_detail" data-field="x_dblk_image" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image"<?php echo $cpy_block_detail->dblk_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fn_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fs_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fx_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fm_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_stext->Visible) { // dblk_stext ?>
		<td data-name="dblk_stext"<?php echo $cpy_block_detail->dblk_stext->CellAttributes() ?>>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_stext" class="form-group cpy_block_detail_dblk_stext">
<textarea data-table="cpy_block_detail" data-field="x_dblk_stext" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_block_detail->dblk_stext->EditAttributes() ?>><?php echo $cpy_block_detail->dblk_stext->EditValue ?></textarea>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_stext" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->OldValue) ?>">
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_stext" class="form-group cpy_block_detail_dblk_stext">
<textarea data-table="cpy_block_detail" data-field="x_dblk_stext" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_block_detail->dblk_stext->EditAttributes() ?>><?php echo $cpy_block_detail->dblk_stext->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_block_detail_grid->RowCnt ?>_cpy_block_detail_dblk_stext" class="cpy_block_detail_dblk_stext">
<span<?php echo $cpy_block_detail->dblk_stext->ViewAttributes() ?>>
<?php echo $cpy_block_detail->dblk_stext->ListViewValue() ?></span>
</span>
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_stext" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_stext" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_stext" name="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="fcpy_block_detailgrid$x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->FormValue) ?>">
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_stext" name="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="fcpy_block_detailgrid$o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_block_detail_grid->ListOptions->Render("body", "right", $cpy_block_detail_grid->RowCnt);
?>
	</tr>
<?php if ($cpy_block_detail->RowType == EW_ROWTYPE_ADD || $cpy_block_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_block_detailgrid.UpdateOpts(<?php echo $cpy_block_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_block_detail->CurrentAction <> "gridadd" || $cpy_block_detail->CurrentMode == "copy")
		if (!$cpy_block_detail_grid->Recordset->EOF) $cpy_block_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_block_detail->CurrentMode == "add" || $cpy_block_detail->CurrentMode == "copy" || $cpy_block_detail->CurrentMode == "edit") {
		$cpy_block_detail_grid->RowIndex = '$rowindex$';
		$cpy_block_detail_grid->LoadRowValues();

		// Set row properties
		$cpy_block_detail->ResetAttrs();
		$cpy_block_detail->RowAttrs = array_merge($cpy_block_detail->RowAttrs, array('data-rowindex'=>$cpy_block_detail_grid->RowIndex, 'id'=>'r0_cpy_block_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_block_detail->RowAttrs["class"], "ewTemplate");
		$cpy_block_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_block_detail_grid->RenderRow();

		// Render list options
		$cpy_block_detail_grid->RenderListOptions();
		$cpy_block_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_block_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_block_detail_grid->ListOptions->Render("body", "left", $cpy_block_detail_grid->RowIndex);
?>
	<?php if ($cpy_block_detail->blk_id->Visible) { // blk_id ?>
		<td data-name="blk_id">
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<?php if ($cpy_block_detail->blk_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_block_detail_blk_id" class="form-group cpy_block_detail_blk_id">
<span<?php echo $cpy_block_detail->blk_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->blk_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_block_detail_blk_id" class="form-group cpy_block_detail_blk_id">
<select data-table="cpy_block_detail" data-field="x_blk_id" data-value-separator="<?php echo $cpy_block_detail->blk_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id"<?php echo $cpy_block_detail->blk_id->EditAttributes() ?>>
<?php echo $cpy_block_detail->blk_id->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cpy_block_detail_blk_id" class="form-group cpy_block_detail_blk_id">
<span<?php echo $cpy_block_detail->blk_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->blk_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_blk_id" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_blk_id" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_order->Visible) { // dblk_order ?>
		<td data-name="dblk_order">
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_order" class="form-group cpy_block_detail_dblk_order">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_order" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_order->EditValue ?>"<?php echo $cpy_block_detail->dblk_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_order" class="form-group cpy_block_detail_dblk_order">
<span<?php echo $cpy_block_detail->dblk_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->dblk_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_order" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_order" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_order" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_type->Visible) { // dblk_type ?>
		<td data-name="dblk_type">
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_type" class="form-group cpy_block_detail_dblk_type">
<select data-table="cpy_block_detail" data-field="x_dblk_type" data-value-separator="<?php echo $cpy_block_detail->dblk_type->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type"<?php echo $cpy_block_detail->dblk_type->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_type->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_type" class="form-group cpy_block_detail_dblk_type">
<span<?php echo $cpy_block_detail->dblk_type->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->dblk_type->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_type" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_type" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_type" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_status->Visible) { // dblk_status ?>
		<td data-name="dblk_status">
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_status" class="form-group cpy_block_detail_dblk_status">
<select data-table="cpy_block_detail" data-field="x_dblk_status" data-value-separator="<?php echo $cpy_block_detail->dblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status"<?php echo $cpy_block_detail->dblk_status->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_status->SelectOptionListHtml("x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_status" class="form-group cpy_block_detail_dblk_status">
<span<?php echo $cpy_block_detail->dblk_status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->dblk_status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_status" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_status" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_status" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_name->Visible) { // dblk_name ?>
		<td data-name="dblk_name">
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_name" class="form-group cpy_block_detail_dblk_name">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_name" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_name->EditValue ?>"<?php echo $cpy_block_detail->dblk_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_name" class="form-group cpy_block_detail_dblk_name">
<span<?php echo $cpy_block_detail->dblk_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->dblk_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_name" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_name" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_name" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_image->Visible) { // dblk_image ?>
		<td data-name="dblk_image">
<span id="el$rowindex$_cpy_block_detail_dblk_image" class="form-group cpy_block_detail_dblk_image">
<div id="fd_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image">
<span title="<?php echo $cpy_block_detail->dblk_image->FldTitle() ? $cpy_block_detail->dblk_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_block_detail->dblk_image->ReadOnly || $cpy_block_detail->dblk_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_block_detail" data-field="x_dblk_image" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image"<?php echo $cpy_block_detail->dblk_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fn_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fa_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fs_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fx_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id= "fm_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_image" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_image" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_block_detail->dblk_stext->Visible) { // dblk_stext ?>
		<td data-name="dblk_stext">
<?php if ($cpy_block_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_stext" class="form-group cpy_block_detail_dblk_stext">
<textarea data-table="cpy_block_detail" data-field="x_dblk_stext" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_block_detail->dblk_stext->EditAttributes() ?>><?php echo $cpy_block_detail->dblk_stext->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_block_detail_dblk_stext" class="form-group cpy_block_detail_dblk_stext">
<span<?php echo $cpy_block_detail->dblk_stext->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->dblk_stext->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_stext" name="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="x<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_block_detail" data-field="x_dblk_stext" name="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" id="o<?php echo $cpy_block_detail_grid->RowIndex ?>_dblk_stext" value="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_block_detail_grid->ListOptions->Render("body", "right", $cpy_block_detail_grid->RowCnt);
?>
<script type="text/javascript">
fcpy_block_detailgrid.UpdateOpts(<?php echo $cpy_block_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cpy_block_detail->CurrentMode == "add" || $cpy_block_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cpy_block_detail_grid->FormKeyCountName ?>" id="<?php echo $cpy_block_detail_grid->FormKeyCountName ?>" value="<?php echo $cpy_block_detail_grid->KeyCount ?>">
<?php echo $cpy_block_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_block_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_block_detail_grid->FormKeyCountName ?>" id="<?php echo $cpy_block_detail_grid->FormKeyCountName ?>" value="<?php echo $cpy_block_detail_grid->KeyCount ?>">
<?php echo $cpy_block_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_block_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcpy_block_detailgrid">
</div>
<?php

// Close recordset
if ($cpy_block_detail_grid->Recordset)
	$cpy_block_detail_grid->Recordset->Close();
?>
<?php if ($cpy_block_detail_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($cpy_block_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cpy_block_detail_grid->TotalRecs == 0 && $cpy_block_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_block_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cpy_block_detail->Export == "") { ?>
<script type="text/javascript">
fcpy_block_detailgrid.Init();
</script>
<?php } ?>
<?php
$cpy_block_detail_grid->Page_Terminate();
?>
