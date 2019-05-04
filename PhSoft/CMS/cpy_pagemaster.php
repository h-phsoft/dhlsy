<?php

// page_name
// page_status
// slid_id
// page_stext

?>
<?php if ($cpy_page->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_cpy_pagemaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($cpy_page->page_name->Visible) { // page_name ?>
		<tr id="r_page_name">
			<td class="col-sm-2"><?php echo $cpy_page->page_name->FldCaption() ?></td>
			<td<?php echo $cpy_page->page_name->CellAttributes() ?>>
<span id="el_cpy_page_page_name">
<span<?php echo $cpy_page->page_name->ViewAttributes() ?>>
<?php echo $cpy_page->page_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_page->page_status->Visible) { // page_status ?>
		<tr id="r_page_status">
			<td class="col-sm-2"><?php echo $cpy_page->page_status->FldCaption() ?></td>
			<td<?php echo $cpy_page->page_status->CellAttributes() ?>>
<span id="el_cpy_page_page_status">
<span<?php echo $cpy_page->page_status->ViewAttributes() ?>>
<?php echo $cpy_page->page_status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_page->slid_id->Visible) { // slid_id ?>
		<tr id="r_slid_id">
			<td class="col-sm-2"><?php echo $cpy_page->slid_id->FldCaption() ?></td>
			<td<?php echo $cpy_page->slid_id->CellAttributes() ?>>
<span id="el_cpy_page_slid_id">
<span<?php echo $cpy_page->slid_id->ViewAttributes() ?>>
<?php echo $cpy_page->slid_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_page->page_stext->Visible) { // page_stext ?>
		<tr id="r_page_stext">
			<td class="col-sm-2"><?php echo $cpy_page->page_stext->FldCaption() ?></td>
			<td<?php echo $cpy_page->page_stext->CellAttributes() ?>>
<span id="el_cpy_page_page_stext">
<span<?php echo $cpy_page->page_stext->ViewAttributes() ?>>
<?php echo $cpy_page->page_stext->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
