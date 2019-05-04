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

$cpy_page_block_edit = NULL; // Initialize page object first

class ccpy_page_block_edit extends ccpy_page_block {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_page_block';

	// Page object name
	var $PageObjName = 'cpy_page_block_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";

		// Load record by position
		$loadByPosition = FALSE;
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_pblk_id")) {
				$this->pblk_id->setFormValue($objForm->GetValue("x_pblk_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["pblk_id"])) {
				$this->pblk_id->setQueryStringValue($_GET["pblk_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->pblk_id->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("cpy_page_blocklist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->pblk_id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->pblk_id->CurrentValue) == strval($this->Recordset->fields('pblk_id'))) {
						$this->setStartRecordNumber($this->StartRec); // Save record position
						$loaded = TRUE;
						break;
					} else {
						$this->StartRec++;
						$this->Recordset->MoveNext();
					}
				}
			}
		}

		// Load current row values
		if ($loaded)
			$this->LoadRowValues($this->Recordset);

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("cpy_page_blocklist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "cpy_page_blocklist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
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
		if (!$this->pblk_id->FldIsDetailKey)
			$this->pblk_id->setFormValue($objForm->GetValue("x_pblk_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->pblk_id->CurrentValue = $this->pblk_id->FormValue;
		$this->page_id->CurrentValue = $this->page_id->FormValue;
		$this->blk_id->CurrentValue = $this->blk_id->FormValue;
		$this->pblk_order->CurrentValue = $this->pblk_order->FormValue;
		$this->pblk_status->CurrentValue = $this->pblk_status->FormValue;
		$this->pblk_name->CurrentValue = $this->pblk_name->FormValue;
		$this->pblk_bgcolor->CurrentValue = $this->pblk_bgcolor->FormValue;
		$this->pblk_stext->CurrentValue = $this->pblk_stext->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Edit refer script
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// page_id
			$this->page_id->SetDbValueDef($rsnew, $this->page_id->CurrentValue, 0, $this->page_id->ReadOnly);

			// blk_id
			$this->blk_id->SetDbValueDef($rsnew, $this->blk_id->CurrentValue, 0, $this->blk_id->ReadOnly);

			// pblk_order
			$this->pblk_order->SetDbValueDef($rsnew, $this->pblk_order->CurrentValue, 0, $this->pblk_order->ReadOnly);

			// pblk_status
			$this->pblk_status->SetDbValueDef($rsnew, $this->pblk_status->CurrentValue, 0, $this->pblk_status->ReadOnly);

			// pblk_name
			$this->pblk_name->SetDbValueDef($rsnew, $this->pblk_name->CurrentValue, "", $this->pblk_name->ReadOnly);

			// pblk_bgcolor
			$this->pblk_bgcolor->SetDbValueDef($rsnew, $this->pblk_bgcolor->CurrentValue, NULL, $this->pblk_bgcolor->ReadOnly);

			// pblk_stext
			$this->pblk_stext->SetDbValueDef($rsnew, $this->pblk_stext->CurrentValue, NULL, $this->pblk_stext->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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
			$this->setSessionWhere($this->GetDetailFilter());

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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($cpy_page_block_edit)) $cpy_page_block_edit = new ccpy_page_block_edit();

// Page init
$cpy_page_block_edit->Page_Init();

// Page main
$cpy_page_block_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_page_block_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcpy_page_blockedit = new ew_Form("fcpy_page_blockedit", "edit");

// Validate form
fcpy_page_blockedit.Validate = function() {
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
fcpy_page_blockedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_page_blockedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_page_blockedit.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_page_blockedit.Lists["x_page_id"].Data = "<?php echo $cpy_page_block_edit->page_id->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_page_blockedit.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_page_blockedit.Lists["x_blk_id"].Data = "<?php echo $cpy_page_block_edit->blk_id->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_page_blockedit.Lists["x_pblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockedit.Lists["x_pblk_status"].Options = <?php echo json_encode($cpy_page_block_edit->pblk_status->Options()) ?>;
fcpy_page_blockedit.Lists["x_pblk_bgcolor"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blockedit.Lists["x_pblk_bgcolor"].Options = <?php echo json_encode($cpy_page_block_edit->pblk_bgcolor->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_page_block_edit->ShowPageHeader(); ?>
<?php
$cpy_page_block_edit->ShowMessage();
?>
<?php if (!$cpy_page_block_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_page_block_edit->Pager)) $cpy_page_block_edit->Pager = new cPrevNextPager($cpy_page_block_edit->StartRec, $cpy_page_block_edit->DisplayRecs, $cpy_page_block_edit->TotalRecs, $cpy_page_block_edit->AutoHidePager) ?>
<?php if ($cpy_page_block_edit->Pager->RecordCount > 0 && $cpy_page_block_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_page_block_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_page_block_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_page_block_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_page_block_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_page_block_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_page_block_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcpy_page_blockedit" id="fcpy_page_blockedit" class="<?php echo $cpy_page_block_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_page_block_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_page_block_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_page_block">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($cpy_page_block_edit->IsModal) ?>">
<?php if ($cpy_page_block->getCurrentMasterTable() == "cpy_page") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cpy_page">
<input type="hidden" name="fk_page_id" value="<?php echo $cpy_page_block->page_id->getSessionValue() ?>">
<?php } ?>
<div class="ewEditDiv"><!-- page* -->
<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
	<div id="r_page_id" class="form-group">
		<label id="elh_cpy_page_block_page_id" for="x_page_id" class="<?php echo $cpy_page_block_edit->LeftColumnClass ?>"><?php echo $cpy_page_block->page_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_edit->RightColumnClass ?>"><div<?php echo $cpy_page_block->page_id->CellAttributes() ?>>
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
		<label id="elh_cpy_page_block_blk_id" for="x_blk_id" class="<?php echo $cpy_page_block_edit->LeftColumnClass ?>"><?php echo $cpy_page_block->blk_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_edit->RightColumnClass ?>"><div<?php echo $cpy_page_block->blk_id->CellAttributes() ?>>
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
		<label id="elh_cpy_page_block_pblk_order" for="x_pblk_order" class="<?php echo $cpy_page_block_edit->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_edit->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_order->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x_pblk_order" id="x_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<?php echo $cpy_page_block->pblk_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
	<div id="r_pblk_status" class="form-group">
		<label id="elh_cpy_page_block_pblk_status" for="x_pblk_status" class="<?php echo $cpy_page_block_edit->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_edit->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_status->CellAttributes() ?>>
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
		<label id="elh_cpy_page_block_pblk_name" for="x_pblk_name" class="<?php echo $cpy_page_block_edit->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_page_block_edit->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_name->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x_pblk_name" id="x_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<?php echo $cpy_page_block->pblk_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
	<div id="r_pblk_bgcolor" class="form-group">
		<label id="elh_cpy_page_block_pblk_bgcolor" for="x_pblk_bgcolor" class="<?php echo $cpy_page_block_edit->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_bgcolor->FldCaption() ?></label>
		<div class="<?php echo $cpy_page_block_edit->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_bgcolor->CellAttributes() ?>>
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
		<label id="elh_cpy_page_block_pblk_stext" for="x_pblk_stext" class="<?php echo $cpy_page_block_edit->LeftColumnClass ?>"><?php echo $cpy_page_block->pblk_stext->FldCaption() ?></label>
		<div class="<?php echo $cpy_page_block_edit->RightColumnClass ?>"><div<?php echo $cpy_page_block->pblk_stext->CellAttributes() ?>>
<span id="el_cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x_pblk_stext" id="x_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<?php echo $cpy_page_block->pblk_stext->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_id" name="x_pblk_id" id="x_pblk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_id->CurrentValue) ?>">
<?php if (!$cpy_page_block_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_page_block_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_page_block_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$cpy_page_block_edit->IsModal) { ?>
<?php if (!isset($cpy_page_block_edit->Pager)) $cpy_page_block_edit->Pager = new cPrevNextPager($cpy_page_block_edit->StartRec, $cpy_page_block_edit->DisplayRecs, $cpy_page_block_edit->TotalRecs, $cpy_page_block_edit->AutoHidePager) ?>
<?php if ($cpy_page_block_edit->Pager->RecordCount > 0 && $cpy_page_block_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_page_block_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_page_block_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_page_block_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_page_block_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_page_block_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_page_block_edit->PageUrl() ?>start=<?php echo $cpy_page_block_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_page_block_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fcpy_page_blockedit.Init();
</script>
<?php
$cpy_page_block_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_page_block_edit->Page_Terminate();
?>
