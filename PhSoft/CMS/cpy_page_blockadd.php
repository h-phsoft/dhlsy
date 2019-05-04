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

$cpy_page_block_add = NULL; // Initialize page object first

class ccpy_page_block_add extends ccpy_page_block {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_page_block';

	// Page object name
	var $PageObjName = 'cpy_page_block_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanAdd()) {
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
		// Create form object

		$objForm = new cFormObj();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "cpy_page_blockview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
				}
				echo ew_ArrayToJson(array($row));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["pblk_id"] != "") {
				$this->pblk_id->setQueryStringValue($_GET["pblk_id"]);
				$this->setKey("pblk_id", $this->pblk_id->CurrentValue); // Set up key
			} else {
				$this->setKey("pblk_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cpy_page_blocklist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_page_blocklist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_page_blockview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->pblk_id->CurrentValue = NULL;
		$this->pblk_id->OldValue = $this->pblk_id->CurrentValue;
		$this->page_id->CurrentValue = NULL;
		$this->page_id->OldValue = $this->page_id->CurrentValue;
		$this->blk_id->CurrentValue = NULL;
		$this->blk_id->OldValue = $this->blk_id->CurrentValue;
		$this->pblk_order->CurrentValue = 0;
		$this->pblk_status->CurrentValue = 1;
		$this->pblk_name->CurrentValue = NULL;
		$this->pblk_name->OldValue = $this->pblk_name->CurrentValue;
		$this->pblk_bgcolor->CurrentValue = NULL;
		$this->pblk_bgcolor->OldValue = $this->pblk_bgcolor->CurrentValue;
		$this->pblk_stext->CurrentValue = NULL;
		$this->pblk_stext->OldValue = $this->pblk_stext->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->page_id->FldIsDetailKey) {
			$this->page_id->setFormValue($objForm->GetValue("x_page_id"));
		}
		if (!$this->blk_id->FldIsDetailKey) {
			$this->blk_id->setFormValue($objForm->GetValue("x_blk_id"));
		}
		if (!$this->pblk_order->FldIsDetailKey) {
			$this->pblk_order->setFormValue($objForm->GetValue("x_pblk_order"));
		}
		if (!$this->pblk_status->FldIsDetailKey) {
			$this->pblk_status->setFormValue($objForm->GetValue("x_pblk_status"));
		}
		if (!$this->pblk_name->FldIsDetailKey) {
			$this->pblk_name->setFormValue($objForm->GetValue("x_pblk_name"));
		}
		if (!$this->pblk_bgcolor->FldIsDetailKey) {
			$this->pblk_bgcolor->setFormValue($objForm->GetValue("x_pblk_bgcolor"));
		}
		if (!$this->pblk_stext->FldIsDetailKey) {
			$this->pblk_stext->setFormValue($objForm->GetValue("x_pblk_stext"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->page_id->CurrentValue = $this->page_id->FormValue;
		$this->blk_id->CurrentValue = $this->blk_id->FormValue;
		$this->pblk_order->CurrentValue = $this->pblk_order->FormValue;
		$this->pblk_status->CurrentValue = $this->pblk_status->FormValue;
		$this->pblk_name->CurrentValue = $this->pblk_name->FormValue;
		$this->pblk_bgcolor->CurrentValue = $this->pblk_bgcolor->FormValue;
		$this->pblk_stext->CurrentValue = $this->pblk_stext->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['pblk_id'] = $this->pblk_id->CurrentValue;
		$row['page_id'] = $this->page_id->CurrentValue;
		$row['blk_id'] = $this->blk_id->CurrentValue;
		$row['pblk_order'] = $this->pblk_order->CurrentValue;
		$row['pblk_status'] = $this->pblk_status->CurrentValue;
		$row['pblk_name'] = $this->pblk_name->CurrentValue;
		$row['pblk_bgcolor'] = $this->pblk_bgcolor->CurrentValue;
		$row['pblk_stext'] = $this->pblk_stext->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("pblk_id")) <> "")
			$this->pblk_id->CurrentValue = $this->getKey("pblk_id"); // pblk_id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// pblk_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// page_id
			$this->page_id->EditAttrs["class"] = "form-control";
			$this->page_id->EditCustomAttributes = "";
			if ($this->page_id->getSessionValue() <> "") {
				$this->page_id->CurrentValue = $this->page_id->getSessionValue();
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
			} else {
			if (trim(strval($this->page_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`page_id`" . ew_SearchString("=", $this->page_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `page_id`, `page_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_page`";
			$sWhereWrk = "";
			$this->page_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->page_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->page_id->EditValue = $arwrk;
			}

			// blk_id
			$this->blk_id->EditCustomAttributes = "";
			if (trim(strval($this->blk_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`blk_id`" . ew_SearchString("=", $this->blk_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `blk_id`, `blk_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_block`";
			$sWhereWrk = "";
			$this->blk_id->LookupFilters = array("dx1" => '`blk_name`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->blk_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->blk_id->ViewValue = $this->blk_id->DisplayValue($arwrk);
			} else {
				$this->blk_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->blk_id->EditValue = $arwrk;

			// pblk_order
			$this->pblk_order->EditAttrs["class"] = "form-control";
			$this->pblk_order->EditCustomAttributes = "";
			$this->pblk_order->EditValue = ew_HtmlEncode($this->pblk_order->CurrentValue);
			$this->pblk_order->PlaceHolder = ew_RemoveHtml($this->pblk_order->FldCaption());

			// pblk_status
			$this->pblk_status->EditAttrs["class"] = "form-control";
			$this->pblk_status->EditCustomAttributes = "";
			$this->pblk_status->EditValue = $this->pblk_status->Options(TRUE);

			// pblk_name
			$this->pblk_name->EditAttrs["class"] = "form-control";
			$this->pblk_name->EditCustomAttributes = "";
			$this->pblk_name->EditValue = ew_HtmlEncode($this->pblk_name->CurrentValue);
			$this->pblk_name->PlaceHolder = ew_RemoveHtml($this->pblk_name->FldCaption());

			// pblk_bgcolor
			$this->pblk_bgcolor->EditAttrs["class"] = "form-control";
			$this->pblk_bgcolor->EditCustomAttributes = "";
			$this->pblk_bgcolor->EditValue = $this->pblk_bgcolor->Options(TRUE);

			// pblk_stext
			$this->pblk_stext->EditAttrs["class"] = "form-control";
			$this->pblk_stext->EditCustomAttributes = "";
			$this->pblk_stext->EditValue = ew_HtmlEncode($this->pblk_stext->CurrentValue);
			$this->pblk_stext->PlaceHolder = ew_RemoveHtml($this->pblk_stext->FldCaption());

			// Add refer script
			// page_id

			$this->page_id->LinkCustomAttributes = "";
			$this->page_id->HrefValue = "";

			// blk_id
			$this->blk_id->LinkCustomAttributes = "";
			$this->blk_id->HrefValue = "";

			// pblk_order
			$this->pblk_order->LinkCustomAttributes = "";
			$this->pblk_order->HrefValue = "";

			// pblk_status
			$this->pblk_status->LinkCustomAttributes = "";
			$this->pblk_status->HrefValue = "";

			// pblk_name
			$this->pblk_name->LinkCustomAttributes = "";
			$this->pblk_name->HrefValue = "";

			// pblk_bgcolor
			$this->pblk_bgcolor->LinkCustomAttributes = "";
			$this->pblk_bgcolor->HrefValue = "";

			// pblk_stext
			$this->pblk_stext->LinkCustomAttributes = "";
			$this->pblk_stext->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->page_id->FldIsDetailKey && !is_null($this->page_id->FormValue) && $this->page_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_id->FldCaption(), $this->page_id->ReqErrMsg));
		}
		if (!$this->blk_id->FldIsDetailKey && !is_null($this->blk_id->FormValue) && $this->blk_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blk_id->FldCaption(), $this->blk_id->ReqErrMsg));
		}
		if (!$this->pblk_order->FldIsDetailKey && !is_null($this->pblk_order->FormValue) && $this->pblk_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pblk_order->FldCaption(), $this->pblk_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->pblk_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->pblk_order->FldErrMsg());
		}
		if (!$this->pblk_status->FldIsDetailKey && !is_null($this->pblk_status->FormValue) && $this->pblk_status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pblk_status->FldCaption(), $this->pblk_status->ReqErrMsg));
		}
		if (!$this->pblk_name->FldIsDetailKey && !is_null($this->pblk_name->FormValue) && $this->pblk_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pblk_name->FldCaption(), $this->pblk_name->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// page_id
		$this->page_id->SetDbValueDef($rsnew, $this->page_id->CurrentValue, 0, FALSE);

		// blk_id
		$this->blk_id->SetDbValueDef($rsnew, $this->blk_id->CurrentValue, 0, FALSE);

		// pblk_order
		$this->pblk_order->SetDbValueDef($rsnew, $this->pblk_order->CurrentValue, 0, strval($this->pblk_order->CurrentValue) == "");

		// pblk_status
		$this->pblk_status->SetDbValueDef($rsnew, $this->pblk_status->CurrentValue, 0, strval($this->pblk_status->CurrentValue) == "");

		// pblk_name
		$this->pblk_name->SetDbValueDef($rsnew, $this->pblk_name->CurrentValue, "", FALSE);

		// pblk_bgcolor
		$this->pblk_bgcolor->SetDbValueDef($rsnew, $this->pblk_bgcolor->CurrentValue, NULL, FALSE);

		// pblk_stext
		$this->pblk_stext->SetDbValueDef($rsnew, $this->pblk_stext->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_page_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `page_id` AS `LinkFld`, `page_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_page`";
			$sWhereWrk = "";
			$this->page_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`page_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->page_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_blk_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `blk_id` AS `LinkFld`, `blk_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_block`";
			$sWhereWrk = "{filter}";
			$this->blk_id->LookupFilters = array("dx1" => '`blk_name`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`blk_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->blk_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_page_block_add)) $cpy_page_block_add = new ccpy_page_block_add();

// Page init
$cpy_page_block_add->Page_Init();

// Page main
$cpy_page_block_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_page_block_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_page_blockadd = new ew_Form("fcpy_page_blockadd", "add");

// Validate form
fcpy_page_blockadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_page_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->page_id->FldCaption(), $cpy_page_block->page_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_blk_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->blk_id->FldCaption(), $cpy_page_block->blk_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pblk_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->pblk_order->FldCaption(), $cpy_page_block->pblk_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pblk_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_page_block->pblk_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pblk_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->pblk_status->FldCaption(), $cpy_page_block->pblk_status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pblk_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_block->pblk_name->FldCaption(), $cpy_page_block->pblk_name->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fcpy_page_blockadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_page_blockadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_page_blockadd.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_page_blockadd.Lists["x_page_id"].Data = "<?php echo $cpy_page_block_add->page_id->LookupFilterQuery(FALSE, "add") ?>";
fcpy_page_blockadd.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_page_blockadd.Lists["x_blk_id"].Data = "<?php echo $cpy_page_block_add->blk_id->LookupFilterQuery(FALSE, "add") ?>";
fcpy_page_blockadd.Lists["x_pblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockadd.Lists["x_pblk_status"].Options = <?php echo json_encode($cpy_page_block_add->pblk_status->Options()) ?>;
fcpy_page_blockadd.Lists["x_pblk_bgcolor"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockadd.Lists["x_pblk_bgcolor"].Options = <?php echo json_encode($cpy_page_block_add->pblk_bgcolor->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_page_block_add->ShowPageHeader(); ?>
<?php
$cpy_page_block_add->ShowMessage();
?>
<form name="fcpy_page_blockadd" id="fcpy_page_blockadd" class="<?php echo $cpy_page_block_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_page_block_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_page_block_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_page_block">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_page_block_add->IsModal) ?>">
<?php if ($cpy_page_block->getCurrentMasterTable() == "cpy_page") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cpy_page">
<input type="hidden" name="fk_page_id" value="<?php echo $cpy_page_block->page_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
	<div id="r_page_id" class="form-group">
		<label id="elh_cpy_page_block_page_id" for="x_page_id" class="<?php echo $cpy_page_block_add->LeftColumnClass ?>"><?php echo $cpy_page_block->page_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_add->RightColumnClass ?>"><div<?php echo $cpy_page_block->page_id->CellAttributes() ?>>
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el_cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_page_id" name="x_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x_page_id" name="x_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x_page_id") ?>
</select>
</span>
<?php } ?>
<?php echo $cpy_page_block->page_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
	<div id="r_blk_id" class="form-group">
		<label id="elh_cpy_page_block_blk_id" for="x_blk_id" class="<?php echo $cpy_page_block_add->LeftColumnClass ?>"><?php echo $cpy_page_block->blk_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_add->RightColumnClass ?>"><div<?php echo $cpy_page_block->blk_id->CellAttributes() ?>>
<span id="el_cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x_blk_id" id="x_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<?php echo $cpy_page_block->blk_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
	<div id="r_pblk_order" class="form-group">
		<label id="elh_cpy_page_block_pblk_order" for="x_pblk_order" class="<?php echo $cpy_page_block_add->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_add->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_order->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x_pblk_order" id="x_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<?php echo $cpy_page_block->pblk_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
	<div id="r_pblk_status" class="form-group">
		<label id="elh_cpy_page_block_pblk_status" for="x_pblk_status" class="<?php echo $cpy_page_block_add->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_add->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_status->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x_pblk_status" name="x_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x_pblk_status") ?>
</select>
</span>
<?php echo $cpy_page_block->pblk_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
	<div id="r_pblk_name" class="form-group">
		<label id="elh_cpy_page_block_pblk_name" for="x_pblk_name" class="<?php echo $cpy_page_block_add->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_add->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_name->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x_pblk_name" id="x_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<?php echo $cpy_page_block->pblk_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
	<div id="r_pblk_bgcolor" class="form-group">
		<label id="elh_cpy_page_block_pblk_bgcolor" for="x_pblk_bgcolor" class="<?php echo $cpy_page_block_add->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_bgcolor->FldCaption() ?></label>
		<div class="<?php echo $cpy_page_block_add->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_bgcolor->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x_pblk_bgcolor" name="x_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x_pblk_bgcolor") ?>
</select>
</span>
<?php echo $cpy_page_block->pblk_bgcolor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
	<div id="r_pblk_stext" class="form-group">
		<label id="elh_cpy_page_block_pblk_stext" for="x_pblk_stext" class="<?php echo $cpy_page_block_add->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_stext->FldCaption() ?></label>
		<div class="<?php echo $cpy_page_block_add->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_stext->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x_pblk_stext" id="x_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<?php echo $cpy_page_block->pblk_stext->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_page_block_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_page_block_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_page_block_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_page_blockadd.Init();
</script>
<?php
$cpy_page_block_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_page_block_add->Page_Terminate();
?>
