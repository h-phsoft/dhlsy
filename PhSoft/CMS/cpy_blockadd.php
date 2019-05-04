<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_blockinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "cpy_block_detailgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_block_add = NULL; // Initialize page object first

class ccpy_block_add extends ccpy_block {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_block';

	// Page object name
	var $PageObjName = 'cpy_block_add';

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

		// Table object (cpy_block)
		if (!isset($GLOBALS["cpy_block"]) || get_class($GLOBALS["cpy_block"]) == "ccpy_block") {
			$GLOBALS["cpy_block"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_block"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_block', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_blocklist.php"));
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
		$this->blk_name->SetVisibility();
		$this->blk_status->SetVisibility();
		$this->blk_type->SetVisibility();
		$this->blk_stext->SetVisibility();

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

			// Process auto fill for detail table 'cpy_block_detail'
			if (@$_POST["grid"] == "fcpy_block_detailgrid") {
				if (!isset($GLOBALS["cpy_block_detail_grid"])) $GLOBALS["cpy_block_detail_grid"] = new ccpy_block_detail_grid;
				$GLOBALS["cpy_block_detail_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $cpy_block;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_block);
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
					if ($pageName == "cpy_blockview.php")
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

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["blk_id"] != "") {
				$this->blk_id->setQueryStringValue($_GET["blk_id"]);
				$this->setKey("blk_id", $this->blk_id->CurrentValue); // Set up key
			} else {
				$this->setKey("blk_id", ""); // Clear key
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

		// Set up detail parameters
		$this->SetupDetailParms();

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
					$this->Page_Terminate("cpy_blocklist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_blocklist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_blockview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->blk_id->CurrentValue = NULL;
		$this->blk_id->OldValue = $this->blk_id->CurrentValue;
		$this->blk_name->CurrentValue = NULL;
		$this->blk_name->OldValue = $this->blk_name->CurrentValue;
		$this->blk_status->CurrentValue = 1;
		$this->blk_type->CurrentValue = 1;
		$this->blk_stext->CurrentValue = NULL;
		$this->blk_stext->OldValue = $this->blk_stext->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->blk_name->FldIsDetailKey) {
			$this->blk_name->setFormValue($objForm->GetValue("x_blk_name"));
		}
		if (!$this->blk_status->FldIsDetailKey) {
			$this->blk_status->setFormValue($objForm->GetValue("x_blk_status"));
		}
		if (!$this->blk_type->FldIsDetailKey) {
			$this->blk_type->setFormValue($objForm->GetValue("x_blk_type"));
		}
		if (!$this->blk_stext->FldIsDetailKey) {
			$this->blk_stext->setFormValue($objForm->GetValue("x_blk_stext"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->blk_name->CurrentValue = $this->blk_name->FormValue;
		$this->blk_status->CurrentValue = $this->blk_status->FormValue;
		$this->blk_type->CurrentValue = $this->blk_type->FormValue;
		$this->blk_stext->CurrentValue = $this->blk_stext->FormValue;
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
		$this->blk_id->setDbValue($row['blk_id']);
		$this->blk_name->setDbValue($row['blk_name']);
		$this->blk_status->setDbValue($row['blk_status']);
		$this->blk_type->setDbValue($row['blk_type']);
		$this->blk_stext->setDbValue($row['blk_stext']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['blk_id'] = $this->blk_id->CurrentValue;
		$row['blk_name'] = $this->blk_name->CurrentValue;
		$row['blk_status'] = $this->blk_status->CurrentValue;
		$row['blk_type'] = $this->blk_type->CurrentValue;
		$row['blk_stext'] = $this->blk_stext->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->blk_id->DbValue = $row['blk_id'];
		$this->blk_name->DbValue = $row['blk_name'];
		$this->blk_status->DbValue = $row['blk_status'];
		$this->blk_type->DbValue = $row['blk_type'];
		$this->blk_stext->DbValue = $row['blk_stext'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("blk_id")) <> "")
			$this->blk_id->CurrentValue = $this->getKey("blk_id"); // blk_id
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
		// blk_id
		// blk_name
		// blk_status
		// blk_type
		// blk_stext

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// blk_name
		$this->blk_name->ViewValue = $this->blk_name->CurrentValue;
		$this->blk_name->ViewCustomAttributes = "";

		// blk_status
		if (strval($this->blk_status->CurrentValue) <> "") {
			$this->blk_status->ViewValue = $this->blk_status->OptionCaption($this->blk_status->CurrentValue);
		} else {
			$this->blk_status->ViewValue = NULL;
		}
		$this->blk_status->ViewCustomAttributes = "";

		// blk_type
		if (strval($this->blk_type->CurrentValue) <> "") {
			$this->blk_type->ViewValue = $this->blk_type->OptionCaption($this->blk_type->CurrentValue);
		} else {
			$this->blk_type->ViewValue = NULL;
		}
		$this->blk_type->ViewCustomAttributes = "";

		// blk_stext
		$this->blk_stext->ViewValue = $this->blk_stext->CurrentValue;
		$this->blk_stext->ViewCustomAttributes = "";

			// blk_name
			$this->blk_name->LinkCustomAttributes = "";
			$this->blk_name->HrefValue = "";
			$this->blk_name->TooltipValue = "";

			// blk_status
			$this->blk_status->LinkCustomAttributes = "";
			$this->blk_status->HrefValue = "";
			$this->blk_status->TooltipValue = "";

			// blk_type
			$this->blk_type->LinkCustomAttributes = "";
			$this->blk_type->HrefValue = "";
			$this->blk_type->TooltipValue = "";

			// blk_stext
			$this->blk_stext->LinkCustomAttributes = "";
			$this->blk_stext->HrefValue = "";
			$this->blk_stext->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// blk_name
			$this->blk_name->EditAttrs["class"] = "form-control";
			$this->blk_name->EditCustomAttributes = "";
			$this->blk_name->EditValue = ew_HtmlEncode($this->blk_name->CurrentValue);
			$this->blk_name->PlaceHolder = ew_RemoveHtml($this->blk_name->FldCaption());

			// blk_status
			$this->blk_status->EditAttrs["class"] = "form-control";
			$this->blk_status->EditCustomAttributes = "";
			$this->blk_status->EditValue = $this->blk_status->Options(TRUE);

			// blk_type
			$this->blk_type->EditAttrs["class"] = "form-control";
			$this->blk_type->EditCustomAttributes = "";
			$this->blk_type->EditValue = $this->blk_type->Options(TRUE);

			// blk_stext
			$this->blk_stext->EditAttrs["class"] = "form-control";
			$this->blk_stext->EditCustomAttributes = "";
			$this->blk_stext->EditValue = ew_HtmlEncode($this->blk_stext->CurrentValue);
			$this->blk_stext->PlaceHolder = ew_RemoveHtml($this->blk_stext->FldCaption());

			// Add refer script
			// blk_name

			$this->blk_name->LinkCustomAttributes = "";
			$this->blk_name->HrefValue = "";

			// blk_status
			$this->blk_status->LinkCustomAttributes = "";
			$this->blk_status->HrefValue = "";

			// blk_type
			$this->blk_type->LinkCustomAttributes = "";
			$this->blk_type->HrefValue = "";

			// blk_stext
			$this->blk_stext->LinkCustomAttributes = "";
			$this->blk_stext->HrefValue = "";
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
		if (!$this->blk_name->FldIsDetailKey && !is_null($this->blk_name->FormValue) && $this->blk_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blk_name->FldCaption(), $this->blk_name->ReqErrMsg));
		}
		if (!$this->blk_status->FldIsDetailKey && !is_null($this->blk_status->FormValue) && $this->blk_status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blk_status->FldCaption(), $this->blk_status->ReqErrMsg));
		}
		if (!$this->blk_type->FldIsDetailKey && !is_null($this->blk_type->FormValue) && $this->blk_type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blk_type->FldCaption(), $this->blk_type->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cpy_block_detail", $DetailTblVar) && $GLOBALS["cpy_block_detail"]->DetailAdd) {
			if (!isset($GLOBALS["cpy_block_detail_grid"])) $GLOBALS["cpy_block_detail_grid"] = new ccpy_block_detail_grid(); // get detail page object
			$GLOBALS["cpy_block_detail_grid"]->ValidateGridForm();
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
		if ($this->blk_name->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(blk_name = '" . ew_AdjustSql($this->blk_name->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->blk_name->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->blk_name->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// blk_name
		$this->blk_name->SetDbValueDef($rsnew, $this->blk_name->CurrentValue, "", FALSE);

		// blk_status
		$this->blk_status->SetDbValueDef($rsnew, $this->blk_status->CurrentValue, 0, strval($this->blk_status->CurrentValue) == "");

		// blk_type
		$this->blk_type->SetDbValueDef($rsnew, $this->blk_type->CurrentValue, 0, strval($this->blk_type->CurrentValue) == "");

		// blk_stext
		$this->blk_stext->SetDbValueDef($rsnew, $this->blk_stext->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("cpy_block_detail", $DetailTblVar) && $GLOBALS["cpy_block_detail"]->DetailAdd) {
				$GLOBALS["cpy_block_detail"]->blk_id->setSessionValue($this->blk_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["cpy_block_detail_grid"])) $GLOBALS["cpy_block_detail_grid"] = new ccpy_block_detail_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_block_detail"); // Load user level of detail table
				$AddRow = $GLOBALS["cpy_block_detail_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["cpy_block_detail"]->blk_id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("cpy_block_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["cpy_block_detail_grid"]))
					$GLOBALS["cpy_block_detail_grid"] = new ccpy_block_detail_grid;
				if ($GLOBALS["cpy_block_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cpy_block_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cpy_block_detail_grid"]->CurrentMode = "add";
					$GLOBALS["cpy_block_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cpy_block_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cpy_block_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["cpy_block_detail_grid"]->blk_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_block_detail_grid"]->blk_id->CurrentValue = $this->blk_id->CurrentValue;
					$GLOBALS["cpy_block_detail_grid"]->blk_id->setSessionValue($GLOBALS["cpy_block_detail_grid"]->blk_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_blocklist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($cpy_block_add)) $cpy_block_add = new ccpy_block_add();

// Page init
$cpy_block_add->Page_Init();

// Page main
$cpy_block_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_block_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_blockadd = new ew_Form("fcpy_blockadd", "add");

// Validate form
fcpy_blockadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_blk_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block->blk_name->FldCaption(), $cpy_block->blk_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_blk_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block->blk_status->FldCaption(), $cpy_block->blk_status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_blk_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block->blk_type->FldCaption(), $cpy_block->blk_type->ReqErrMsg)) ?>");

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
fcpy_blockadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_blockadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_blockadd.Lists["x_blk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_blockadd.Lists["x_blk_status"].Options = <?php echo json_encode($cpy_block_add->blk_status->Options()) ?>;
fcpy_blockadd.Lists["x_blk_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_blockadd.Lists["x_blk_type"].Options = <?php echo json_encode($cpy_block_add->blk_type->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_block_add->ShowPageHeader(); ?>
<?php
$cpy_block_add->ShowMessage();
?>
<form name="fcpy_blockadd" id="fcpy_blockadd" class="<?php echo $cpy_block_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_block_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_block_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_block">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_block_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_block->blk_name->Visible) { // blk_name ?>
	<div id="r_blk_name" class="form-group">
		<label id="elh_cpy_block_blk_name" for="x_blk_name" class="<?php echo $cpy_block_add->LeftColumnClass ?>"><?php echo $cpy_block->blk_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_add->RightColumnClass ?>"><div<?php echo $cpy_block->blk_name->CellAttributes() ?>>
<span id="el_cpy_block_blk_name">
<input type="text" data-table="cpy_block" data-field="x_blk_name" name="x_blk_name" id="x_blk_name" placeholder="<?php echo ew_HtmlEncode($cpy_block->blk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_block->blk_name->EditValue ?>"<?php echo $cpy_block->blk_name->EditAttributes() ?>>
</span>
<?php echo $cpy_block->blk_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block->blk_status->Visible) { // blk_status ?>
	<div id="r_blk_status" class="form-group">
		<label id="elh_cpy_block_blk_status" for="x_blk_status" class="<?php echo $cpy_block_add->LeftColumnClass ?>"><?php echo $cpy_block->blk_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_add->RightColumnClass ?>"><div<?php echo $cpy_block->blk_status->CellAttributes() ?>>
<span id="el_cpy_block_blk_status">
<select data-table="cpy_block" data-field="x_blk_status" data-value-separator="<?php echo $cpy_block->blk_status->DisplayValueSeparatorAttribute() ?>" id="x_blk_status" name="x_blk_status"<?php echo $cpy_block->blk_status->EditAttributes() ?>>
<?php echo $cpy_block->blk_status->SelectOptionListHtml("x_blk_status") ?>
</select>
</span>
<?php echo $cpy_block->blk_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block->blk_type->Visible) { // blk_type ?>
	<div id="r_blk_type" class="form-group">
		<label id="elh_cpy_block_blk_type" for="x_blk_type" class="<?php echo $cpy_block_add->LeftColumnClass ?>"><?php echo $cpy_block->blk_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_add->RightColumnClass ?>"><div<?php echo $cpy_block->blk_type->CellAttributes() ?>>
<span id="el_cpy_block_blk_type">
<select data-table="cpy_block" data-field="x_blk_type" data-value-separator="<?php echo $cpy_block->blk_type->DisplayValueSeparatorAttribute() ?>" id="x_blk_type" name="x_blk_type"<?php echo $cpy_block->blk_type->EditAttributes() ?>>
<?php echo $cpy_block->blk_type->SelectOptionListHtml("x_blk_type") ?>
</select>
</span>
<?php echo $cpy_block->blk_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block->blk_stext->Visible) { // blk_stext ?>
	<div id="r_blk_stext" class="form-group">
		<label id="elh_cpy_block_blk_stext" for="x_blk_stext" class="<?php echo $cpy_block_add->LeftColumnClass ?>"><?php echo $cpy_block->blk_stext->FldCaption() ?></label>
		<div class="<?php echo $cpy_block_add->RightColumnClass ?>"><div<?php echo $cpy_block->blk_stext->CellAttributes() ?>>
<span id="el_cpy_block_blk_stext">
<textarea data-table="cpy_block" data-field="x_blk_stext" name="x_blk_stext" id="x_blk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_block->blk_stext->getPlaceHolder()) ?>"<?php echo $cpy_block->blk_stext->EditAttributes() ?>><?php echo $cpy_block->blk_stext->EditValue ?></textarea>
</span>
<?php echo $cpy_block->blk_stext->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("cpy_block_detail", explode(",", $cpy_block->getCurrentDetailTable())) && $cpy_block_detail->DetailAdd) {
?>
<?php if ($cpy_block->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_block_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_block_detailgrid.php" ?>
<?php } ?>
<?php if (!$cpy_block_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_block_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_block_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_blockadd.Init();
</script>
<?php
$cpy_block_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_block_add->Page_Terminate();
?>
