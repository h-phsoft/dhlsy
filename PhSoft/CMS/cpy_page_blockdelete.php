<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_page_blockinfo.php" ?>
<?php include_once "cpy_pageinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_page_block_delete = NULL; // Initialize page object first

class ccpy_page_block_delete extends ccpy_page_block {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_page_block';

	// Page object name
	var $PageObjName = 'cpy_page_block_delete';

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

		// Table object (cpy_page_block)
		if (!isset($GLOBALS["cpy_page_block"]) || get_class($GLOBALS["cpy_page_block"]) == "ccpy_page_block") {
			$GLOBALS["cpy_page_block"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_page_block"];
		}

		// Table object (cpy_page)
		if (!isset($GLOBALS['cpy_page'])) $GLOBALS['cpy_page'] = new ccpy_page();

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_page_block', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_page_blocklist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->page_id->SetVisibility();
		$this->blk_id->SetVisibility();
		$this->pblk_order->SetVisibility();
		$this->pblk_status->SetVisibility();
		$this->pblk_name->SetVisibility();
		$this->pblk_bgcolor->SetVisibility();
		$this->pblk_stext->SetVisibility();

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
		global $EW_EXPORT, $cpy_page_block;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_page_block);
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

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("cpy_page_blocklist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cpy_page_block class, cpy_page_blockinfo.php

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
				$this->Page_Terminate("cpy_page_blocklist.php"); // Return to list
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
		$this->pblk_id->setDbValue($row['pblk_id']);
		$this->page_id->setDbValue($row['page_id']);
		$this->blk_id->setDbValue($row['blk_id']);
		$this->pblk_order->setDbValue($row['pblk_order']);
		$this->pblk_status->setDbValue($row['pblk_status']);
		$this->pblk_name->setDbValue($row['pblk_name']);
		$this->pblk_bgcolor->setDbValue($row['pblk_bgcolor']);
		$this->pblk_stext->setDbValue($row['pblk_stext']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['pblk_id'] = NULL;
		$row['page_id'] = NULL;
		$row['blk_id'] = NULL;
		$row['pblk_order'] = NULL;
		$row['pblk_status'] = NULL;
		$row['pblk_name'] = NULL;
		$row['pblk_bgcolor'] = NULL;
		$row['pblk_stext'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->pblk_id->DbValue = $row['pblk_id'];
		$this->page_id->DbValue = $row['page_id'];
		$this->blk_id->DbValue = $row['blk_id'];
		$this->pblk_order->DbValue = $row['pblk_order'];
		$this->pblk_status->DbValue = $row['pblk_status'];
		$this->pblk_name->DbValue = $row['pblk_name'];
		$this->pblk_bgcolor->DbValue = $row['pblk_bgcolor'];
		$this->pblk_stext->DbValue = $row['pblk_stext'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// pblk_id

		$this->pblk_id->CellCssStyle = "white-space: nowrap;";

		// page_id
		// blk_id
		// pblk_order
		// pblk_status
		// pblk_name
		// pblk_bgcolor
		// pblk_stext

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

		// blk_id
		if (strval($this->blk_id->CurrentValue) <> "") {
			$sFilterWrk = "`blk_id`" . ew_SearchString("=", $this->blk_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `blk_id`, `blk_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_block`";
		$sWhereWrk = "";
		$this->blk_id->LookupFilters = array("dx1" => '`blk_name`');
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

		// pblk_order
		$this->pblk_order->ViewValue = $this->pblk_order->CurrentValue;
		$this->pblk_order->ViewCustomAttributes = "";

		// pblk_status
		if (strval($this->pblk_status->CurrentValue) <> "") {
			$this->pblk_status->ViewValue = $this->pblk_status->OptionCaption($this->pblk_status->CurrentValue);
		} else {
			$this->pblk_status->ViewValue = NULL;
		}
		$this->pblk_status->ViewCustomAttributes = "";

		// pblk_name
		$this->pblk_name->ViewValue = $this->pblk_name->CurrentValue;
		$this->pblk_name->ViewCustomAttributes = "";

		// pblk_bgcolor
		if (strval($this->pblk_bgcolor->CurrentValue) <> "") {
			$this->pblk_bgcolor->ViewValue = $this->pblk_bgcolor->OptionCaption($this->pblk_bgcolor->CurrentValue);
		} else {
			$this->pblk_bgcolor->ViewValue = NULL;
		}
		$this->pblk_bgcolor->ViewCustomAttributes = "";

		// pblk_stext
		$this->pblk_stext->ViewValue = $this->pblk_stext->CurrentValue;
		$this->pblk_stext->ViewCustomAttributes = "";

			// page_id
			$this->page_id->LinkCustomAttributes = "";
			$this->page_id->HrefValue = "";
			$this->page_id->TooltipValue = "";

			// blk_id
			$this->blk_id->LinkCustomAttributes = "";
			$this->blk_id->HrefValue = "";
			$this->blk_id->TooltipValue = "";

			// pblk_order
			$this->pblk_order->LinkCustomAttributes = "";
			$this->pblk_order->HrefValue = "";
			$this->pblk_order->TooltipValue = "";

			// pblk_status
			$this->pblk_status->LinkCustomAttributes = "";
			$this->pblk_status->HrefValue = "";
			$this->pblk_status->TooltipValue = "";

			// pblk_name
			$this->pblk_name->LinkCustomAttributes = "";
			$this->pblk_name->HrefValue = "";
			$this->pblk_name->TooltipValue = "";

			// pblk_bgcolor
			$this->pblk_bgcolor->LinkCustomAttributes = "";
			$this->pblk_bgcolor->HrefValue = "";
			$this->pblk_bgcolor->TooltipValue = "";

			// pblk_stext
			$this->pblk_stext->LinkCustomAttributes = "";
			$this->pblk_stext->HrefValue = "";
			$this->pblk_stext->TooltipValue = "";
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
				$sThisKey .= $row['pblk_id'];
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

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cpy_page") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_page_id"] <> "") {
					$GLOBALS["cpy_page"]->page_id->setQueryStringValue($_GET["fk_page_id"]);
					$this->page_id->setQueryStringValue($GLOBALS["cpy_page"]->page_id->QueryStringValue);
					$this->page_id->setSessionValue($this->page_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cpy_page"]->page_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cpy_page") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_page_id"] <> "") {
					$GLOBALS["cpy_page"]->page_id->setFormValue($_POST["fk_page_id"]);
					$this->page_id->setFormValue($GLOBALS["cpy_page"]->page_id->FormValue);
					$this->page_id->setSessionValue($this->page_id->FormValue);
					if (!is_numeric($GLOBALS["cpy_page"]->page_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cpy_page") {
				if ($this->page_id->CurrentValue == "") $this->page_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_page_blocklist.php"), "", $this->TableVar, TRUE);
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
if (!isset($cpy_page_block_delete)) $cpy_page_block_delete = new ccpy_page_block_delete();

// Page init
$cpy_page_block_delete->Page_Init();

// Page main
$cpy_page_block_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_page_block_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcpy_page_blockdelete = new ew_Form("fcpy_page_blockdelete", "delete");

// Form_CustomValidate event
fcpy_page_blockdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_page_blockdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_page_blockdelete.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_page_blockdelete.Lists["x_page_id"].Data = "<?php echo $cpy_page_block_delete->page_id->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_page_blockdelete.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_page_blockdelete.Lists["x_blk_id"].Data = "<?php echo $cpy_page_block_delete->blk_id->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_page_blockdelete.Lists["x_pblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockdelete.Lists["x_pblk_status"].Options = <?php echo json_encode($cpy_page_block_delete->pblk_status->Options()) ?>;
fcpy_page_blockdelete.Lists["x_pblk_bgcolor"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockdelete.Lists["x_pblk_bgcolor"].Options = <?php echo json_encode($cpy_page_block_delete->pblk_bgcolor->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_page_block_delete->ShowPageHeader(); ?>
<?php
$cpy_page_block_delete->ShowMessage();
?>
<form name="fcpy_page_blockdelete" id="fcpy_page_blockdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_page_block_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_page_block_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_page_block">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cpy_page_block_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
		<th class="<?php echo $cpy_page_block->page_id->HeaderCellClass() ?>"><span id="elh_cpy_page_block_page_id" class="cpy_page_block_page_id"><?php echo $cpy_page_block->page_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
		<th class="<?php echo $cpy_page_block->blk_id->HeaderCellClass() ?>"><span id="elh_cpy_page_block_blk_id" class="cpy_page_block_blk_id"><?php echo $cpy_page_block->blk_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
		<th class="<?php echo $cpy_page_block->pblk_order->HeaderCellClass() ?>"><span id="elh_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order"><?php echo $cpy_page_block->pblk_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
		<th class="<?php echo $cpy_page_block->pblk_status->HeaderCellClass() ?>"><span id="elh_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status"><?php echo $cpy_page_block->pblk_status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
		<th class="<?php echo $cpy_page_block->pblk_name->HeaderCellClass() ?>"><span id="elh_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name"><?php echo $cpy_page_block->pblk_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
		<th class="<?php echo $cpy_page_block->pblk_bgcolor->HeaderCellClass() ?>"><span id="elh_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor"><?php echo $cpy_page_block->pblk_bgcolor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
		<th class="<?php echo $cpy_page_block->pblk_stext->HeaderCellClass() ?>"><span id="elh_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext"><?php echo $cpy_page_block->pblk_stext->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$cpy_page_block_delete->RecCnt = 0;
$i = 0;
while (!$cpy_page_block_delete->Recordset->EOF) {
	$cpy_page_block_delete->RecCnt++;
	$cpy_page_block_delete->RowCnt++;

	// Set row properties
	$cpy_page_block->ResetAttrs();
	$cpy_page_block->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cpy_page_block_delete->LoadRowValues($cpy_page_block_delete->Recordset);

	// Render row
	$cpy_page_block_delete->RenderRow();
?>
	<tr<?php echo $cpy_page_block->RowAttributes() ?>>
<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
		<td<?php echo $cpy_page_block->page_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_page_block_delete->RowCnt ?>_cpy_page_block_page_id" class="cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<?php echo $cpy_page_block->page_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
		<td<?php echo $cpy_page_block->blk_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_page_block_delete->RowCnt ?>_cpy_page_block_blk_id" class="cpy_page_block_blk_id">
<span<?php echo $cpy_page_block->blk_id->ViewAttributes() ?>>
<?php echo $cpy_page_block->blk_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
		<td<?php echo $cpy_page_block->pblk_order->CellAttributes() ?>>
<span id="el<?php echo $cpy_page_block_delete->RowCnt ?>_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order">
<span<?php echo $cpy_page_block->pblk_order->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
		<td<?php echo $cpy_page_block->pblk_status->CellAttributes() ?>>
<span id="el<?php echo $cpy_page_block_delete->RowCnt ?>_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status">
<span<?php echo $cpy_page_block->pblk_status->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
		<td<?php echo $cpy_page_block->pblk_name->CellAttributes() ?>>
<span id="el<?php echo $cpy_page_block_delete->RowCnt ?>_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name">
<span<?php echo $cpy_page_block->pblk_name->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
		<td<?php echo $cpy_page_block->pblk_bgcolor->CellAttributes() ?>>
<span id="el<?php echo $cpy_page_block_delete->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor">
<span<?php echo $cpy_page_block->pblk_bgcolor->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
		<td<?php echo $cpy_page_block->pblk_stext->CellAttributes() ?>>
<span id="el<?php echo $cpy_page_block_delete->RowCnt ?>_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext">
<span<?php echo $cpy_page_block->pblk_stext->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_stext->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$cpy_page_block_delete->Recordset->MoveNext();
}
$cpy_page_block_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_page_block_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcpy_page_blockdelete.Init();
</script>
<?php
$cpy_page_block_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_page_block_delete->Page_Terminate();
?>
