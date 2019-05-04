<?php

// Global variable for table object
$cpy_block_detail = NULL;

//
// Table class for cpy_block_detail
//
class ccpy_block_detail extends cTable {
	var $dblk_id;
	var $blk_id;
	var $dblk_order;
	var $dblk_type;
	var $dblk_status;
	var $dblk_name;
	var $dblk_image;
	var $dblk_stext;
	var $dblk_text;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cpy_block_detail';
		$this->TableName = 'cpy_block_detail';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`cpy_block_detail`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// dblk_id
		$this->dblk_id = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_id', 'dblk_id', '`dblk_id`', '`dblk_id`', 3, -1, FALSE, '`dblk_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->dblk_id->Sortable = FALSE; // Allow sort
		$this->dblk_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dblk_id'] = &$this->dblk_id;

		// blk_id
		$this->blk_id = new cField('cpy_block_detail', 'cpy_block_detail', 'x_blk_id', 'blk_id', '`blk_id`', '`blk_id`', 3, -1, FALSE, '`blk_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->blk_id->Sortable = TRUE; // Allow sort
		$this->blk_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->blk_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->blk_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['blk_id'] = &$this->blk_id;

		// dblk_order
		$this->dblk_order = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_order', 'dblk_order', '`dblk_order`', '`dblk_order`', 2, -1, FALSE, '`dblk_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dblk_order->Sortable = TRUE; // Allow sort
		$this->dblk_order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dblk_order'] = &$this->dblk_order;

		// dblk_type
		$this->dblk_type = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_type', 'dblk_type', '`dblk_type`', '`dblk_type`', 2, -1, FALSE, '`dblk_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->dblk_type->Sortable = TRUE; // Allow sort
		$this->dblk_type->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->dblk_type->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->dblk_type->OptionCount = 12;
		$this->dblk_type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dblk_type'] = &$this->dblk_type;

		// dblk_status
		$this->dblk_status = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_status', 'dblk_status', '`dblk_status`', '`dblk_status`', 2, -1, FALSE, '`dblk_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->dblk_status->Sortable = TRUE; // Allow sort
		$this->dblk_status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->dblk_status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->dblk_status->OptionCount = 2;
		$this->dblk_status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dblk_status'] = &$this->dblk_status;

		// dblk_name
		$this->dblk_name = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_name', 'dblk_name', '`dblk_name`', '`dblk_name`', 200, -1, FALSE, '`dblk_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dblk_name->Sortable = TRUE; // Allow sort
		$this->fields['dblk_name'] = &$this->dblk_name;

		// dblk_image
		$this->dblk_image = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_image', 'dblk_image', '`dblk_image`', '`dblk_image`', 200, -1, TRUE, '`dblk_image`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->dblk_image->Sortable = TRUE; // Allow sort
		$this->fields['dblk_image'] = &$this->dblk_image;

		// dblk_stext
		$this->dblk_stext = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_stext', 'dblk_stext', '`dblk_stext`', '`dblk_stext`', 201, -1, FALSE, '`dblk_stext`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->dblk_stext->Sortable = TRUE; // Allow sort
		$this->fields['dblk_stext'] = &$this->dblk_stext;

