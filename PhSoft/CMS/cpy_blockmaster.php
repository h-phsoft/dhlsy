<?php

// blk_name
// blk_status
// blk_type
// blk_stext

?>
<?php if ($cpy_block->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_cpy_blockmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($cpy_block->blk_name->Visible) { // blk_name ?>
		<tr id="r_blk_name">
			<td class="col-sm-2"><?php echo $cpy_block->blk_name->FldCaption() ?></td>
			<td<?php echo $cpy_block->blk_name->CellAttributes() ?>>
<span id="el_cpy_block_blk_name">
<span<?php echo $cpy_block->blk_name->ViewAttributes() ?>>
<?php echo $cpy_block->blk_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_block->blk_status->Visible) { // blk_status ?>
		<tr id="r_blk_status">
			<td class="col-sm-2"><?php echo $cpy_block->blk_status->FldCaption() ?></td>
			<td<?php echo $cpy_block->blk_status->CellAttributes() ?>>
<span id="el_cpy_block_blk_status">
<span<?php echo $cpy_block->blk_status->ViewAttributes() ?>>
<?php echo $cpy_block->blk_status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_block->blk_type->Visible) { // blk_type ?>
		<tr id="r_blk_type">
			<td class="col-sm-2"><?php echo $cpy_block->blk_type->FldCaption() ?></td>
			<td<?php echo $cpy_block->blk_type->CellAttributes() ?>>
<span id="el_cpy_block_blk_type">
<span<?php echo $cpy_block->blk_type->ViewAttributes() ?>>
<?php echo $cpy_block->blk_type->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_block->blk_stext->Visible) { // blk_stext ?>
		<tr id="r_blk_stext">
			<td class="col-sm-2"><?php echo $cpy_block->blk_stext->FldCaption() ?></td>
			<td<?php echo $cpy_block->blk_stext->CellAttributes() ?>>
<span id="el_cpy_block_blk_stext">
<span<?php echo $cpy_block->blk_stext->ViewAttributes() ?>>
<?php echo $cpy_block->blk_stext->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
