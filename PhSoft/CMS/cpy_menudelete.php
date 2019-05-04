<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_menuinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_menu_delete = NULL; // Initialize page object first

class ccpy_menu_delete extends ccpy_menu {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_menu';

	// Page object name
	var $PageObjName = 'cpy_menu_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (cpy_menu)
		if (!isset($GLOBALS["cpy_menu"]) || get_class($GLOBALS["cpy_menu"]) == "ccpy_menu") {
			$GLOBALS["cpy_menu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_menu"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_menu', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (phs_users)
		if (!isset($UserTable)) {
			$UserTable = new cphs_users();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("cpy_menulist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->menu_pid->SetVisibility();
		$this->menu_rid->SetVisibility();
		$this->menu_order->SetVisibility();
		$this->mode_id->SetVisibility();
		$this->type_id->SetVisibility();
		$this->srch_id->SetVisibility();
		$this->menu_status->SetVisibility();
		$this->menu_name->SetVisibility();
		$this->menu_icon->SetVisibility();
		$this->page_id->SetVisibility();
		$this->menu_href->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $cpy_menu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_menu);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("cpy_menulist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cpy_menu class, cpy_menuinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("cpy_menulist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->menu_id->setDbValue($row['menu_id']);
		$this->menu_pid->setDbValue($row['menu_pid']);
		$this->menu_rid->setDbValue($row['menu_rid']);
		$this->menu_order->setDbValue($row['menu_order']);
		$this->mode_id->setDbValue($row['mode_id']);
		$this->type_id->setDbValue($row['type_id']);
		$this->srch_id->setDbValue($row['srch_id']);
		$this->menu_status->setDbValue($row['menu_status']);
		$this->menu_name->setDbValue($row['menu_name']);
		$this->menu_icon->Upload->DbValue = $row['menu_icon'];
		$this->menu_icon->CurrentValue = $this->menu_icon->Upload->DbValue;
		$this->page_id->setDbValue($row['page_id']);
		$this->menu_href->setDbValue($row['menu_href']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['menu_id'] = NULL;
		$row['menu_pid'] = NULL;
		$row['menu_rid'] = NULL;
		$row['menu_order'] = NULL;
		$row['mode_id'] = NULL;
		$row['type_id'] = NULL;
		$row['srch_id'] = NULL;
		$row['menu_status'] = NULL;
		$row['menu_name'] = NULL;
		$row['menu_icon'] = NULL;
		$row['page_id'] = NULL;
		$row['menu_href'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->menu_id->DbValue = $row['menu_id'];
		$this->menu_pid->DbValue = $row['menu_pid'];
		$this->menu_rid->DbValue = $row['menu_rid'];
		$this->menu_order->DbValue = $row['menu_order'];
		$this->mode_id->DbValue = $row['mode_id'];
		$this->type_id->DbValue = $row['type_id'];
		$this->srch_id->DbValue = $row['srch_id'];
		$this->menu_status->DbValue = $row['menu_status'];
		$this->menu_name->DbValue = $row['menu_name'];
		$this->menu_icon->Upload->DbValue = $row['menu_icon'];
		$this->page_id->DbValue = $row['page_id'];
		$this->menu_href->DbValue = $row['menu_href'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['menu_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_menulist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_menu_delete)) $cpy_menu_delete = new ccpy_menu_delete();

// Page init
$cpy_menu_delete->Page_Init();

// Page main
$cpy_menu_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_menu_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcpy_menudelete = new ew_Form("fcpy_menudelete", "delete");

// Form_CustomValidate event
fcpy_menudelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_menudelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_menudelete.Lists["x_menu_pid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_pname","x_menu_name","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_vmenu"};
fcpy_menudelete.Lists["x_menu_pid"].Data = "<?php echo $cpy_menu_delete->menu_pid->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_menudelete.Lists["x_menu_rid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_pname","x_menu_name","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_vmenu"};
fcpy_menudelete.Lists["x_menu_rid"].Data = "<?php echo $cpy_menu_delete->menu_rid->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_menudelete.Lists["x_mode_id"] = {"LinkField":"x_mode_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_mode_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_mode"};
fcpy_menudelete.Lists["x_mode_id"].Data = "<?php echo $cpy_menu_delete->mode_id->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_menudelete.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_type"};
fcpy_menudelete.Lists["x_type_id"].Data = "<?php echo $cpy_menu_delete->type_id->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_menudelete.Lists["x_srch_id"] = {"LinkField":"x_srch_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_srch_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_search"};
fcpy_menudelete.Lists["x_srch_id"].Data = "<?php echo $cpy_menu_delete->srch_id->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_menudelete.Lists["x_menu_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_menudelete.Lists["x_menu_status"].Options = <?php echo json_encode($cpy_menu_delete->menu_status->Options()) ?>;
fcpy_menudelete.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_menudelete.Lists["x_page_id"].Data = "<?php echo $cpy_menu_delete->page_id->LookupFilterQuery(FALSE, "delete") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_menu_delete->ShowPageHeader(); ?>
<?php
$cpy_menu_delete->ShowMessage();
?>
<form name="fcpy_menudelete" id="fcpy_menudelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_menu_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_menu_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_menu">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cpy_menu_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($cpy_menu->menu_pid->Visible) { // menu_pid ?>
		<th class="<?php echo $cpy_menu->menu_pid->HeaderCellClass() ?>"><span id="elh_cpy_menu_menu_pid" class="cpy_menu_menu_pid"><?php echo $cpy_menu->menu_pid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->menu_rid->Visible) { // menu_rid ?>
		<th class="<?php echo $cpy_menu->menu_rid->HeaderCellClass() ?>"><span id="elh_cpy_menu_menu_rid" class="cpy_menu_menu_rid"><?php echo $cpy_menu->menu_rid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->menu_order->Visible) { // menu_order ?>
		<th class="<?php echo $cpy_menu->menu_order->HeaderCellClass() ?>"><span id="elh_cpy_menu_menu_order" class="cpy_menu_menu_order"><?php echo $cpy_menu->menu_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->mode_id->Visible) { // mode_id ?>
		<th class="<?php echo $cpy_menu->mode_id->HeaderCellClass() ?>"><span id="elh_cpy_menu_mode_id" class="cpy_menu_mode_id"><?php echo $cpy_menu->mode_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->type_id->Visible) { // type_id ?>
		<th class="<?php echo $cpy_menu->type_id->HeaderCellClass() ?>"><span id="elh_cpy_menu_type_id" class="cpy_menu_type_id"><?php echo $cpy_menu->type_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->srch_id->Visible) { // srch_id ?>
		<th class="<?php echo $cpy_menu->srch_id->HeaderCellClass() ?>"><span id="elh_cpy_menu_srch_id" class="cpy_menu_srch_id"><?php echo $cpy_menu->srch_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->menu_status->Visible) { // menu_status ?>
		<th class="<?php echo $cpy_menu->menu_status->HeaderCellClass() ?>"><span id="elh_cpy_menu_menu_status" class="cpy_menu_menu_status"><?php echo $cpy_menu->menu_status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->menu_name->Visible) { // menu_name ?>
		<th class="<?php echo $cpy_menu->menu_name->HeaderCellClass() ?>"><span id="elh_cpy_menu_menu_name" class="cpy_menu_menu_name"><?php echo $cpy_menu->menu_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->menu_icon->Visible) { // menu_icon ?>
		<th class="<?php echo $cpy_menu->menu_icon->HeaderCellClass() ?>"><span id="elh_cpy_menu_menu_icon" class="cpy_menu_menu_icon"><?php echo $cpy_menu->menu_icon->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->page_id->Visible) { // page_id ?>
		<th class="<?php echo $cpy_menu->page_id->HeaderCellClass() ?>"><span id="elh_cpy_menu_page_id" class="cpy_menu_page_id"><?php echo $cpy_menu->page_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_menu->menu_href->Visible) { // menu_href ?>
		<th class="<?php echo $cpy_menu->menu_href->HeaderCellClass() ?>"><span id="elh_cpy_menu_menu_href" class="cpy_menu_menu_href"><?php echo $cpy_menu->menu_href->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$cpy_menu_delete->RecCnt = 0;
$i = 0;
while (!$cpy_menu_delete->Recordset->EOF) {
	$cpy_menu_delete->RecCnt++;
	$cpy_menu_delete->RowCnt++;

	// Set row properties
	$cpy_menu->ResetAttrs();
	$cpy_menu->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cpy_menu_delete->LoadRowValues($cpy_menu_delete->Recordset);

	// Render row
	$cpy_menu_delete->RenderRow();
?>
	<tr<?php echo $cpy_menu->RowAttributes() ?>>
<?php if ($cpy_menu->menu_pid->Visible) { // menu_pid ?>
		<td<?php echo $cpy_menu->menu_pid->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_menu_pid" class="cpy_menu_menu_pid">
<span<?php echo $cpy_menu->menu_pid->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_pid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->menu_rid->Visible) { // menu_rid ?>
		<td<?php echo $cpy_menu->menu_rid->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_menu_rid" class="cpy_menu_menu_rid">
<span<?php echo $cpy_menu->menu_rid->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_rid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->menu_order->Visible) { // menu_order ?>
		<td<?php echo $cpy_menu->menu_order->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_menu_order" class="cpy_menu_menu_order">
<span<?php echo $cpy_menu->menu_order->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->mode_id->Visible) { // mode_id ?>
		<td<?php echo $cpy_menu->mode_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_mode_id" class="cpy_menu_mode_id">
<span<?php echo $cpy_menu->mode_id->ViewAttributes() ?>>
<?php echo $cpy_menu->mode_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->type_id->Visible) { // type_id ?>
		<td<?php echo $cpy_menu->type_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_type_id" class="cpy_menu_type_id">
<span<?php echo $cpy_menu->type_id->ViewAttributes() ?>>
<?php echo $cpy_menu->type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->srch_id->Visible) { // srch_id ?>
		<td<?php echo $cpy_menu->srch_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_srch_id" class="cpy_menu_srch_id">
<span<?php echo $cpy_menu->srch_id->ViewAttributes() ?>>
<?php echo $cpy_menu->srch_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->menu_status->Visible) { // menu_status ?>
		<td<?php echo $cpy_menu->menu_status->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_menu_status" class="cpy_menu_menu_status">
<span<?php echo $cpy_menu->menu_status->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->menu_name->Visible) { // menu_name ?>
		<td<?php echo $cpy_menu->menu_name->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_menu_name" class="cpy_menu_menu_name">
<span<?php echo $cpy_menu->menu_name->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->menu_icon->Visible) { // menu_icon ?>
		<td<?php echo $cpy_menu->menu_icon->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_menu_icon" class="cpy_menu_menu_icon">
<span>
<?php echo ew_GetFileViewTag($cpy_menu->menu_icon, $cpy_menu->menu_icon->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->page_id->Visible) { // page_id ?>
		<td<?php echo $cpy_menu->page_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_page_id" class="cpy_menu_page_id">
<span<?php echo $cpy_menu->page_id->ViewAttributes() ?>>
<?php echo $cpy_menu->page_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_menu->menu_href->Visible) { // menu_href ?>
		<td<?php echo $cpy_menu->menu_href->CellAttributes() ?>>
<span id="el<?php echo $cpy_menu_delete->RowCnt ?>_cpy_menu_menu_href" class="cpy_menu_menu_href">
<span<?php echo $cpy_menu->menu_href->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_href->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$cpy_menu_delete->Recordset->MoveNext();
}
$cpy_menu_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_menu_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcpy_menudelete.Init();
</script>
<?php
$cpy_menu_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_menu_delete->Page_Terminate();
?>
