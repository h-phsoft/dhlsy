<?php

// slid_name
// slid_rem

?>
<?php if ($cpy_slider_mst->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_cpy_slider_mstmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($cpy_slider_mst->slid_name->Visible) { // slid_name ?>
		<tr id="r_slid_name">
			<td class="col-sm-2"><?php echo $cpy_slider_mst->slid_name->FldCaption() ?></td>
			<td<?php echo $cpy_slider_mst->slid_name->CellAttributes() ?>>
<span id="el_cpy_slider_mst_slid_name">
<span<?php echo $cpy_slider_mst->slid_name->ViewAttributes() ?>>
<?php echo $cpy_slider_mst->slid_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_slider_mst->slid_rem->Visible) { // slid_rem ?>
		<tr id="r_slid_rem">
			<td class="col-sm-2"><?php echo $cpy_slider_mst->slid_rem->FldCaption() ?></td>
			<td<?php echo $cpy_slider_mst->slid_rem->CellAttributes() ?>>
<span id="el_cpy_slider_mst_slid_rem">
<span<?php echo $cpy_slider_mst->slid_rem->ViewAttributes() ?>>
<?php echo $cpy_slider_mst->slid_rem->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
