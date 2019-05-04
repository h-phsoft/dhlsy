<?php

// Global variable for table object
$cpy_menu = NULL;

//
// Table class for cpy_menu
//
class ccpy_menu extends cTable {
	var $menu_id;
	var $menu_pid;
	var $menu_rid;
	var $menu_order;
	var $mode_id;
	var $type_id;
	var $srch_id;
	var $menu_status;
	var $menu_name;
	var $menu_icon;
	var $page_id;
	var $menu_href;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cpy_menu';
		$this->TableName = 'cpy_menu';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`cpy_menu`";
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

		// menu_id
		$this->menu_id = new cField('cpy_menu', 'cpy_menu', 'x_menu_id', 'menu_id', '`menu_id`', '`menu_id`', 3, -1, FALSE, '`menu_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->menu_id->Sortable = FALSE; // Allow sort
		$this->menu_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['menu_id'] = &$this->menu_id;

		// menu_pid
		$this->menu_pid = new cField('cpy_menu', 'cpy_menu', 'x_menu_pid', 'menu_pid', '`menu_pid`', '`menu_pid`', 3, -1, FALSE, '`menu_pid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->menu_pid->Sortable = TRUE; // Allow sort
		$this->menu_pid->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->menu_pid->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->menu_pid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['menu_pid'] = &$this->menu_pid;

		// menu_rid
		$this->menu_rid = new cField('cpy_menu', 'cpy_menu', 'x_menu_rid', 'menu_rid', '`menu_rid`', '`menu_rid`', 3, -1, FALSE, '`menu_rid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->menu_rid->Sortable = TRUE; // Allow sort
		$this->menu_rid->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->menu_rid->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->menu_rid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['menu_rid'] = &$this->menu_rid;

		// menu_order
		$this->menu_order = new cField('cpy_menu', 'cpy_menu', 'x_menu_order', 'menu_order', '`menu_order`', '`menu_order`', 3, -1, FALSE, '`menu_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->menu_order->Sortable = TRUE; // Allow sort
		$this->menu_order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['menu_order'] = &$this->menu_order;

		// mode_id
		$this->mode_id = new cField('cpy_menu', 'cpy_menu', 'x_mode_id', 'mode_id', '`mode_id`', '`mode_id`', 3, -1, FALSE, '`mode_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->mode_id->Sortable = TRUE; // Allow sort
		$this->mode_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->mode_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->mode_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['mode_id'] = &$this->mode_id;

		// type_id
		$this->type_id = new cField('cpy_menu', 'cpy_menu', 'x_type_id', 'type_id', '`type_id`', '`type_id`', 3, -1, FALSE, '`type_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->type_id->Sortable = TRUE; // Allow sort
		$this->type_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->type_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->type_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['type_id'] = &$this->type_id;

		// srch_id
		$this->srch_id = new cField('cpy_menu', 'cpy_menu', 'x_srch_id', 'srch_id', '`srch_id`', '`srch_id`', 3, -1, FALSE, '`srch_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->srch_id->Sortable = TRUE; // Allow sort
		$this->srch_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->srch_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->srch_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['srch_id'] = &$this->srch_id;

		// menu_status
		$this->menu_status = new cField('cpy_menu', 'cpy_menu', 'x_menu_status', 'menu_status', '`menu_status`', '`menu_status`', 2, -1, FALSE, '`menu_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->menu_status->Sortable = TRUE; // Allow sort
		$this->menu_status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->menu_status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->menu_status->OptionCount = 2;
		$this->menu_status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['menu_status'] = &$this->menu_status;

		// menu_name
		$this->menu_name = new cField('cpy_menu', 'cpy_menu', 'x_menu_name', 'menu_name', '`menu_name`', '`menu_name`', 200, -1, FALSE, '`menu_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->menu_name->Sortable = TRUE; // Allow sort
		$this->fields['menu_name'] = &$this->menu_name;

		// menu_icon
		$this->menu_icon = new cField('cpy_menu', 'cpy_menu', 'x_menu_icon', 'menu_icon', '`menu_icon`', '`menu_icon`', 200, -1, TRUE, '`menu_icon`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->menu_icon->Sortable = TRUE; // Allow sort
		$this->fields['menu_icon'] = &$this->menu_icon;

		// page_id
		$this->page_id = new cField('cpy_menu', 'cpy_menu', 'x_page_id', 'page_id', '`page_id`', '`page_id`', 3, -1, FALSE, '`page_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->page_id->Sortable = TRUE; // Allow sort
		$this->page_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->page_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->page_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['page_id'] = &$this->page_id;

		// menu_href
		$this->menu_href = new cField('cpy_menu', 'cpy_menu', 'x_menu_href', 'menu_href', '`menu_href`', '`menu_href`', 200, -1, FALSE, '`menu_href`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->menu_href->Sortable = TRUE; // Allow sort
		$this->fields['menu_href'] = &$this->menu_href;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`cpy_menu`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`menu_pid` ASC,`menu_order` ASC,`type_id` ASC,`menu_id` ASC";
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
			if (array_key_exists('menu_id', $rs))
				ew_AddFilter($where, ew_QuotedName('menu_id', $this->DBID) . '=' . ew_QuotedValue($rs['menu_id'], $this->menu_id->FldDataType, $this->DBID));
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
		return "`menu_id` = @menu_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->menu_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->menu_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@menu_id@", ew_AdjustSql($this->menu_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "cpy_menulist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "cpy_menuview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "cpy_menuedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "cpy_menuadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "cpy_menulist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_menuview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_menuview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "cpy_menuadd.php?" . $this->UrlParm($parm);
		else
			$url = "cpy_menuadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("cpy_menuedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("cpy_menuadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cpy_menudelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "menu_id:" . ew_VarToJson($this->menu_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->menu_id->CurrentValue)) {
			$sUrl .= "menu_id=" . urlencode($this->menu_id->CurrentValue);
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
			if ($isPost && isset($_POST["menu_id"]))
				$arKeys[] = $_POST["menu_id"];
			elseif (isset($_GET["menu_id"]))
				$arKeys[] = $_GET["menu_id"];
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
			$this->menu_id->CurrentValue = $key;
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
		$this->menu_id->setDbValue($rs->fields('menu_id'));
		$this->menu_pid->setDbValue($rs->fields('menu_pid'));
		$this->menu_rid->setDbValue($rs->fields('menu_rid'));
		$this->menu_order->setDbValue($rs->fields('menu_order'));
		$this->mode_id->setDbValue($rs->fields('mode_id'));
		$this->type_id->setDbValue($rs->fields('type_id'));
		$this->srch_id->setDbValue($rs->fields('srch_id'));
		$this->menu_status->setDbValue($rs->fields('menu_status'));
		$this->menu_name->setDbValue($rs->fields('menu_name'));
		$this->menu_icon->Upload->DbValue = $rs->fields('menu_icon');
		$this->page_id->setDbValue($rs->fields('page_id'));
		$this->menu_href->setDbValue($rs->fields('menu_href'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// menu_id

		$this->menu_id->CellCssStyle = "white-space: nowrap;";

		// menu_pid
		// menu_rid
		// menu_order
		// mode_id
		// type_id
		// srch_id
		// menu_status
		// menu_name
		// menu_icon
		// page_id
		// menu_href
		// menu_id

		$this->menu_id->ViewValue = $this->menu_id->CurrentValue;
		$this->menu_id->ViewCustomAttributes = "";

		// menu_pid
		if (strval($this->menu_pid->CurrentValue) <> "") {
			$sFilterWrk = "`menu_id`" . ew_SearchString("=", $this->menu_pid->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `menu_id`, `menu_pname` AS `DispFld`, `menu_name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_vmenu`";
		$sWhereWrk = "";
		$this->menu_pid->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->menu_pid, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->menu_pid->ViewValue = $this->menu_pid->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->menu_pid->ViewValue = $this->menu_pid->CurrentValue;
			}
		} else {
			$this->menu_pid->ViewValue = NULL;
		}
		$this->menu_pid->ViewCustomAttributes = "";

		// menu_rid
		if (strval($this->menu_rid->CurrentValue) <> "") {
			$sFilterWrk = "`menu_id`" . ew_SearchString("=", $this->menu_rid->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `menu_id`, `menu_pname` AS `DispFld`, `menu_name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_vmenu`";
		$sWhereWrk = "";
		$this->menu_rid->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->menu_rid, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->menu_rid->ViewValue = $this->menu_rid->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->menu_rid->ViewValue = $this->menu_rid->CurrentValue;
			}
		} else {
			$this->menu_rid->ViewValue = NULL;
		}
		$this->menu_rid->ViewCustomAttributes = "";

		// menu_order
		$this->menu_order->ViewValue = $this->menu_order->CurrentValue;
		$this->menu_order->ViewCustomAttributes = "";

		// mode_id
		if (strval($this->mode_id->CurrentValue) <> "") {
			$sFilterWrk = "`mode_id`" . ew_SearchString("=", $this->mode_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `mode_id`, `mode_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_menu_mode`";
		$sWhereWrk = "";
		$this->mode_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->mode_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->mode_id->ViewValue = $this->mode_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->mode_id->ViewValue = $this->mode_id->CurrentValue;
			}
		} else {
			$this->mode_id->ViewValue = NULL;
		}
		$this->mode_id->ViewCustomAttributes = "";

		// type_id
		if (strval($this->type_id->CurrentValue) <> "") {
			$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_menu_type`";
		$sWhereWrk = "";
		$this->type_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->type_id->ViewValue = $this->type_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->type_id->ViewValue = $this->type_id->CurrentValue;
			}
		} else {
			$this->type_id->ViewValue = NULL;
		}
		$this->type_id->ViewCustomAttributes = "";

		// srch_id
		if (strval($this->srch_id->CurrentValue) <> "") {
			$sFilterWrk = "`srch_id`" . ew_SearchString("=", $this->srch_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `srch_id`, `srch_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_menu_search`";
		$sWhereWrk = "";
		$this->srch_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->srch_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->srch_id->ViewValue = $this->srch_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->srch_id->ViewValue = $this->srch_id->CurrentValue;
			}
		} else {
			$this->srch_id->ViewValue = NULL;
		}
		$this->srch_id->ViewCustomAttributes = "";

		// menu_status
		if (strval($this->menu_status->CurrentValue) <> "") {
			$this->menu_status->ViewValue = $this->menu_status->OptionCaption($this->menu_status->CurrentValue);
		} else {
			$this->menu_status->ViewValue = NULL;
		}
		$this->menu_status->ViewCustomAttributes = "";

		// menu_name
		$this->menu_name->ViewValue = $this->menu_name->CurrentValue;
		$this->menu_name->ViewCustomAttributes = "";

		// menu_icon
		$this->menu_icon->UploadPath = '../../assets/img/icons/';
		if (!ew_Empty($this->menu_icon->Upload->DbValue)) {
			$this->menu_icon->ImageWidth = 100;
			$this->menu_icon->ImageHeight = 0;
			$this->menu_icon->ImageAlt = $this->menu_icon->FldAlt();
			$this->menu_icon->ViewValue = $this->menu_icon->Upload->DbValue;
		} else {
			$this->menu_icon->ViewValue = "";
		}
		$this->menu_icon->ViewCustomAttributes = "";

		// page_id
		if (strval($this->page_id->CurrentValue) <> "") {
			$sFilterWrk = "`page_id`" . ew_SearchString("=", $this->page_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `page_id`, `page_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_page`";
		$sWhereWrk = "";
		$this->page_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->page_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->page_id->ViewValue = $this->page_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->page_id->ViewValue = $this->page_id->CurrentValue;
			}
		} else {
			$this->page_id->ViewValue = NULL;
		}
		$this->page_id->ViewCustomAttributes = "";

		// menu_href
		$this->menu_href->ViewValue = $this->menu_href->CurrentValue;
		$this->menu_href->ViewCustomAttributes = "";

		// menu_id
		$this->menu_id->LinkCustomAttributes = "";
		$this->menu_id->HrefValue = "";
		$this->menu_id->TooltipValue = "";

		// menu_pid
		$this->menu_pid->LinkCustomAttributes = "";
		$this->menu_pid->HrefValue = "";
		$this->menu_pid->TooltipValue = "";

		// menu_rid
		$this->menu_rid->LinkCustomAttributes = "";
		$this->menu_rid->HrefValue = "";
		$this->menu_rid->TooltipValue = "";

		// menu_order
		$this->menu_order->LinkCustomAttributes = "";
		$this->menu_order->HrefValue = "";
		$this->menu_order->TooltipValue = "";

		// mode_id
		$this->mode_id->LinkCustomAttributes = "";
		$this->mode_id->HrefValue = "";
		$this->mode_id->TooltipValue = "";

		// type_id
		$this->type_id->LinkCustomAttributes = "";
		$this->type_id->HrefValue = "";
		$this->type_id->TooltipValue = "";

		// srch_id
		$this->srch_id->LinkCustomAttributes = "";
		$this->srch_id->HrefValue = "";
		$this->srch_id->TooltipValue = "";

		// menu_status
		$this->menu_status->LinkCustomAttributes = "";
		$this->menu_status->HrefValue = "";
		$this->menu_status->TooltipValue = "";

		// menu_name
		$this->menu_name->LinkCustomAttributes = "";
		$this->menu_name->HrefValue = "";
		$this->menu_name->TooltipValue = "";

		// menu_icon
		$this->menu_icon->LinkCustomAttributes = "";
		$this->menu_icon->UploadPath = '../../assets/img/icons/';
		if (!ew_Empty($this->menu_icon->Upload->DbValue)) {
			$this->menu_icon->HrefValue = ew_GetFileUploadUrl($this->menu_icon, $this->menu_icon->Upload->DbValue); // Add prefix/suffix
			$this->menu_icon->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->menu_icon->HrefValue = ew_FullUrl($this->menu_icon->HrefValue, "href");
		} else {
			$this->menu_icon->HrefValue = "";
		}
		$this->menu_icon->HrefValue2 = $this->menu_icon->UploadPath . $this->menu_icon->Upload->DbValue;
		$this->menu_icon->TooltipValue = "";
		if ($this->menu_icon->UseColorbox) {
			if (ew_Empty($this->menu_icon->TooltipValue))
				$this->menu_icon->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->menu_icon->LinkAttrs["data-rel"] = "cpy_menu_x_menu_icon";
			ew_AppendClass($this->menu_icon->LinkAttrs["class"], "ewLightbox");
		}

		// page_id
		$this->page_id->LinkCustomAttributes = "";
		$this->page_id->HrefValue = "";
		$this->page_id->TooltipValue = "";

		// menu_href
		$this->menu_href->LinkCustomAttributes = "";
		$this->menu_href->HrefValue = "";
		$this->menu_href->TooltipValue = "";

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

		// menu_id
		$this->menu_id->EditAttrs["class"] = "form-control";
		$this->menu_id->EditCustomAttributes = "";
		$this->menu_id->EditValue = $this->menu_id->CurrentValue;
		$this->menu_id->ViewCustomAttributes = "";

		// menu_pid
		$this->menu_pid->EditAttrs["class"] = "form-control";
		$this->menu_pid->EditCustomAttributes = "";

		// menu_rid
		$this->menu_rid->EditAttrs["class"] = "form-control";
		$this->menu_rid->EditCustomAttributes = "";

		// menu_order
		$this->menu_order->EditAttrs["class"] = "form-control";
		$this->menu_order->EditCustomAttributes = "";
		$this->menu_order->EditValue = $this->menu_order->CurrentValue;
		$this->menu_order->PlaceHolder = ew_RemoveHtml($this->menu_order->FldCaption());

		// mode_id
		$this->mode_id->EditAttrs["class"] = "form-control";
		$this->mode_id->EditCustomAttributes = "";

		// type_id
		$this->type_id->EditAttrs["class"] = "form-control";
		$this->type_id->EditCustomAttributes = "";

		// srch_id
		$this->srch_id->EditAttrs["class"] = "form-control";
		$this->srch_id->EditCustomAttributes = "";

		// menu_status
		$this->menu_status->EditAttrs["class"] = "form-control";
		$this->menu_status->EditCustomAttributes = "";
		$this->menu_status->EditValue = $this->menu_status->Options(TRUE);

		// menu_name
		$this->menu_name->EditAttrs["class"] = "form-control";
		$this->menu_name->EditCustomAttributes = "";
		$this->menu_name->EditValue = $this->menu_name->CurrentValue;
		$this->menu_name->PlaceHolder = ew_RemoveHtml($this->menu_name->FldCaption());

		// menu_icon
		$this->menu_icon->EditAttrs["class"] = "form-control";
		$this->menu_icon->EditCustomAttributes = "";
		$this->menu_icon->UploadPath = '../../assets/img/icons/';
		if (!ew_Empty($this->menu_icon->Upload->DbValue)) {
			$this->menu_icon->ImageWidth = 100;
			$this->menu_icon->ImageHeight = 0;
			$this->menu_icon->ImageAlt = $this->menu_icon->FldAlt();
			$this->menu_icon->EditValue = $this->menu_icon->Upload->DbValue;
		} else {
			$this->menu_icon->EditValue = "";
		}
		if (!ew_Empty($this->menu_icon->CurrentValue))
			$this->menu_icon->Upload->FileName = $this->menu_icon->CurrentValue;

		// page_id
		$this->page_id->EditAttrs["class"] = "form-control";
		$this->page_id->EditCustomAttributes = "";

		// menu_href
		$this->menu_href->EditAttrs["class"] = "form-control";
		$this->menu_href->EditCustomAttributes = "";
		$this->menu_href->EditValue = $this->menu_href->CurrentValue;
		$this->menu_href->PlaceHolder = ew_RemoveHtml($this->menu_href->FldCaption());

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
					if ($this->menu_pid->Exportable) $Doc->ExportCaption($this->menu_pid);
					if ($this->menu_rid->Exportable) $Doc->ExportCaption($this->menu_rid);
					if ($this->menu_order->Exportable) $Doc->ExportCaption($this->menu_order);
					if ($this->mode_id->Exportable) $Doc->ExportCaption($this->mode_id);
					if ($this->type_id->Exportable) $Doc->ExportCaption($this->type_id);
					if ($this->srch_id->Exportable) $Doc->ExportCaption($this->srch_id);
					if ($this->menu_status->Exportable) $Doc->ExportCaption($this->menu_status);
					if ($this->menu_name->Exportable) $Doc->ExportCaption($this->menu_name);
					if ($this->menu_icon->Exportable) $Doc->ExportCaption($this->menu_icon);
					if ($this->page_id->Exportable) $Doc->ExportCaption($this->page_id);
					if ($this->menu_href->Exportable) $Doc->ExportCaption($this->menu_href);
				} else {
					if ($this->menu_pid->Exportable) $Doc->ExportCaption($this->menu_pid);
					if ($this->menu_rid->Exportable) $Doc->ExportCaption($this->menu_rid);
					if ($this->menu_order->Exportable) $Doc->ExportCaption($this->menu_order);
					if ($this->mode_id->Exportable) $Doc->ExportCaption($this->mode_id);
					if ($this->type_id->Exportable) $Doc->ExportCaption($this->type_id);
					if ($this->srch_id->Exportable) $Doc->ExportCaption($this->srch_id);
					if ($this->menu_status->Exportable) $Doc->ExportCaption($this->menu_status);
					if ($this->menu_name->Exportable) $Doc->ExportCaption($this->menu_name);
					if ($this->menu_icon->Exportable) $Doc->ExportCaption($this->menu_icon);
					if ($this->page_id->Exportable) $Doc->ExportCaption($this->page_id);
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
						if ($this->menu_pid->Exportable) $Doc->ExportField($this->menu_pid);
						if ($this->menu_rid->Exportable) $Doc->ExportField($this->menu_rid);
						if ($this->menu_order->Exportable) $Doc->ExportField($this->menu_order);
						if ($this->mode_id->Exportable) $Doc->ExportField($this->mode_id);
						if ($this->type_id->Exportable) $Doc->ExportField($this->type_id);
						if ($this->srch_id->Exportable) $Doc->ExportField($this->srch_id);
						if ($this->menu_status->Exportable) $Doc->ExportField($this->menu_status);
						if ($this->menu_name->Exportable) $Doc->ExportField($this->menu_name);
						if ($this->menu_icon->Exportable) $Doc->ExportField($this->menu_icon);
						if ($this->page_id->Exportable) $Doc->ExportField($this->page_id);
						if ($this->menu_href->Exportable) $Doc->ExportField($this->menu_href);
					} else {
						if ($this->menu_pid->Exportable) $Doc->ExportField($this->menu_pid);
						if ($this->menu_rid->Exportable) $Doc->ExportField($this->menu_rid);
						if ($this->menu_order->Exportable) $Doc->ExportField($this->menu_order);
						if ($this->mode_id->Exportable) $Doc->ExportField($this->mode_id);
						if ($this->type_id->Exportable) $Doc->ExportField($this->type_id);
						if ($this->srch_id->Exportable) $Doc->ExportField($this->srch_id);
						if ($this->menu_status->Exportable) $Doc->ExportField($this->menu_status);
						if ($this->menu_name->Exportable) $Doc->ExportField($this->menu_name);
						if ($this->menu_icon->Exportable) $Doc->ExportField($this->menu_icon);
						if ($this->page_id->Exportable) $Doc->ExportField($this->page_id);
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
