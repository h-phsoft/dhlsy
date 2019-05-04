<?php

// news_status
// type_id
// news_date
// news_title
// news_stext
// news_image

?>
<?php if ($cpy_news->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_cpy_newsmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($cpy_news->news_status->Visible) { // news_status ?>
		<tr id="r_news_status">
			<td class="col-sm-2"><?php echo $cpy_news->news_status->FldCaption() ?></td>
			<td<?php echo $cpy_news->news_status->CellAttributes() ?>>
<span id="el_cpy_news_news_status">
<span<?php echo $cpy_news->news_status->ViewAttributes() ?>>
<?php echo $cpy_news->news_status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_news->type_id->Visible) { // type_id ?>
		<tr id="r_type_id">
			<td class="col-sm-2"><?php echo $cpy_news->type_id->FldCaption() ?></td>
			<td<?php echo $cpy_news->type_id->CellAttributes() ?>>
<span id="el_cpy_news_type_id">
<span<?php echo $cpy_news->type_id->ViewAttributes() ?>>
<?php echo $cpy_news->type_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_news->news_date->Visible) { // news_date ?>
		<tr id="r_news_date">
			<td class="col-sm-2"><?php echo $cpy_news->news_date->FldCaption() ?></td>
			<td<?php echo $cpy_news->news_date->CellAttributes() ?>>
<span id="el_cpy_news_news_date">
<span<?php echo $cpy_news->news_date->ViewAttributes() ?>>
<?php echo $cpy_news->news_date->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_news->news_title->Visible) { // news_title ?>
		<tr id="r_news_title">
			<td class="col-sm-2"><?php echo $cpy_news->news_title->FldCaption() ?></td>
			<td<?php echo $cpy_news->news_title->CellAttributes() ?>>
<span id="el_cpy_news_news_title">
<span<?php echo $cpy_news->news_title->ViewAttributes() ?>>
<?php echo $cpy_news->news_title->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_news->news_stext->Visible) { // news_stext ?>
		<tr id="r_news_stext">
			<td class="col-sm-2"><?php echo $cpy_news->news_stext->FldCaption() ?></td>
			<td<?php echo $cpy_news->news_stext->CellAttributes() ?>>
<span id="el_cpy_news_news_stext">
<span<?php echo $cpy_news->news_stext->ViewAttributes() ?>>
<?php echo $cpy_news->news_stext->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_news->news_image->Visible) { // news_image ?>
		<tr id="r_news_image">
			<td class="col-sm-2"><?php echo $cpy_news->news_image->FldCaption() ?></td>
			<td<?php echo $cpy_news->news_image->CellAttributes() ?>>
<span id="el_cpy_news_news_image">
<span>
<?php echo ew_GetFileViewTag($cpy_news->news_image, $cpy_news->news_image->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
