<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_block_detailinfo.php" ?>
<?php include_once "cpy_blockinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_block_detail_add = NULL; // Initialize page object first

class ccpy_block_detail_add extends ccpy_block_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_block_detail';

	// Page object name
	var $PageObjName = 'cpy_block_detail_add';

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

		// Table object (cpy_block_detail)
		if (!isset($GLOBALS["cpy_block_detail"]) || get_class($GLOBALS["cpy_block_detail"]) == "ccpy_block_detail") {
			$GLOBALS["cpy_block_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_block_detail"];
		}

		// Table object (cpy_block)
		if (!isset($GLOBALS['cpy_block'])) $GLOBALS['cpy_block'] = new ccpy_block();

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_block_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_block_detaillist.php"));
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
		$this->blk_id->SetVisibility();
		$this->dblk_order->SetVisibility();
		$this->dblk_type->SetVisibility();
		$this->dblk_status->SetVisibility();
		$this->dblk_name->SetVisibility();
		$this->dblk_image->SetVisibility();
		$this->dblk_stext->SetVisibility();
		$this->dblk_text->SetVisibility();

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
		global $EW_EXPORT, $cpy_block_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_block_detail);
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
					if ($pageName == "cpy_block_detailview.php")
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
			if (@$_GET["dblk_id"] != "") {
				$this->dblk_id->setQueryStringValue($_GET["dblk_id"]);
				$this->setKey("dblk_id", $this->dblk_id->CurrentValue); // Set up key
			} else {
				$this->setKey("dblk_id", ""); // Clear key
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
					$this->Page_Terminate("cpy_block_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_block_detaillist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_block_detailview.php")
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
		$this->dblk_image->Upload->Index = $objForm->Index;
		$this->dblk_image->Upload->UploadFile();
		$this->dblk_image->CurrentValue = $this->dblk_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->dblk_id->CurrentValue = NULL;
		$this->dblk_id->OldValue = $this->dblk_id->CurrentValue;
		$this->blk_id->CurrentValue = NULL;
		$this->blk_id->OldValue = $this->blk_id->CurrentValue;
		$this->dblk_order->CurrentValue = 1;
		$this->dblk_type->CurrentValue = 1;
		$this->dblk_status->CurrentValue = 1;
		$this->dblk_name->CurrentValue = NULL;
		$this->dblk_name->OldValue = $this->dblk_name->CurrentValue;
		$this->dblk_image->Upload->DbValue = NULL;
		$this->dblk_image->OldValue = $this->dblk_image->Upload->DbValue;
		$this->dblk_image->CurrentValue = NULL; // Clear file related field
		$this->dblk_stext->CurrentValue = NULL;
		$this->dblk_stext->OldValue = $this->dblk_stext->CurrentValue;
		$this->dblk_text->CurrentValue = NULL;
		$this->dblk_text->OldValue = $this->dblk_text->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->blk_id->FldIsDetailKey) {
			$this->blk_id->setFormValue($objForm->GetValue("x_blk_id"));
		}
		if (!$this->dblk_order->FldIsDetailKey) {
			$this->dblk_order->setFormValue($objForm->GetValue("x_dblk_order"));
		}
		if (!$this->dblk_type->FldIsDetailKey) {
			$this->dblk_type->setFormValue($objForm->GetValue("x_dblk_type"));
		}
		if (!$this->dblk_status->FldIsDetailKey) {
			$this->dblk_status->setFormValue($objForm->GetValue("x_dblk_status"));
		}
		if (!$this->dblk_name->FldIsDetailKey) {
			$this->dblk_name->setFormValue($objForm->GetValue("x_dblk_name"));
		}
		if (!$this->dblk_stext->FldIsDetailKey) {
			$this->dblk_stext->setFormValue($objForm->GetValue("x_dblk_stext"));
		}
		if (!$this->dblk_text->FldIsDetailKey) {
			$this->dblk_text->setFormValue($objForm->GetValue("x_dblk_text"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->blk_id->CurrentValue = $this->blk_id->FormValue;
		$this->dblk_order->CurrentValue = $this->dblk_order->FormValue;
		$this->dblk_type->CurrentValue = $this->dblk_type->FormValue;
		$this->dblk_status->CurrentValue = $this->dblk_status->FormValue;
		$this->dblk_name->CurrentValue = $this->dblk_name->FormValue;
		$this->dblk_stext->CurrentValue = $this->dblk_stext->FormValue;
		$this->dblk_text->CurrentValue = $this->dblk_text->FormValue;
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
		$this->dblk_id->setDbValue($row['dblk_id']);
		$this->blk_id->setDbValue($row['blk_id']);
		$this->dblk_order->setDbValue($row['dblk_order']);
		$this->dblk_type->setDbValue($row['dblk_type']);
		$this->dblk_status->setDbValue($row['dblk_status']);
		$this->dblk_name->setDbValue($row['dblk_name']);
		$this->dblk_image->Upload->DbValue = $row['dblk_image'];
		$this->dblk_image->CurrentValue = $this->dblk_image->Upload->DbValue;
		$this->dblk_stext->setDbValue($row['dblk_stext']);
		$this->dblk_text->setDbValue($row['dblk_text']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['dblk_id'] = $this->dblk_id->CurrentValue;
		$row['blk_id'] = $this->blk_id->CurrentValue;
		$row['dblk_order'] = $this->dblk_order->CurrentValue;
		$row['dblk_type'] = $this->dblk_type->CurrentValue;
		$row['dblk_status'] = $this->dblk_status->CurrentValue;
		$row['dblk_name'] = $this->dblk_name->CurrentValue;
		$row['dblk_image'] = $this->dblk_image->Upload->DbValue;
		$row['dblk_stext'] = $this->dblk_stext->CurrentValue;
		$row['dblk_text'] = $this->dblk_text->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->dblk_id->DbValue = $row['dblk_id'];
		$this->blk_id->DbValue = $row['blk_id'];
		$this->dblk_order->DbValue = $row['dblk_order'];
		$this->dblk_type->DbValue = $row['dblk_type'];
		$this->dblk_status->DbValue = $row['dblk_status'];
		$this->dblk_name->DbValue = $row['dblk_name'];
		$this->dblk_image->Upload->DbValue = $row['dblk_image'];
		$this->dblk_stext->DbValue = $row['dblk_stext'];
		$this->dblk_text->DbValue = $row['dblk_text'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("dblk_id")) <> "")
			$this->dblk_id->CurrentValue = $this->getKey("dblk_id"); // dblk_id
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
		// dblk_id
		// blk_id
		// dblk_order
		// dblk_type
		// dblk_status
		// dblk_name
		// dblk_image
		// dblk_stext
		// dblk_text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			if (trim(strval($this->blk_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`blk_id`" . ew_SearchString("=", $this->blk_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `blk_id`, `blk_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_block`";
			$sWhereWrk = "";
			$this->blk_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->blk_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->blk_id->EditValue = $arwrk;
			}

			// dblk_order
			$this->dblk_order->EditAttrs["class"] = "form-control";
			$this->dblk_order->EditCustomAttributes = "";
			$this->dblk_order->EditValue = ew_HtmlEncode($this->dblk_order->CurrentValue);
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
			$this->dblk_name->EditValue = ew_HtmlEncode($this->dblk_name->CurrentValue);
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
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->dblk_image);

			// dblk_stext
			$this->dblk_stext->EditAttrs["class"] = "form-control";
			$this->dblk_stext->EditCustomAttributes = "";
			$this->dblk_stext->EditValue = ew_HtmlEncode($this->dblk_stext->CurrentValue);
			$this->dblk_stext->PlaceHolder = ew_RemoveHtml($this->dblk_stext->FldCaption());

			// dblk_text
			$this->dblk_text->EditAttrs["class"] = "form-control";
			$this->dblk_text->EditCustomAttributes = "";
			$this->dblk_text->EditValue = ew_HtmlEncode($this->dblk_text->CurrentValue);
			$this->dblk_text->PlaceHolder = ew_RemoveHtml($this->dblk_text->FldCaption());

			// Add refer script
			// blk_id

			$this->blk_id->LinkCustomAttributes = "";
			$this->blk_id->HrefValue = "";

			// dblk_order
			$this->dblk_order->LinkCustomAttributes = "";
			$this->dblk_order->HrefValue = "";

			// dblk_type
			$this->dblk_type->LinkCustomAttributes = "";
			$this->dblk_type->HrefValue = "";

			// dblk_status
			$this->dblk_status->LinkCustomAttributes = "";
			$this->dblk_status->HrefValue = "";

			// dblk_name
			$this->dblk_name->LinkCustomAttributes = "";
			$this->dblk_name->HrefValue = "";

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

			// dblk_stext
			$this->dblk_stext->LinkCustomAttributes = "";
			$this->dblk_stext->HrefValue = "";

			// dblk_text
			$this->dblk_text->LinkCustomAttributes = "";
			$this->dblk_text->HrefValue = "";
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
		if (!$this->blk_id->FldIsDetailKey && !is_null($this->blk_id->FormValue) && $this->blk_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->blk_id->FldCaption(), $this->blk_id->ReqErrMsg));
		}
		if (!$this->dblk_order->FldIsDetailKey && !is_null($this->dblk_order->FormValue) && $this->dblk_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dblk_order->FldCaption(), $this->dblk_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->dblk_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->dblk_order->FldErrMsg());
		}
		if (!$this->dblk_type->FldIsDetailKey && !is_null($this->dblk_type->FormValue) && $this->dblk_type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dblk_type->FldCaption(), $this->dblk_type->ReqErrMsg));
		}
		if (!$this->dblk_status->FldIsDetailKey && !is_null($this->dblk_status->FormValue) && $this->dblk_status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dblk_status->FldCaption(), $this->dblk_status->ReqErrMsg));
		}
		if (!$this->dblk_name->FldIsDetailKey && !is_null($this->dblk_name->FormValue) && $this->dblk_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dblk_name->FldCaption(), $this->dblk_name->ReqErrMsg));
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
			$this->dblk_image->OldUploadPath = '../../assets/img/blkImages/';
			$this->dblk_image->UploadPath = $this->dblk_image->OldUploadPath;
		}
		$rsnew = array();

		// blk_id
		$this->blk_id->SetDbValueDef($rsnew, $this->blk_id->CurrentValue, 0, FALSE);

		// dblk_order
		$this->dblk_order->SetDbValueDef($rsnew, $this->dblk_order->CurrentValue, 0, strval($this->dblk_order->CurrentValue) == "");

		// dblk_type
		$this->dblk_type->SetDbValueDef($rsnew, $this->dblk_type->CurrentValue, 0, strval($this->dblk_type->CurrentValue) == "");

		// dblk_status
		$this->dblk_status->SetDbValueDef($rsnew, $this->dblk_status->CurrentValue, 0, strval($this->dblk_status->CurrentValue) == "");

		// dblk_name
		$this->dblk_name->SetDbValueDef($rsnew, $this->dblk_name->CurrentValue, "", FALSE);

		// dblk_image
		if ($this->dblk_image->Visible && !$this->dblk_image->Upload->KeepFile) {
			$this->dblk_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->dblk_image->Upload->FileName == "") {
				$rsnew['dblk_image'] = NULL;
			} else {
				$rsnew['dblk_image'] = $this->dblk_image->Upload->FileName;
			}
		}

		// dblk_stext
		$this->dblk_stext->SetDbValueDef($rsnew, $this->dblk_stext->CurrentValue, NULL, FALSE);

		// dblk_text
		$this->dblk_text->SetDbValueDef($rsnew, $this->dblk_text->CurrentValue, NULL, FALSE);
		if ($this->dblk_image->Visible && !$this->dblk_image->Upload->KeepFile) {
			$this->dblk_image->UploadPath = '../../assets/img/blkImages/';
			if (!ew_Empty($this->dblk_image->Upload->Value)) {
				$rsnew['dblk_image'] = ew_UploadFileNameEx($this->dblk_image->PhysicalUploadPath(), $rsnew['dblk_image']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->dblk_image->Visible && !$this->dblk_image->Upload->KeepFile) {
					if (!ew_Empty($this->dblk_image->Upload->Value)) {
						if (!$this->dblk_image->Upload->SaveToFile($rsnew['dblk_image'], TRUE)) {
							$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
							return FALSE;
						}
					}
				}
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

		// dblk_image
		ew_CleanUploadTempPath($this->dblk_image, $this->dblk_image->Upload->Index);
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
			if ($sMasterTblVar == "cpy_block") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_blk_id"] <> "") {
					$GLOBALS["cpy_block"]->blk_id->setQueryStringValue($_GET["fk_blk_id"]);
					$this->blk_id->setQueryStringValue($GLOBALS["cpy_block"]->blk_id->QueryStringValue);
					$this->blk_id->setSessionValue($this->blk_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cpy_block"]->blk_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "cpy_block") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_blk_id"] <> "") {
					$GLOBALS["cpy_block"]->blk_id->setFormValue($_POST["fk_blk_id"]);
					$this->blk_id->setFormValue($GLOBALS["cpy_block"]->blk_id->FormValue);
					$this->blk_id->setSessionValue($this->blk_id->FormValue);
					if (!is_numeric($GLOBALS["cpy_block"]->blk_id->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cpy_block") {
				if ($this->blk_id->CurrentValue == "") $this->blk_id->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_block_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_blk_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `blk_id` AS `LinkFld`, `blk_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_block`";
			$sWhereWrk = "";
			$this->blk_id->LookupFilters = array();
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
if (!isset($cpy_block_detail_add)) $cpy_block_detail_add = new ccpy_block_detail_add();

// Page init
$cpy_block_detail_add->Page_Init();

// Page main
$cpy_block_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_block_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_block_detailadd = new ew_Form("fcpy_block_detailadd", "add");

// Validate form
fcpy_block_detailadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_blk_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->blk_id->FldCaption(), $cpy_block_detail->blk_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_order->FldCaption(), $cpy_block_detail->dblk_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_block_detail->dblk_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dblk_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_type->FldCaption(), $cpy_block_detail->dblk_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_status->FldCaption(), $cpy_block_detail->dblk_status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dblk_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_block_detail->dblk_name->FldCaption(), $cpy_block_detail->dblk_name->ReqErrMsg)) ?>");

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
fcpy_block_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_block_detailadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_block_detailadd.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_block_detailadd.Lists["x_blk_id"].Data = "<?php echo $cpy_block_detail_add->blk_id->LookupFilterQuery(FALSE, "add") ?>";
fcpy_block_detailadd.Lists["x_dblk_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_block_detailadd.Lists["x_dblk_type"].Options = <?php echo json_encode($cpy_block_detail_add->dblk_type->Options()) ?>;
fcpy_block_detailadd.Lists["x_dblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_block_detailadd.Lists["x_dblk_status"].Options = <?php echo json_encode($cpy_block_detail_add->dblk_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_block_detail_add->ShowPageHeader(); ?>
<?php
$cpy_block_detail_add->ShowMessage();
?>
<form name="fcpy_block_detailadd" id="fcpy_block_detailadd" class="<?php echo $cpy_block_detail_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_block_detail_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_block_detail_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_block_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_block_detail_add->IsModal) ?>">
<?php if ($cpy_block_detail->getCurrentMasterTable() == "cpy_block") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cpy_block">
<input type="hidden" name="fk_blk_id" value="<?php echo $cpy_block_detail->blk_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_block_detail->blk_id->Visible) { // blk_id ?>
	<div id="r_blk_id" class="form-group">
		<label id="elh_cpy_block_detail_blk_id" for="x_blk_id" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->blk_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->blk_id->CellAttributes() ?>>
<?php if ($cpy_block_detail->blk_id->getSessionValue() <> "") { ?>
<span id="el_cpy_block_detail_blk_id">
<span<?php echo $cpy_block_detail->blk_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_block_detail->blk_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_blk_id" name="x_blk_id" value="<?php echo ew_HtmlEncode($cpy_block_detail->blk_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cpy_block_detail_blk_id">
<select data-table="cpy_block_detail" data-field="x_blk_id" data-value-separator="<?php echo $cpy_block_detail->blk_id->DisplayValueSeparatorAttribute() ?>" id="x_blk_id" name="x_blk_id"<?php echo $cpy_block_detail->blk_id->EditAttributes() ?>>
<?php echo $cpy_block_detail->blk_id->SelectOptionListHtml("x_blk_id") ?>
</select>
</span>
<?php } ?>
<?php echo $cpy_block_detail->blk_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_order->Visible) { // dblk_order ?>
	<div id="r_dblk_order" class="form-group">
		<label id="elh_cpy_block_detail_dblk_order" for="x_dblk_order" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->dblk_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_order->CellAttributes() ?>>
<span id="el_cpy_block_detail_dblk_order">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_order" name="x_dblk_order" id="x_dblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_order->EditValue ?>"<?php echo $cpy_block_detail->dblk_order->EditAttributes() ?>>
</span>
<?php echo $cpy_block_detail->dblk_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_type->Visible) { // dblk_type ?>
	<div id="r_dblk_type" class="form-group">
		<label id="elh_cpy_block_detail_dblk_type" for="x_dblk_type" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->dblk_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_type->CellAttributes() ?>>
<span id="el_cpy_block_detail_dblk_type">
<select data-table="cpy_block_detail" data-field="x_dblk_type" data-value-separator="<?php echo $cpy_block_detail->dblk_type->DisplayValueSeparatorAttribute() ?>" id="x_dblk_type" name="x_dblk_type"<?php echo $cpy_block_detail->dblk_type->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_type->SelectOptionListHtml("x_dblk_type") ?>
</select>
</span>
<?php echo $cpy_block_detail->dblk_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_status->Visible) { // dblk_status ?>
	<div id="r_dblk_status" class="form-group">
		<label id="elh_cpy_block_detail_dblk_status" for="x_dblk_status" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->dblk_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_status->CellAttributes() ?>>
<span id="el_cpy_block_detail_dblk_status">
<select data-table="cpy_block_detail" data-field="x_dblk_status" data-value-separator="<?php echo $cpy_block_detail->dblk_status->DisplayValueSeparatorAttribute() ?>" id="x_dblk_status" name="x_dblk_status"<?php echo $cpy_block_detail->dblk_status->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_status->SelectOptionListHtml("x_dblk_status") ?>
</select>
</span>
<?php echo $cpy_block_detail->dblk_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_name->Visible) { // dblk_name ?>
	<div id="r_dblk_name" class="form-group">
		<label id="elh_cpy_block_detail_dblk_name" for="x_dblk_name" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->dblk_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_name->CellAttributes() ?>>
<span id="el_cpy_block_detail_dblk_name">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_name" name="x_dblk_name" id="x_dblk_name" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_name->EditValue ?>"<?php echo $cpy_block_detail->dblk_name->EditAttributes() ?>>
</span>
<?php echo $cpy_block_detail->dblk_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_image->Visible) { // dblk_image ?>
	<div id="r_dblk_image" class="form-group">
		<label id="elh_cpy_block_detail_dblk_image" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->dblk_image->FldCaption() ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_image->CellAttributes() ?>>
<span id="el_cpy_block_detail_dblk_image">
<div id="fd_x_dblk_image">
<span title="<?php echo $cpy_block_detail->dblk_image->FldTitle() ? $cpy_block_detail->dblk_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_block_detail->dblk_image->ReadOnly || $cpy_block_detail->dblk_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_block_detail" data-field="x_dblk_image" name="x_dblk_image" id="x_dblk_image"<?php echo $cpy_block_detail->dblk_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_dblk_image" id= "fn_x_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_dblk_image" id= "fa_x_dblk_image" value="0">
<input type="hidden" name="fs_x_dblk_image" id= "fs_x_dblk_image" value="200">
<input type="hidden" name="fx_x_dblk_image" id= "fx_x_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_dblk_image" id= "fm_x_dblk_image" value="<?php echo $cpy_block_detail->dblk_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_dblk_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_block_detail->dblk_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_stext->Visible) { // dblk_stext ?>
	<div id="r_dblk_stext" class="form-group">
		<label id="elh_cpy_block_detail_dblk_stext" for="x_dblk_stext" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->dblk_stext->FldCaption() ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_stext->CellAttributes() ?>>
<span id="el_cpy_block_detail_dblk_stext">
<textarea data-table="cpy_block_detail" data-field="x_dblk_stext" name="x_dblk_stext" id="x_dblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_block_detail->dblk_stext->EditAttributes() ?>><?php echo $cpy_block_detail->dblk_stext->EditValue ?></textarea>
</span>
<?php echo $cpy_block_detail->dblk_stext->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_text->Visible) { // dblk_text ?>
	<div id="r_dblk_text" class="form-group">
		<label id="elh_cpy_block_detail_dblk_text" class="<?php echo $cpy_block_detail_add->LeftColumnClass ?>"><?php echo $cpy_block_detail->dblk_text->FldCaption() ?></label>
		<div class="<?php echo $cpy_block_detail_add->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_text->CellAttributes() ?>>
<span id="el_cpy_block_detail_dblk_text">
<?php ew_AppendClass($cpy_block_detail->dblk_text->EditAttrs["class"], "editor"); ?>
<textarea data-table="cpy_block_detail" data-field="x_dblk_text" name="x_dblk_text" id="x_dblk_text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_text->getPlaceHolder()) ?>"<?php echo $cpy_block_detail->dblk_text->EditAttributes() ?>><?php echo $cpy_block_detail->dblk_text->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fcpy_block_detailadd", "x_dblk_text", 35, 4, <?php echo ($cpy_block_detail->dblk_text->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $cpy_block_detail->dblk_text->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_block_detail_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_block_detail_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_block_detail_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_block_detailadd.Init();
</script>
<?php
$cpy_block_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_block_detail_add->Page_Terminate();
?>