		// dblk_text
		$this->dblk_text = new cField('cpy_block_detail', 'cpy_block_detail', 'x_dblk_text', 'dblk_text', '`dblk_text`', '`dblk_text`', 201, -1, FALSE, '`dblk_text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->dblk_text->Sortable = TRUE; // Allow sort
		$this->fields['dblk_text'] = &$this->dblk_text;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $this->LeftColumnClass);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "cpy_block") {
			if ($this->blk_id->getSessionValue() <> "")
				$sMasterFilter .= "`blk_id`=" . ew_QuotedValue($this->blk_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "cpy_block") {
			if ($this->blk_id->getSessionValue() <> "")
				$sDetailFilter .= "`blk_id`=" . ew_QuotedValue($this->blk_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_cpy_block() {
		return "`blk_id`=@blk_id@";
	}

	// Detail filter
	function SqlDetailFilter_cpy_block() {
		return "`blk_id`=@blk_id@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`cpy_block_detail`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`blk_id` DESC,`dblk_order` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$sSql = $this->ListSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->dblk_id->setDbValue($conn->Insert_ID());
			$rs['dblk_id'] = $this->dblk_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('dblk_id', $rs))
				ew_AddFilter($where, ew_QuotedName('dblk_id', $this->DBID) . '=' . ew_QuotedValue($rs['dblk_id'], $this->dblk_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`dblk_id` = @dblk_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->dblk_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->dblk_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@dblk_id@", ew_AdjustSql($this->dblk_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "cpy_block_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "cpy_block_detailview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "cpy_block_detailedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "cpy_block_detailadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "cpy_block_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_block_detailview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_block_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "cpy_block_detailadd.php?" . $this->UrlParm($parm);
		else
			$url = "cpy_block_detailadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("cpy_block_detailedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("cpy_block_detailadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cpy_block_detaildelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "cpy_block" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_blk_id=" . urlencode($this->blk_id->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "dblk_id:" . ew_VarToJson($this->dblk_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->dblk_id->CurrentValue)) {
			$sUrl .= "dblk_id=" . urlencode($this->dblk_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["dblk_id"]))
				$arKeys[] = $_POST["dblk_id"];
			elseif (isset($_GET["dblk_id"]))
				$arKeys[] = $_GET["dblk_id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->dblk_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->dblk_id->setDbValue($rs->fields('dblk_id'));
		$this->blk_id->setDbValue($rs->fields('blk_id'));
		$this->dblk_order->setDbValue($rs->fields('dblk_order'));
		$this->dblk_type->setDbValue($rs->fields('dblk_type'));
		$this->dblk_status->setDbValue($rs->fields('dblk_status'));
		$this->dblk_name->setDbValue($rs->fields('dblk_name'));
		$this->dblk_image->Upload->DbValue = $rs->fields('dblk_image');
		$this->dblk_stext->setDbValue($rs->fields('dblk_stext'));
		$this->dblk_text->setDbValue($rs->fields('dblk_text'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// dblk_id

		$this->dblk_id->CellCssStyle = "white-space: nowrap;";

		// blk_id
		// dblk_order
		// dblk_type
		// dblk_status
		// dblk_name
		// dblk_image
		// dblk_stext
		// dblk_text
		// dblk_id

		$this->dblk_id->ViewValue = $this->dblk_id->CurrentValue;
		$this->dblk_id->ViewCustomAttributes = "";

		// blk_id
		if (strval($this->blk_id->CurrentValue) <> "") {
			$sFilterWrk = "`blk_id`" . ew_SearchString("=", $this->blk_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `blk_id`, `blk_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_block`";
		$sWhereWrk = "";
		$this->blk_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->blk_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->blk_id->ViewValue = $this->blk_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->blk_id->ViewValue = $this->blk_id->CurrentValue;
			}
		} else {
			$this->blk_id->ViewValue = NULL;
		}
		$this->blk_id->ViewCustomAttributes = "";

		// dblk_order
		$this->dblk_order->ViewValue = $this->dblk_order->CurrentValue;
		$this->dblk_order->ViewCustomAttributes = "";

		// dblk_type
		if (strval($this->dblk_type->CurrentValue) <> "") {
			$this->dblk_type->ViewValue = $this->dblk_type->OptionCaption($this->dblk_type->CurrentValue);
		} else {
			$this->dblk_type->ViewValue = NULL;
		}
		$this->dblk_type->ViewCustomAttributes = "";

		// dblk_status
		if (strval($this->dblk_status->CurrentValue) <> "") {
			$this->dblk_status->ViewValue = $this->dblk_status->OptionCaption($this->dblk_status->CurrentValue);
		} else {
			$this->dblk_status->ViewValue = NULL;
		}
		$this->dblk_status->ViewCustomAttributes = "";

		// dblk_name
		$this->dblk_name->ViewValue = $this->dblk_name->CurrentValue;
		$this->dblk_name->ViewCustomAttributes = "";

		// dblk_image
		$this->dblk_image->UploadPath = '../../assets/img/blkImages/';
		if (!ew_Empty($this->dblk_image->Upload->DbValue)) {
			$this->dblk_image->ImageWidth = 200;
			$this->dblk_image->ImageHeight = 0;
			$this->dblk_image->ImageAlt = $this->dblk_image->FldAlt();
			$this->dblk_image->ViewValue = $this->dblk_image->Upload->DbValue;
		} else {
			$this->dblk_image->ViewValue = "";
		}
		$this->dblk_image->ViewCustomAttributes = "";

		// dblk_stext
		$this->dblk_stext->ViewValue = $this->dblk_stext->CurrentValue;
		$this->dblk_stext->ViewCustomAttributes = "";

		// dblk_text
		$this->dblk_text->ViewValue = $this->dblk_text->CurrentValue;
		$this->dblk_text->ViewCustomAttributes = "";

		// dblk_id
		$this->dblk_id->LinkCustomAttributes = "";
		$this->dblk_id->HrefValue = "";
		$this->dblk_id->TooltipValue = "";

		// blk_id
		$this->blk_id->LinkCustomAttributes = "";
		$this->blk_id->HrefValue = "";
		$this->blk_id->TooltipValue = "";

		// dblk_order
		$this->dblk_order->LinkCustomAttributes = "";
		$this->dblk_order->HrefValue = "";
		$this->dblk_order->TooltipValue = "";

		// dblk_type
		$this->dblk_type->LinkCustomAttributes = "";
		$this->dblk_type->HrefValue = "";
		$this->dblk_type->TooltipValue = "";

		// dblk_status
		$this->dblk_status->LinkCustomAttributes = "";
		$this->dblk_status->HrefValue = "";
		$this->dblk_status->TooltipValue = "";

		// dblk_name
		$this->dblk_name->LinkCustomAttributes = "";
		$this->dblk_name->HrefValue = "";
		$this->dblk_name->TooltipValue = "";

		// dblk_image
		$this->dblk_image->LinkCustomAttributes = "";
		$this->dblk_image->UploadPath = '../../assets/img/blkImages/';
		if (!ew_Empty($this->dblk_image->Upload->DbValue)) {
			$this->dblk_image->HrefValue = ew_GetFileUploadUrl($this->dblk_image, $this->dblk_image->Upload->DbValue); // Add prefix/suffix
			$this->dblk_image->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->dblk_image->HrefValue = ew_FullUrl($this->dblk_image->HrefValue, "href");
		} else {
			$this->dblk_image->HrefValue = "";
		}
		$this->dblk_image->HrefValue2 = $this->dblk_image->UploadPath . $this->dblk_image->Upload->DbValue;
		$this->dblk_image->TooltipValue = "";
		if ($this->dblk_image->UseColorbox) {
			if (ew_Empty($this->dblk_image->TooltipValue))
				$this->dblk_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->dblk_image->LinkAttrs["data-rel"] = "cpy_block_detail_x_dblk_image";
			ew_AppendClass($this->dblk_image->LinkAttrs["class"], "ewLightbox");
		}

		// dblk_stext
		$this->dblk_stext->LinkCustomAttributes = "";
		$this->dblk_stext->HrefValue = "";
		$this->dblk_stext->TooltipValue = "";

		// dblk_text
		$this->dblk_text->LinkCustomAttributes = "";
		$this->dblk_text->HrefValue = "";
		$this->dblk_text->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// dblk_id
		$this->dblk_id->EditAttrs["class"] = "form-control";
		$this->dblk_id->EditCustomAttributes = "";
		$this->dblk_id->EditValue = $this->dblk_id->CurrentValue;
		$this->dblk_id->ViewCustomAttributes = "";

		// blk_id
		$this->blk_id->EditAttrs["class"] = "form-control";
		$this->blk_id->EditCustomAttributes = "";
		if ($this->blk_id->getSessionValue() <> "") {
			$this->blk_id->CurrentValue = $this->blk_id->getSessionValue();
		if (strval($this->blk_id->CurrentValue) <> "") {
			$sFilterWrk = "`blk_id`" . ew_SearchString("=", $this->blk_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `blk_id`, `blk_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_block`";
		$sWhereWrk = "";
		$this->blk_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->blk_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->blk_id->ViewValue = $this->blk_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->blk_id->ViewValue = $this->blk_id->CurrentValue;
			}
		} else {
			$this->blk_id->ViewValue = NULL;
		}
		$this->blk_id->ViewCustomAttributes = "";
		} else {
		}

		// dblk_order
		$this->dblk_order->EditAttrs["class"] = "form-control";
		$this->dblk_order->EditCustomAttributes = "";
		$this->dblk_order->EditValue = $this->dblk_order->CurrentValue;
		$this->dblk_order->PlaceHolder = ew_RemoveHtml($this->dblk_order->FldCaption());

		// dblk_type
		$this->dblk_type->EditAttrs["class"] = "form-control";
		$this->dblk_type->EditCustomAttributes = "";
		$this->dblk_type->EditValue = $this->dblk_type->Options(TRUE);

		// dblk_status
		$this->dblk_status->EditAttrs["class"] = "form-control";
		$this->dblk_status->EditCustomAttributes = "";
		$this->dblk_status->EditValue = $this->dblk_status->Options(TRUE);

		// dblk_name
		$this->dblk_name->EditAttrs["class"] = "form-control";
		$this->dblk_name->EditCustomAttributes = "";
		$this->dblk_name->EditValue = $this->dblk_name->CurrentValue;
		$this->dblk_name->PlaceHolder = ew_RemoveHtml($this->dblk_name->FldCaption());

		// dblk_image
		$this->dblk_image->EditAttrs["class"] = "form-control";
		$this->dblk_image->EditCustomAttributes = "";
		$this->dblk_image->UploadPath = '../../assets/img/blkImages/';
		if (!ew_Empty($this->dblk_image->Upload->DbValue)) {
			$this->dblk_image->ImageWidth = 200;
			$this->dblk_image->ImageHeight = 0;
			$this->dblk_image->ImageAlt = $this->dblk_image->FldAlt();
			$this->dblk_image->EditValue = $this->dblk_image->Upload->DbValue;
		} else {
			$this->dblk_image->EditValue = "";
		}
		if (!ew_Empty($this->dblk_image->CurrentValue))
			$this->dblk_image->Upload->FileName = $this->dblk_image->CurrentValue;

		// dblk_stext
		$this->dblk_stext->EditAttrs["class"] = "form-control";
		$this->dblk_stext->EditCustomAttributes = "";
		$this->dblk_stext->EditValue = $this->dblk_stext->CurrentValue;
		$this->dblk_stext->PlaceHolder = ew_RemoveHtml($this->dblk_stext->FldCaption());

		// dblk_text
		$this->dblk_text->EditAttrs["class"] = "form-control";
		$this->dblk_text->EditCustomAttributes = "";
		$this->dblk_text->EditValue = $this->dblk_text->CurrentValue;
		$this->dblk_text->PlaceHolder = ew_RemoveHtml($this->dblk_text->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->blk_id->Exportable) $Doc->ExportCaption($this->blk_id);
					if ($this->dblk_order->Exportable) $Doc->ExportCaption($this->dblk_order);
					if ($this->dblk_type->Exportable) $Doc->ExportCaption($this->dblk_type);
					if ($this->dblk_status->Exportable) $Doc->ExportCaption($this->dblk_status);
					if ($this->dblk_name->Exportable) $Doc->ExportCaption($this->dblk_name);
					if ($this->dblk_image->Exportable) $Doc->ExportCaption($this->dblk_image);
					if ($this->dblk_stext->Exportable) $Doc->ExportCaption($this->dblk_stext);
					if ($this->dblk_text->Exportable) $Doc->ExportCaption($this->dblk_text);
				} else {
					if ($this->blk_id->Exportable) $Doc->ExportCaption($this->blk_id);
					if ($this->dblk_order->Exportable) $Doc->ExportCaption($this->dblk_order);
					if ($this->dblk_type->Exportable) $Doc->ExportCaption($this->dblk_type);
					if ($this->dblk_status->Exportable) $Doc->ExportCaption($this->dblk_status);
					if ($this->dblk_name->Exportable) $Doc->ExportCaption($this->dblk_name);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->blk_id->Exportable) $Doc->ExportField($this->blk_id);
						if ($this->dblk_order->Exportable) $Doc->ExportField($this->dblk_order);
						if ($this->dblk_type->Exportable) $Doc->ExportField($this->dblk_type);
						if ($this->dblk_status->Exportable) $Doc->ExportField($this->dblk_status);
						if ($this->dblk_name->Exportable) $Doc->ExportField($this->dblk_name);
						if ($this->dblk_image->Exportable) $Doc->ExportField($this->dblk_image);
						if ($this->dblk_stext->Exportable) $Doc->ExportField($this->dblk_stext);
						if ($this->dblk_text->Exportable) $Doc->ExportField($this->dblk_text);
					} else {
						if ($this->blk_id->Exportable) $Doc->ExportField($this->blk_id);
						if ($this->dblk_order->Exportable) $Doc->ExportField($this->dblk_order);
						if ($this->dblk_type->Exportable) $Doc->ExportField($this->dblk_type);
						if ($this->dblk_status->Exportable) $Doc->ExportField($this->dblk_status);
						if ($this->dblk_name->Exportable) $Doc->ExportField($this->dblk_name);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
