<?php include_once "phs_usersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_page_block_grid)) $cpy_page_block_grid = new ccpy_page_block_grid();

// Page init
$cpy_page_block_grid->Page_Init();

// Page main
$cpy_page_block_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_page_block_grid->Page_Render();
?>
<?php if ($cpy_page_block->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcpy_page_blockgrid = new ew_Form("fcpy_page_blockgrid", "grid");
fcpy_page_blockgrid.FormKeyCountName = '<?php echo $cpy_page_block_grid->FormKeyCountName ?>';

// Validate form
fcpy_page_blockgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_page_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->page_id->FldCaption(), $cpy_page_block->page_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_blk_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->blk_id->FldCaption(), $cpy_page_block->blk_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pblk_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->pblk_order->FldCaption(), $cpy_page_block->pblk_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pblk_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_page_block->pblk_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pblk_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->pblk_status->FldCaption(), $cpy_page_block->pblk_status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pblk_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->pblk_name->FldCaption(), $cpy_page_block->pblk_name->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcpy_page_blockgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "page_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "blk_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pblk_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pblk_status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pblk_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pblk_bgcolor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pblk_stext", false)) return false;
	return true;
}

// Form_CustomValidate event
fcpy_page_blockgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_page_blockgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_page_blockgrid.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_page_blockgrid.Lists["x_page_id"].Data = "<?php echo $cpy_page_block_grid->page_id->LookupFilterQuery(FALSE, "grid") ?>";
fcpy_page_blockgrid.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_page_blockgrid.Lists["x_blk_id"].Data = "<?php echo $cpy_page_block_grid->blk_id->LookupFilterQuery(FALSE, "grid") ?>";
fcpy_page_blockgrid.Lists["x_pblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockgrid.Lists["x_pblk_status"].Options = <?php echo json_encode($cpy_page_block_grid->pblk_status->Options()) ?>;
fcpy_page_blockgrid.Lists["x_pblk_bgcolor"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockgrid.Lists["x_pblk_bgcolor"].Options = <?php echo json_encode($cpy_page_block_grid->pblk_bgcolor->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($cpy_page_block->CurrentAction == "gridadd") {
	if ($cpy_page_block->CurrentMode == "copy") {
		$bSelectLimit = $cpy_page_block_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cpy_page_block_grid->TotalRecs = $cpy_page_block->ListRecordCount();
			$cpy_page_block_grid->Recordset = $cpy_page_block_grid->LoadRecordset($cpy_page_block_grid->StartRec-1, $cpy_page_block_grid->DisplayRecs);
		} else {
			if ($cpy_page_block_grid->Recordset = $cpy_page_block_grid->LoadRecordset())
				$cpy_page_block_grid->TotalRecs = $cpy_page_block_grid->Recordset->RecordCount();
		}
		$cpy_page_block_grid->StartRec = 1;
		$cpy_page_block_grid->DisplayRecs = $cpy_page_block_grid->TotalRecs;
	} else {
		$cpy_page_block->CurrentFilter = "0=1";
		$cpy_page_block_grid->StartRec = 1;
		$cpy_page_block_grid->DisplayRecs = $cpy_page_block->GridAddRowCount;
	}
	$cpy_page_block_grid->TotalRecs = $cpy_page_block_grid->DisplayRecs;
	$cpy_page_block_grid->StopRec = $cpy_page_block_grid->DisplayRecs;
} else {
	$bSelectLimit = $cpy_page_block_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_page_block_grid->TotalRecs <= 0)
			$cpy_page_block_grid->TotalRecs = $cpy_page_block->ListRecordCount();
	} else {
		if (!$cpy_page_block_grid->Recordset && ($cpy_page_block_grid->Recordset = $cpy_page_block_grid->LoadRecordset()))
			$cpy_page_block_grid->TotalRecs = $cpy_page_block_grid->Recordset->RecordCount();
	}
	$cpy_page_block_grid->StartRec = 1;
	$cpy_page_block_grid->DisplayRecs = $cpy_page_block_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cpy_page_block_grid->Recordset = $cpy_page_block_grid->LoadRecordset($cpy_page_block_grid->StartRec-1, $cpy_page_block_grid->DisplayRecs);

	// Set no record found message
	if ($cpy_page_block->CurrentAction == "" && $cpy_page_block_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_page_block_grid->setWarningMessage(ew_DeniedMsg());
		if ($cpy_page_block_grid->SearchWhere == "0=101")
			$cpy_page_block_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_page_block_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cpy_page_block_grid->RenderOtherOptions();
?>
<?php $cpy_page_block_grid->ShowPageHeader(); ?>
<?php
$cpy_page_block_grid->ShowMessage();
?>
<?php if ($cpy_page_block_grid->TotalRecs > 0 || $cpy_page_block->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_page_block_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_page_block">
<div id="fcpy_page_blockgrid" class="ewForm ewListForm form-inline">
<?php if ($cpy_page_block_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($cpy_page_block_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_cpy_page_block" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_cpy_page_blockgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_page_block_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_page_block_grid->RenderListOptions();

// Render list options (header, left)
$cpy_page_block_grid->ListOptions->Render("header", "left");
?>
<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->page_id) == "") { ?>
		<th data-name="page_id" class="<?php echo $cpy_page_block->page_id->HeaderCellClass() ?>"><div id="elh_cpy_page_block_page_id" class="cpy_page_block_page_id"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->page_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_id" class="<?php echo $cpy_page_block->page_id->HeaderCellClass() ?>"><div><div id="elh_cpy_page_block_page_id" class="cpy_page_block_page_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->page_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->page_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->page_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->blk_id) == "") { ?>
		<th data-name="blk_id" class="<?php echo $cpy_page_block->blk_id->HeaderCellClass() ?>"><div id="elh_cpy_page_block_blk_id" class="cpy_page_block_blk_id"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->blk_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="blk_id" class="<?php echo $cpy_page_block->blk_id->HeaderCellClass() ?>"><div><div id="elh_cpy_page_block_blk_id" class="cpy_page_block_blk_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->blk_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->blk_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->blk_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_order) == "") { ?>
		<th data-name="pblk_order" class="<?php echo $cpy_page_block->pblk_order->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_order" class="<?php echo $cpy_page_block->pblk_order->HeaderCellClass() ?>"><div><div id="elh_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_status) == "") { ?>
		<th data-name="pblk_status" class="<?php echo $cpy_page_block->pblk_status->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_status" class="<?php echo $cpy_page_block->pblk_status->HeaderCellClass() ?>"><div><div id="elh_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_name) == "") { ?>
		<th data-name="pblk_name" class="<?php echo $cpy_page_block->pblk_name->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_name" class="<?php echo $cpy_page_block->pblk_name->HeaderCellClass() ?>"><div><div id="elh_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_bgcolor) == "") { ?>
		<th data-name="pblk_bgcolor" class="<?php echo $cpy_page_block->pblk_bgcolor->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_bgcolor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_bgcolor" class="<?php echo $cpy_page_block->pblk_bgcolor->HeaderCellClass() ?>"><div><div id="elh_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_bgcolor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_bgcolor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_bgcolor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_stext) == "") { ?>
		<th data-name="pblk_stext" class="<?php echo $cpy_page_block->pblk_stext->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_stext->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_stext" class="<?php echo $cpy_page_block->pblk_stext->HeaderCellClass() ?>"><div><div id="elh_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_stext->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_stext->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_stext->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_page_block_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cpy_page_block_grid->StartRec = 1;
$cpy_page_block_grid->StopRec = $cpy_page_block_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_page_block_grid->FormKeyCountName) && ($cpy_page_block->CurrentAction == "gridadd" || $cpy_page_block->CurrentAction == "gridedit" || $cpy_page_block->CurrentAction == "F")) {
		$cpy_page_block_grid->KeyCount = $objForm->GetValue($cpy_page_block_grid->FormKeyCountName);
		$cpy_page_block_grid->StopRec = $cpy_page_block_grid->StartRec + $cpy_page_block_grid->KeyCount - 1;
	}
}
$cpy_page_block_grid->RecCnt = $cpy_page_block_grid->StartRec - 1;
if ($cpy_page_block_grid->Recordset && !$cpy_page_block_grid->Recordset->EOF) {
	$cpy_page_block_grid->Recordset->MoveFirst();
	$bSelectLimit = $cpy_page_block_grid->UseSelectLimit;
	if (!$bSelectLimit && $cpy_page_block_grid->StartRec > 1)
		$cpy_page_block_grid->Recordset->Move($cpy_page_block_grid->StartRec - 1);
} elseif (!$cpy_page_block->AllowAddDeleteRow && $cpy_page_block_grid->StopRec == 0) {
	$cpy_page_block_grid->StopRec = $cpy_page_block->GridAddRowCount;
}

