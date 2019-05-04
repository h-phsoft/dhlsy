<?php

// Global variable for table object
$cpy_news = NULL;

//
// Table class for cpy_news
//
class ccpy_news extends cTable {
	var $news_id;
	var $news_status;
	var $type_id;
	var $news_date;
	var $news_title;
	var $news_stext;
	var $news_image;
	var $news_text;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cpy_news';
		$this->TableName = 'cpy_news';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`cpy_news`";
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

		// news_id
		$this->news_id = new cField('cpy_news', 'cpy_news', 'x_news_id', 'news_id', '`news_id`', '`news_id`', 3, -1, FALSE, '`news_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->news_id->Sortable = FALSE; // Allow sort
		$this->news_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['news_id'] = &$this->news_id;

		// news_status
		$this->news_status = new cField('cpy_news', 'cpy_news', 'x_news_status', 'news_status', '`news_status`', '`news_status`', 2, -1, FALSE, '`news_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->news_status->Sortable = TRUE; // Allow sort
		$this->news_status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->news_status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->news_status->OptionCount = 2;
		$this->news_status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['news_status'] = &$this->news_status;

		// type_id
		$this->type_id = new cField('cpy_news', 'cpy_news', 'x_type_id', 'type_id', '`type_id`', '`type_id`', 3, -1, FALSE, '`type_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->type_id->Sortable = TRUE; // Allow sort
		$this->type_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->type_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->type_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['type_id'] = &$this->type_id;

		// news_date
		$this->news_date = new cField('cpy_news', 'cpy_news', 'x_news_date', 'news_date', '`news_date`', ew_CastDateFieldForLike('`news_date`', 5, "DB"), 133, 5, FALSE, '`news_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->news_date->Sortable = TRUE; // Allow sort
		$this->news_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateYMD"));
		$this->fields['news_date'] = &$this->news_date;

		// news_title
		$this->news_title = new cField('cpy_news', 'cpy_news', 'x_news_title', 'news_title', '`news_title`', '`news_title`', 200, -1, FALSE, '`news_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->news_title->Sortable = TRUE; // Allow sort
		$this->fields['news_title'] = &$this->news_title;

		// news_stext
		$this->news_stext = new cField('cpy_news', 'cpy_news', 'x_news_stext', 'news_stext', '`news_stext`', '`news_stext`', 201, -1, FALSE, '`news_stext`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->news_stext->Sortable = TRUE; // Allow sort
		$this->fields['news_stext'] = &$this->news_stext;

		// news_image
		$this->news_image = new cField('cpy_news', 'cpy_news', 'x_news_image', 'news_image', '`news_image`', '`news_image`', 200, -1, TRUE, '`news_image`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->news_image->Sortable = TRUE; // Allow sort
		$this->fields['news_image'] = &$this->news_image;

		// news_text
		$this->news_text = new cField('cpy_news', 'cpy_news', 'x_news_text', 'news_text', '`news_text`', '`news_text`', 201, -1, FALSE, '`news_text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->news_text->Sortable = TRUE; // Allow sort
		$this->fields['news_text'] = &$this->news_text;
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "cpy_news_images") {
			$sDetailUrl = $GLOBALS["cpy_news_images"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_news_id=" . urlencode($this->news_id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "cpy_newslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`cpy_news`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`news_date` DESC";
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
			$this->news_id->setDbValue($conn->Insert_ID());
			$rs['news_id'] = $this->news_id->DbValue;
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
			if (array_key_exists('news_id', $rs))
				ew_AddFilter($where, ew_QuotedName('news_id', $this->DBID) . '=' . ew_QuotedValue($rs['news_id'], $this->news_id->FldDataType, $this->DBID));
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
		return "`news_id` = @news_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->news_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->news_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@news_id@", ew_AdjustSql($this->news_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "cpy_newslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "cpy_newsview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "cpy_newsedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "cpy_newsadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "cpy_newslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_newsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_newsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "cpy_newsadd.php?" . $this->UrlParm($parm);
		else
			$url = "cpy_newsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_newsedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_newsedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_newsadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_newsadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cpy_newsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "news_id:" . ew_VarToJson($this->news_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->news_id->CurrentValue)) {
			$sUrl .= "news_id=" . urlencode($this->news_id->CurrentValue);
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
			if ($isPost && isset($_POST["news_id"]))
				$arKeys[] = $_POST["news_id"];
			elseif (isset($_GET["news_id"]))
				$arKeys[] = $_GET["news_id"];
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
			$this->news_id->CurrentValue = $key;
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
		$this->news_id->setDbValue($rs->fields('news_id'));
		$this->news_status->setDbValue($rs->fields('news_status'));
		$this->type_id->setDbValue($rs->fields('type_id'));
		$this->news_date->setDbValue($rs->fields('news_date'));
		$this->news_title->setDbValue($rs->fields('news_title'));
		$this->news_stext->setDbValue($rs->fields('news_stext'));
		$this->news_image->Upload->DbValue = $rs->fields('news_image');
		$this->news_text->setDbValue($rs->fields('news_text'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// news_id

		$this->news_id->CellCssStyle = "white-space: nowrap;";

		// news_status
		// type_id
		// news_date
		// news_title
		// news_stext
		// news_image
		// news_text
		// news_id

		$this->news_id->ViewValue = $this->news_id->CurrentValue;
		$this->news_id->ViewCustomAttributes = "";

		// news_status
		if (strval($this->news_status->CurrentValue) <> "") {
			$this->news_status->ViewValue = $this->news_status->OptionCaption($this->news_status->CurrentValue);
		} else {
			$this->news_status->ViewValue = NULL;
		}
		$this->news_status->ViewCustomAttributes = "";

		// type_id
		if (strval($this->type_id->CurrentValue) <> "") {
			$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_news_type`";
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

		// news_date
		$this->news_date->ViewValue = $this->news_date->CurrentValue;
		$this->news_date->ViewValue = ew_FormatDateTime($this->news_date->ViewValue, 5);
		$this->news_date->ViewCustomAttributes = "";

		// news_title
		$this->news_title->ViewValue = $this->news_title->CurrentValue;
		$this->news_title->ViewCustomAttributes = "";

		// news_stext
		$this->news_stext->ViewValue = $this->news_stext->CurrentValue;
		$this->news_stext->ViewCustomAttributes = "";

		// news_image
		$this->news_image->UploadPath = '../../assets/img/newsImages/';
		if (!ew_Empty($this->news_image->Upload->DbValue)) {
			$this->news_image->ImageWidth = 200;
			$this->news_image->ImageHeight = 0;
			$this->news_image->ImageAlt = $this->news_image->FldAlt();
			$this->news_image->ViewValue = $this->news_image->Upload->DbValue;
		} else {
			$this->news_image->ViewValue = "";
		}
		$this->news_image->ViewCustomAttributes = "";

		// news_text
		$this->news_text->ViewValue = $this->news_text->CurrentValue;
		$this->news_text->ViewCustomAttributes = "";

		// news_id
		$this->news_id->LinkCustomAttributes = "";
		$this->news_id->HrefValue = "";
		$this->news_id->TooltipValue = "";

		// news_status
		$this->news_status->LinkCustomAttributes = "";
		$this->news_status->HrefValue = "";
		$this->news_status->TooltipValue = "";

		// type_id
		$this->type_id->LinkCustomAttributes = "";
		$this->type_id->HrefValue = "";
		$this->type_id->TooltipValue = "";

		// news_date
		$this->news_date->LinkCustomAttributes = "";
		$this->news_date->HrefValue = "";
		$this->news_date->TooltipValue = "";

		// news_title
		$this->news_title->LinkCustomAttributes = "";
		$this->news_title->HrefValue = "";
		$this->news_title->TooltipValue = "";

		// news_stext
		$this->news_stext->LinkCustomAttributes = "";
		$this->news_stext->HrefValue = "";
		$this->news_stext->TooltipValue = "";

		// news_image
		$this->news_image->LinkCustomAttributes = "";
		$this->news_image->UploadPath = '../../assets/img/newsImages/';
		if (!ew_Empty($this->news_image->Upload->DbValue)) {
			$this->news_image->HrefValue = ew_GetFileUploadUrl($this->news_image, $this->news_image->Upload->DbValue); // Add prefix/suffix
			$this->news_image->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->news_image->HrefValue = ew_FullUrl($this->news_image->HrefValue, "href");
		} else {
			$this->news_image->HrefValue = "";
		}
		$this->news_image->HrefValue2 = $this->news_image->UploadPath . $this->news_image->Upload->DbValue;
		$this->news_image->TooltipValue = "";
		if ($this->news_image->UseColorbox) {
			if (ew_Empty($this->news_image->TooltipValue))
				$this->news_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->news_image->LinkAttrs["data-rel"] = "cpy_news_x_news_image";
			ew_AppendClass($this->news_image->LinkAttrs["class"], "ewLightbox");
		}

		// news_text
		$this->news_text->LinkCustomAttributes = "";
		$this->news_text->HrefValue = "";
		$this->news_text->TooltipValue = "";

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

		// news_id
		$this->news_id->EditAttrs["class"] = "form-control";
		$this->news_id->EditCustomAttributes = "";
		$this->news_id->EditValue = $this->news_id->CurrentValue;
		$this->news_id->ViewCustomAttributes = "";

		// news_status
		$this->news_status->EditAttrs["class"] = "form-control";
		$this->news_status->EditCustomAttributes = "";
		$this->news_status->EditValue = $this->news_status->Options(TRUE);

		// type_id
		$this->type_id->EditAttrs["class"] = "form-control";
		$this->type_id->EditCustomAttributes = "";

		// news_date
		$this->news_date->EditAttrs["class"] = "form-control";
		$this->news_date->EditCustomAttributes = "";
		$this->news_date->EditValue = ew_FormatDateTime($this->news_date->CurrentValue, 5);
		$this->news_date->PlaceHolder = ew_RemoveHtml($this->news_date->FldCaption());

		// news_title
		$this->news_title->EditAttrs["class"] = "form-control";
		$this->news_title->EditCustomAttributes = "";
		$this->news_title->EditValue = $this->news_title->CurrentValue;
		$this->news_title->PlaceHolder = ew_RemoveHtml($this->news_title->FldCaption());

		// news_stext
		$this->news_stext->EditAttrs["class"] = "form-control";
		$this->news_stext->EditCustomAttributes = "";
		$this->news_stext->EditValue = $this->news_stext->CurrentValue;
		$this->news_stext->PlaceHolder = ew_RemoveHtml($this->news_stext->FldCaption());

		// news_image
		$this->news_image->EditAttrs["class"] = "form-control";
		$this->news_image->EditCustomAttributes = "";
		$this->news_image->UploadPath = '../../assets/img/newsImages/';
		if (!ew_Empty($this->news_image->Upload->DbValue)) {
			$this->news_image->ImageWidth = 200;
			$this->news_image->ImageHeight = 0;
			$this->news_image->ImageAlt = $this->news_image->FldAlt();
			$this->news_image->EditValue = $this->news_image->Upload->DbValue;
		} else {
			$this->news_image->EditValue = "";
		}
		if (!ew_Empty($this->news_image->CurrentValue))
			$this->news_image->Upload->FileName = $this->news_image->CurrentValue;

		// news_text
		$this->news_text->EditAttrs["class"] = "form-control";
		$this->news_text->EditCustomAttributes = "";
		$this->news_text->EditValue = $this->news_text->CurrentValue;
		$this->news_text->PlaceHolder = ew_RemoveHtml($this->news_text->FldCaption());

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
					if ($this->news_status->Exportable) $Doc->ExportCaption($this->news_status);
					if ($this->type_id->Exportable) $Doc->ExportCaption($this->type_id);
					if ($this->news_date->Exportable) $Doc->ExportCaption($this->news_date);
					if ($this->news_title->Exportable) $Doc->ExportCaption($this->news_title);
					if ($this->news_stext->Exportable) $Doc->ExportCaption($this->news_stext);
					if ($this->news_image->Exportable) $Doc->ExportCaption($this->news_image);
					if ($this->news_text->Exportable) $Doc->ExportCaption($this->news_text);
				} else {
					if ($this->news_status->Exportable) $Doc->ExportCaption($this->news_status);
					if ($this->type_id->Exportable) $Doc->ExportCaption($this->type_id);
					if ($this->news_date->Exportable) $Doc->ExportCaption($this->news_date);
					if ($this->news_title->Exportable) $Doc->ExportCaption($this->news_title);
					if ($this->news_stext->Exportable) $Doc->ExportCaption($this->news_stext);
					if ($this->news_image->Exportable) $Doc->ExportCaption($this->news_image);
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
						if ($this->news_status->Exportable) $Doc->ExportField($this->news_status);
						if ($this->type_id->Exportable) $Doc->ExportField($this->type_id);
						if ($this->news_date->Exportable) $Doc->ExportField($this->news_date);
						if ($this->news_title->Exportable) $Doc->ExportField($this->news_title);
						if ($this->news_stext->Exportable) $Doc->ExportField($this->news_stext);
						if ($this->news_image->Exportable) $Doc->ExportField($this->news_image);
						if ($this->news_text->Exportable) $Doc->ExportField($this->news_text);
					} else {
						if ($this->news_status->Exportable) $Doc->ExportField($this->news_status);
						if ($this->type_id->Exportable) $Doc->ExportField($this->type_id);
						if ($this->news_date->Exportable) $Doc->ExportField($this->news_date);
						if ($this->news_title->Exportable) $Doc->ExportField($this->news_title);
						if ($this->news_stext->Exportable) $Doc->ExportField($this->news_stext);
						if ($this->news_image->Exportable) $Doc->ExportField($this->news_image);
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
