<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_newsinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_news_delete = NULL; // Initialize page object first

class ccpy_news_delete extends ccpy_news {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_news';

	// Page object name
	var $PageObjName = 'cpy_news_delete';

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

		// Table object (cpy_news)
		if (!isset($GLOBALS["cpy_news"]) || get_class($GLOBALS["cpy_news"]) == "ccpy_news") {
			$GLOBALS["cpy_news"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_news"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_news', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_newslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->news_status->SetVisibility();
		$this->type_id->SetVisibility();
		$this->news_date->SetVisibility();
		$this->news_title->SetVisibility();
		$this->news_stext->SetVisibility();
		$this->news_image->SetVisibility();

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
		global $EW_EXPORT, $cpy_news;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_news);
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
			$this->Page_Terminate("cpy_newslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cpy_news class, cpy_newsinfo.php

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
				$this->Page_Terminate("cpy_newslist.php"); // Return to list
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
		$this->news_id->setDbValue($row['news_id']);
		$this->news_status->setDbValue($row['news_status']);
		$this->type_id->setDbValue($row['type_id']);
		$this->news_date->setDbValue($row['news_date']);
		$this->news_title->setDbValue($row['news_title']);
		$this->news_stext->setDbValue($row['news_stext']);
		$this->news_image->Upload->DbValue = $row['news_image'];
		$this->news_image->CurrentValue = $this->news_image->Upload->DbValue;
		$this->news_text->setDbValue($row['news_text']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['news_id'] = NULL;
		$row['news_status'] = NULL;
		$row['type_id'] = NULL;
		$row['news_date'] = NULL;
		$row['news_title'] = NULL;
		$row['news_stext'] = NULL;
		$row['news_image'] = NULL;
		$row['news_text'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->news_id->DbValue = $row['news_id'];
		$this->news_status->DbValue = $row['news_status'];
		$this->type_id->DbValue = $row['type_id'];
		$this->news_date->DbValue = $row['news_date'];
		$this->news_title->DbValue = $row['news_title'];
		$this->news_stext->DbValue = $row['news_stext'];
		$this->news_image->Upload->DbValue = $row['news_image'];
		$this->news_text->DbValue = $row['news_text'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// news_id

		$this->news_id->CellCssStyle = "white-space: nowrap;";

		// news_status
		// type_id
		// news_date
		// news_title
		// news_stext
		// news_image
		// news_text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
				$sThisKey .= $row['news_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_newslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($cpy_news_delete)) $cpy_news_delete = new ccpy_news_delete();

// Page init
$cpy_news_delete->Page_Init();

// Page main
$cpy_news_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_news_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcpy_newsdelete = new ew_Form("fcpy_newsdelete", "delete");

// Form_CustomValidate event
fcpy_newsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_newsdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_newsdelete.Lists["x_news_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_newsdelete.Lists["x_news_status"].Options = <?php echo json_encode($cpy_news_delete->news_status->Options()) ?>;
fcpy_newsdelete.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_news_type"};
fcpy_newsdelete.Lists["x_type_id"].Data = "<?php echo $cpy_news_delete->type_id->LookupFilterQuery(FALSE, "delete") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_news_delete->ShowPageHeader(); ?>
<?php
$cpy_news_delete->ShowMessage();
?>
<form name="fcpy_newsdelete" id="fcpy_newsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_news_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_news_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_news">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cpy_news_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($cpy_news->news_status->Visible) { // news_status ?>
		<th class="<?php echo $cpy_news->news_status->HeaderCellClass() ?>"><span id="elh_cpy_news_news_status" class="cpy_news_news_status"><?php echo $cpy_news->news_status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_news->type_id->Visible) { // type_id ?>
		<th class="<?php echo $cpy_news->type_id->HeaderCellClass() ?>"><span id="elh_cpy_news_type_id" class="cpy_news_type_id"><?php echo $cpy_news->type_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_news->news_date->Visible) { // news_date ?>
		<th class="<?php echo $cpy_news->news_date->HeaderCellClass() ?>"><span id="elh_cpy_news_news_date" class="cpy_news_news_date"><?php echo $cpy_news->news_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_news->news_title->Visible) { // news_title ?>
		<th class="<?php echo $cpy_news->news_title->HeaderCellClass() ?>"><span id="elh_cpy_news_news_title" class="cpy_news_news_title"><?php echo $cpy_news->news_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_news->news_stext->Visible) { // news_stext ?>
		<th class="<?php echo $cpy_news->news_stext->HeaderCellClass() ?>"><span id="elh_cpy_news_news_stext" class="cpy_news_news_stext"><?php echo $cpy_news->news_stext->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_news->news_image->Visible) { // news_image ?>
		<th class="<?php echo $cpy_news->news_image->HeaderCellClass() ?>"><span id="elh_cpy_news_news_image" class="cpy_news_news_image"><?php echo $cpy_news->news_image->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$cpy_news_delete->RecCnt = 0;
$i = 0;
while (!$cpy_news_delete->Recordset->EOF) {
	$cpy_news_delete->RecCnt++;
	$cpy_news_delete->RowCnt++;

	// Set row properties
	$cpy_news->ResetAttrs();
	$cpy_news->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cpy_news_delete->LoadRowValues($cpy_news_delete->Recordset);

	// Render row
	$cpy_news_delete->RenderRow();
?>
	<tr<?php echo $cpy_news->RowAttributes() ?>>
<?php if ($cpy_news->news_status->Visible) { // news_status ?>
		<td<?php echo $cpy_news->news_status->CellAttributes() ?>>
<span id="el<?php echo $cpy_news_delete->RowCnt ?>_cpy_news_news_status" class="cpy_news_news_status">
<span<?php echo $cpy_news->news_status->ViewAttributes() ?>>
<?php echo $cpy_news->news_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_news->type_id->Visible) { // type_id ?>
		<td<?php echo $cpy_news->type_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_news_delete->RowCnt ?>_cpy_news_type_id" class="cpy_news_type_id">
<span<?php echo $cpy_news->type_id->ViewAttributes() ?>>
<?php echo $cpy_news->type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_news->news_date->Visible) { // news_date ?>
		<td<?php echo $cpy_news->news_date->CellAttributes() ?>>
<span id="el<?php echo $cpy_news_delete->RowCnt ?>_cpy_news_news_date" class="cpy_news_news_date">
<span<?php echo $cpy_news->news_date->ViewAttributes() ?>>
<?php echo $cpy_news->news_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_news->news_title->Visible) { // news_title ?>
		<td<?php echo $cpy_news->news_title->CellAttributes() ?>>
<span id="el<?php echo $cpy_news_delete->RowCnt ?>_cpy_news_news_title" class="cpy_news_news_title">
<span<?php echo $cpy_news->news_title->ViewAttributes() ?>>
<?php echo $cpy_news->news_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_news->news_stext->Visible) { // news_stext ?>
		<td<?php echo $cpy_news->news_stext->CellAttributes() ?>>
<span id="el<?php echo $cpy_news_delete->RowCnt ?>_cpy_news_news_stext" class="cpy_news_news_stext">
<span<?php echo $cpy_news->news_stext->ViewAttributes() ?>>
<?php echo $cpy_news->news_stext->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_news->news_image->Visible) { // news_image ?>
		<td<?php echo $cpy_news->news_image->CellAttributes() ?>>
<span id="el<?php echo $cpy_news_delete->RowCnt ?>_cpy_news_news_image" class="cpy_news_news_image">
<span>
<?php echo ew_GetFileViewTag($cpy_news->news_image, $cpy_news->news_image->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$cpy_news_delete->Recordset->MoveNext();
}
$cpy_news_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_news_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcpy_newsdelete.Init();
</script>
<?php
$cpy_news_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_news_delete->Page_Terminate();
?>