// Initialize aggregate
$cpy_page_block->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_page_block->ResetAttrs();
$cpy_page_block_grid->RenderRow();
if ($cpy_page_block->CurrentAction == "gridadd")
	$cpy_page_block_grid->RowIndex = 0;
if ($cpy_page_block->CurrentAction == "gridedit")
	$cpy_page_block_grid->RowIndex = 0;
while ($cpy_page_block_grid->RecCnt < $cpy_page_block_grid->StopRec) {
	$cpy_page_block_grid->RecCnt++;
	if (intval($cpy_page_block_grid->RecCnt) >= intval($cpy_page_block_grid->StartRec)) {
		$cpy_page_block_grid->RowCnt++;
		if ($cpy_page_block->CurrentAction == "gridadd" || $cpy_page_block->CurrentAction == "gridedit" || $cpy_page_block->CurrentAction == "F") {
			$cpy_page_block_grid->RowIndex++;
			$objForm->Index = $cpy_page_block_grid->RowIndex;
			if ($objForm->HasValue($cpy_page_block_grid->FormActionName))
				$cpy_page_block_grid->RowAction = strval($objForm->GetValue($cpy_page_block_grid->FormActionName));
			elseif ($cpy_page_block->CurrentAction == "gridadd")
				$cpy_page_block_grid->RowAction = "insert";
			else
				$cpy_page_block_grid->RowAction = "";
		}

		// Set up key count
		$cpy_page_block_grid->KeyCount = $cpy_page_block_grid->RowIndex;

		// Init row class and style
		$cpy_page_block->ResetAttrs();
		$cpy_page_block->CssClass = "";
		if ($cpy_page_block->CurrentAction == "gridadd") {
			if ($cpy_page_block->CurrentMode == "copy") {
				$cpy_page_block_grid->LoadRowValues($cpy_page_block_grid->Recordset); // Load row values
				$cpy_page_block_grid->SetRecordKey($cpy_page_block_grid->RowOldKey, $cpy_page_block_grid->Recordset); // Set old record key
			} else {
				$cpy_page_block_grid->LoadRowValues(); // Load default values
				$cpy_page_block_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cpy_page_block_grid->LoadRowValues($cpy_page_block_grid->Recordset); // Load row values
		}
		$cpy_page_block->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_page_block->CurrentAction == "gridadd") // Grid add
			$cpy_page_block->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cpy_page_block->CurrentAction == "gridadd" && $cpy_page_block->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cpy_page_block_grid->RestoreCurrentRowFormValues($cpy_page_block_grid->RowIndex); // Restore form values
		if ($cpy_page_block->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_page_block->EventCancelled) {
				$cpy_page_block_grid->RestoreCurrentRowFormValues($cpy_page_block_grid->RowIndex); // Restore form values
			}
			if ($cpy_page_block_grid->RowAction == "insert")
				$cpy_page_block->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_page_block->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_page_block->CurrentAction == "gridedit" && ($cpy_page_block->RowType == EW_ROWTYPE_EDIT || $cpy_page_block->RowType == EW_ROWTYPE_ADD) && $cpy_page_block->EventCancelled) // Update failed
			$cpy_page_block_grid->RestoreCurrentRowFormValues($cpy_page_block_grid->RowIndex); // Restore form values
		if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_page_block_grid->EditRowCnt++;
		if ($cpy_page_block->CurrentAction == "F") // Confirm row
			$cpy_page_block_grid->RestoreCurrentRowFormValues($cpy_page_block_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cpy_page_block->RowAttrs = array_merge($cpy_page_block->RowAttrs, array('data-rowindex'=>$cpy_page_block_grid->RowCnt, 'id'=>'r' . $cpy_page_block_grid->RowCnt . '_cpy_page_block', 'data-rowtype'=>$cpy_page_block->RowType));

		// Render row
		$cpy_page_block_grid->RenderRow();

		// Render list options
		$cpy_page_block_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_page_block_grid->RowAction <> "delete" && $cpy_page_block_grid->RowAction <> "insertdelete" && !($cpy_page_block_grid->RowAction == "insert" && $cpy_page_block->CurrentAction == "F" && $cpy_page_block_grid->EmptyRow())) {
?>
	<tr<?php echo $cpy_page_block->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_page_block_grid->ListOptions->Render("body", "left", $cpy_page_block_grid->RowCnt);
?>
	<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
		<td data-name="page_id"<?php echo $cpy_page_block->page_id->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_page_id" class="cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<?php echo $cpy_page_block->page_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" id="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" id="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_id" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_id" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT || $cpy_page_block->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
		<td data-name="blk_id"<?php echo $cpy_page_block->blk_id->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_blk_id" class="cpy_page_block_blk_id">
<span<?php echo $cpy_page_block->blk_id->ViewAttributes() ?>>
<?php echo $cpy_page_block->blk_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
		<td data-name="pblk_order"<?php echo $cpy_page_block->pblk_order->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order">
<span<?php echo $cpy_page_block->pblk_order->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_order->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
		<td data-name="pblk_status"<?php echo $cpy_page_block->pblk_status->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status">
<span<?php echo $cpy_page_block->pblk_status->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" id="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" id="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
		<td data-name="pblk_name"<?php echo $cpy_page_block->pblk_name->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name">
<span<?php echo $cpy_page_block->pblk_name->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_name->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
		<td data-name="pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor">
<span<?php echo $cpy_page_block->pblk_bgcolor->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" id="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" id="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
		<td data-name="pblk_stext"<?php echo $cpy_page_block->pblk_stext->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_grid->RowCnt ?>_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext">
<span<?php echo $cpy_page_block->pblk_stext->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_stext->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="fcpy_page_blockgrid$x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->FormValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="fcpy_page_blockgrid$o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_page_block_grid->ListOptions->Render("body", "right", $cpy_page_block_grid->RowCnt);
?>
	</tr>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD || $cpy_page_block->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_page_blockgrid.UpdateOpts(<?php echo $cpy_page_block_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_page_block->CurrentAction <> "gridadd" || $cpy_page_block->CurrentMode == "copy")
		if (!$cpy_page_block_grid->Recordset->EOF) $cpy_page_block_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_page_block->CurrentMode == "add" || $cpy_page_block->CurrentMode == "copy" || $cpy_page_block->CurrentMode == "edit") {
		$cpy_page_block_grid->RowIndex = '$rowindex$';
		$cpy_page_block_grid->LoadRowValues();

		// Set row properties
		$cpy_page_block->ResetAttrs();
		$cpy_page_block->RowAttrs = array_merge($cpy_page_block->RowAttrs, array('data-rowindex'=>$cpy_page_block_grid->RowIndex, 'id'=>'r0_cpy_page_block', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_page_block->RowAttrs["class"], "ewTemplate");
		$cpy_page_block->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_page_block_grid->RenderRow();

		// Render list options
		$cpy_page_block_grid->RenderListOptions();
		$cpy_page_block_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_page_block->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_page_block_grid->ListOptions->Render("body", "left", $cpy_page_block_grid->RowIndex);
?>
	<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
		<td data-name="page_id">
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
		<td data-name="blk_id">
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span<?php echo $cpy_page_block->blk_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->blk_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
		<td data-name="pblk_order">
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<span<?php echo $cpy_page_block->pblk_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->pblk_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
		<td data-name="pblk_status">
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<span<?php echo $cpy_page_block->pblk_status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->pblk_status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
		<td data-name="pblk_name">
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<span<?php echo $cpy_page_block->pblk_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->pblk_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
		<td data-name="pblk_bgcolor">
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<span<?php echo $cpy_page_block->pblk_bgcolor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->pblk_bgcolor->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
		<td data-name="pblk_stext">
<?php if ($cpy_page_block->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<span<?php echo $cpy_page_block->pblk_stext->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->pblk_stext->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" id="o<?php echo $cpy_page_block_grid->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_page_block_grid->ListOptions->Render("body", "right", $cpy_page_block_grid->RowCnt);
?>
<script type="text/javascript">
fcpy_page_blockgrid.UpdateOpts(<?php echo $cpy_page_block_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cpy_page_block->CurrentMode == "add" || $cpy_page_block->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cpy_page_block_grid->FormKeyCountName ?>" id="<?php echo $cpy_page_block_grid->FormKeyCountName ?>" value="<?php echo $cpy_page_block_grid->KeyCount ?>">
<?php echo $cpy_page_block_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_page_block->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_page_block_grid->FormKeyCountName ?>" id="<?php echo $cpy_page_block_grid->FormKeyCountName ?>" value="<?php echo $cpy_page_block_grid->KeyCount ?>">
<?php echo $cpy_page_block_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_page_block->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcpy_page_blockgrid">
</div>
<?php

// Close recordset
if ($cpy_page_block_grid->Recordset)
	$cpy_page_block_grid->Recordset->Close();
?>
<?php if ($cpy_page_block_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($cpy_page_block_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cpy_page_block_grid->TotalRecs == 0 && $cpy_page_block->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_page_block_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cpy_page_block->Export == "") { ?>
<script type="text/javascript">
fcpy_page_blockgrid.Init();
</script>
<?php } ?>
<?php
$cpy_page_block_grid->Page_Terminate();
?>
