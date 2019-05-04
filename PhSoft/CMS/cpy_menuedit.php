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

$cpy_menu_edit = NULL; // Initialize page object first

class ccpy_menu_edit extends ccpy_menu {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_menu';

	// Page object name
	var $PageObjName = 'cpy_menu_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_menulist.php"));
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "cpy_menuview.php")
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
			if ($objForm->HasValue("x_menu_id")) {
				$this->menu_id->setFormValue($objForm->GetValue("x_menu_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["menu_id"])) {
				$this->menu_id->setQueryStringValue($_GET["menu_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->menu_id->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("cpy_menulist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->menu_id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->menu_id->CurrentValue) == strval($this->Recordset->fields('menu_id'))) {
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
					$this->Page_Terminate("cpy_menulist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "cpy_menulist.php")
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
		$this->menu_icon->Upload->Index = $objForm->Index;
		$this->menu_icon->Upload->UploadFile();
		$this->menu_icon->CurrentValue = $this->menu_icon->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->menu_pid->FldIsDetailKey) {
			$this->menu_pid->setFormValue($objForm->GetValue("x_menu_pid"));
		}
		if (!$this->menu_rid->FldIsDetailKey) {
			$this->menu_rid->setFormValue($objForm->GetValue("x_menu_rid"));
		}
		if (!$this->menu_order->FldIsDetailKey) {
			$this->menu_order->setFormValue($objForm->GetValue("x_menu_order"));
		}
		if (!$this->mode_id->FldIsDetailKey) {
			$this->mode_id->setFormValue($objForm->GetValue("x_mode_id"));
		}
		if (!$this->type_id->FldIsDetailKey) {
			$this->type_id->setFormValue($objForm->GetValue("x_type_id"));
		}
		if (!$this->srch_id->FldIsDetailKey) {
			$this->srch_id->setFormValue($objForm->GetValue("x_srch_id"));
		}
		if (!$this->menu_status->FldIsDetailKey) {
			$this->menu_status->setFormValue($objForm->GetValue("x_menu_status"));
		}
		if (!$this->menu_name->FldIsDetailKey) {
			$this->menu_name->setFormValue($objForm->GetValue("x_menu_name"));
		}
		if (!$this->page_id->FldIsDetailKey) {
			$this->page_id->setFormValue($objForm->GetValue("x_page_id"));
		}
		if (!$this->menu_href->FldIsDetailKey) {
			$this->menu_href->setFormValue($objForm->GetValue("x_menu_href"));
		}
		if (!$this->menu_id->FldIsDetailKey)
			$this->menu_id->setFormValue($objForm->GetValue("x_menu_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->menu_id->CurrentValue = $this->menu_id->FormValue;
		$this->menu_pid->CurrentValue = $this->menu_pid->FormValue;
		$this->menu_rid->CurrentValue = $this->menu_rid->FormValue;
		$this->menu_order->CurrentValue = $this->menu_order->FormValue;
		$this->mode_id->CurrentValue = $this->mode_id->FormValue;
		$this->type_id->CurrentValue = $this->type_id->FormValue;
		$this->srch_id->CurrentValue = $this->srch_id->FormValue;
		$this->menu_status->CurrentValue = $this->menu_status->FormValue;
		$this->menu_name->CurrentValue = $this->menu_name->FormValue;
		$this->page_id->CurrentValue = $this->page_id->FormValue;
		$this->menu_href->CurrentValue = $this->menu_href->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("menu_id")) <> "")
			$this->menu_id->CurrentValue = $this->getKey("menu_id"); // menu_id
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
		// menu_id
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// menu_pid
			$this->menu_pid->EditAttrs["class"] = "form-control";
			$this->menu_pid->EditCustomAttributes = "";
			if (trim(strval($this->menu_pid->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`menu_id`" . ew_SearchString("=", $this->menu_pid->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `menu_id`, `menu_pname` AS `DispFld`, `menu_name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_vmenu`";
			$sWhereWrk = "";
			$this->menu_pid->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->menu_pid, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->menu_pid->EditValue = $arwrk;

			// menu_rid
			$this->menu_rid->EditAttrs["class"] = "form-control";
			$this->menu_rid->EditCustomAttributes = "";
			if (trim(strval($this->menu_rid->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`menu_id`" . ew_SearchString("=", $this->menu_rid->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `menu_id`, `menu_pname` AS `DispFld`, `menu_name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_vmenu`";
			$sWhereWrk = "";
			$this->menu_rid->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->menu_rid, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->menu_rid->EditValue = $arwrk;

			// menu_order
			$this->menu_order->EditAttrs["class"] = "form-control";
			$this->menu_order->EditCustomAttributes = "";
			$this->menu_order->EditValue = ew_HtmlEncode($this->menu_order->CurrentValue);
			$this->menu_order->PlaceHolder = ew_RemoveHtml($this->menu_order->FldCaption());

			// mode_id
			$this->mode_id->EditAttrs["class"] = "form-control";
			$this->mode_id->EditCustomAttributes = "";
			if (trim(strval($this->mode_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`mode_id`" . ew_SearchString("=", $this->mode_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `mode_id`, `mode_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_menu_mode`";
			$sWhereWrk = "";
			$this->mode_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->mode_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->mode_id->EditValue = $arwrk;

			// type_id
			$this->type_id->EditAttrs["class"] = "form-control";
			$this->type_id->EditCustomAttributes = "";
			if (trim(strval($this->type_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_menu_type`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->type_id->EditValue = $arwrk;

			// srch_id
			$this->srch_id->EditAttrs["class"] = "form-control";
			$this->srch_id->EditCustomAttributes = "";
			if (trim(strval($this->srch_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`srch_id`" . ew_SearchString("=", $this->srch_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `srch_id`, `srch_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_menu_search`";
			$sWhereWrk = "";
			$this->srch_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->srch_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->srch_id->EditValue = $arwrk;

			// menu_status
			$this->menu_status->EditAttrs["class"] = "form-control";
			$this->menu_status->EditCustomAttributes = "";
			$this->menu_status->EditValue = $this->menu_status->Options(TRUE);

			// menu_name
			$this->menu_name->EditAttrs["class"] = "form-control";
			$this->menu_name->EditCustomAttributes = "";
			$this->menu_name->EditValue = ew_HtmlEncode($this->menu_name->CurrentValue);
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
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->menu_icon);

			// page_id
			$this->page_id->EditAttrs["class"] = "form-control";
			$this->page_id->EditCustomAttributes = "";
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

			// menu_href
			$this->menu_href->EditAttrs["class"] = "form-control";
			$this->menu_href->EditCustomAttributes = "";
			$this->menu_href->EditValue = ew_HtmlEncode($this->menu_href->CurrentValue);
			$this->menu_href->PlaceHolder = ew_RemoveHtml($this->menu_href->FldCaption());

			// Edit refer script
			// menu_pid

			$this->menu_pid->LinkCustomAttributes = "";
			$this->menu_pid->HrefValue = "";

			// menu_rid
			$this->menu_rid->LinkCustomAttributes = "";
			$this->menu_rid->HrefValue = "";

			// menu_order
			$this->menu_order->LinkCustomAttributes = "";
			$this->menu_order->HrefValue = "";

			// mode_id
			$this->mode_id->LinkCustomAttributes = "";
			$this->mode_id->HrefValue = "";

			// type_id
			$this->type_id->LinkCustomAttributes = "";
			$this->type_id->HrefValue = "";

			// srch_id
			$this->srch_id->LinkCustomAttributes = "";
			$this->srch_id->HrefValue = "";

			// menu_status
			$this->menu_status->LinkCustomAttributes = "";
			$this->menu_status->HrefValue = "";

			// menu_name
			$this->menu_name->LinkCustomAttributes = "";
			$this->menu_name->HrefValue = "";

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

			// page_id
			$this->page_id->LinkCustomAttributes = "";
			$this->page_id->HrefValue = "";

			// menu_href
			$this->menu_href->LinkCustomAttributes = "";
			$this->menu_href->HrefValue = "";
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
		if (!$this->menu_pid->FldIsDetailKey && !is_null($this->menu_pid->FormValue) && $this->menu_pid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_pid->FldCaption(), $this->menu_pid->ReqErrMsg));
		}
		if (!$this->menu_rid->FldIsDetailKey && !is_null($this->menu_rid->FormValue) && $this->menu_rid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_rid->FldCaption(), $this->menu_rid->ReqErrMsg));
		}
		if (!$this->menu_order->FldIsDetailKey && !is_null($this->menu_order->FormValue) && $this->menu_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_order->FldCaption(), $this->menu_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->menu_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->menu_order->FldErrMsg());
		}
		if (!$this->mode_id->FldIsDetailKey && !is_null($this->mode_id->FormValue) && $this->mode_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->mode_id->FldCaption(), $this->mode_id->ReqErrMsg));
		}
		if (!$this->type_id->FldIsDetailKey && !is_null($this->type_id->FormValue) && $this->type_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->type_id->FldCaption(), $this->type_id->ReqErrMsg));
		}
		if (!$this->menu_status->FldIsDetailKey && !is_null($this->menu_status->FormValue) && $this->menu_status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_status->FldCaption(), $this->menu_status->ReqErrMsg));
		}
		if (!$this->menu_name->FldIsDetailKey && !is_null($this->menu_name->FormValue) && $this->menu_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_name->FldCaption(), $this->menu_name->ReqErrMsg));
		}
		if (!$this->page_id->FldIsDetailKey && !is_null($this->page_id->FormValue) && $this->page_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_id->FldCaption(), $this->page_id->ReqErrMsg));
		}
		if (!$this->menu_href->FldIsDetailKey && !is_null($this->menu_href->FormValue) && $this->menu_href->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_href->FldCaption(), $this->menu_href->ReqErrMsg));
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
			$this->menu_icon->OldUploadPath = '../../assets/img/icons/';
			$this->menu_icon->UploadPath = $this->menu_icon->OldUploadPath;
			$rsnew = array();

			// menu_pid
			$this->menu_pid->SetDbValueDef($rsnew, $this->menu_pid->CurrentValue, 0, $this->menu_pid->ReadOnly);

			// menu_rid
			$this->menu_rid->SetDbValueDef($rsnew, $this->menu_rid->CurrentValue, 0, $this->menu_rid->ReadOnly);

			// menu_order
			$this->menu_order->SetDbValueDef($rsnew, $this->menu_order->CurrentValue, 0, $this->menu_order->ReadOnly);

			// mode_id
			$this->mode_id->SetDbValueDef($rsnew, $this->mode_id->CurrentValue, 0, $this->mode_id->ReadOnly);

			// type_id
			$this->type_id->SetDbValueDef($rsnew, $this->type_id->CurrentValue, 0, $this->type_id->ReadOnly);

			// srch_id
			$this->srch_id->SetDbValueDef($rsnew, $this->srch_id->CurrentValue, 0, $this->srch_id->ReadOnly);

			// menu_status
			$this->menu_status->SetDbValueDef($rsnew, $this->menu_status->CurrentValue, 0, $this->menu_status->ReadOnly);

			// menu_name
			$this->menu_name->SetDbValueDef($rsnew, $this->menu_name->CurrentValue, "", $this->menu_name->ReadOnly);

			// menu_icon
			if ($this->menu_icon->Visible && !$this->menu_icon->ReadOnly && !$this->menu_icon->Upload->KeepFile) {
				$this->menu_icon->Upload->DbValue = $rsold['menu_icon']; // Get original value
				if ($this->menu_icon->Upload->FileName == "") {
					$rsnew['menu_icon'] = NULL;
				} else {
					$rsnew['menu_icon'] = $this->menu_icon->Upload->FileName;
				}
			}

			// page_id
			$this->page_id->SetDbValueDef($rsnew, $this->page_id->CurrentValue, 0, $this->page_id->ReadOnly);

			// menu_href
			$this->menu_href->SetDbValueDef($rsnew, $this->menu_href->CurrentValue, "", $this->menu_href->ReadOnly);
			if ($this->menu_icon->Visible && !$this->menu_icon->Upload->KeepFile) {
				$this->menu_icon->UploadPath = '../../assets/img/icons/';
				if (!ew_Empty($this->menu_icon->Upload->Value)) {
					$rsnew['menu_icon'] = ew_UploadFileNameEx($this->menu_icon->PhysicalUploadPath(), $rsnew['menu_icon']); // Get new file name
				}
			}

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
					if ($this->menu_icon->Visible && !$this->menu_icon->Upload->KeepFile) {
						if (!ew_Empty($this->menu_icon->Upload->Value)) {
							if (!$this->menu_icon->Upload->SaveToFile($rsnew['menu_icon'], TRUE)) {
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
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// menu_icon
		ew_CleanUploadTempPath($this->menu_icon, $this->menu_icon->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_menulist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_menu_pid":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `menu_id` AS `LinkFld`, `menu_pname` AS `DispFld`, `menu_name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_vmenu`";
			$sWhereWrk = "";
			$this->menu_pid->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`menu_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->menu_pid, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_menu_rid":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `menu_id` AS `LinkFld`, `menu_pname` AS `DispFld`, `menu_name` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_vmenu`";
			$sWhereWrk = "";
			$this->menu_rid->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`menu_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->menu_rid, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_mode_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `mode_id` AS `LinkFld`, `mode_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_menu_mode`";
			$sWhereWrk = "";
			$this->mode_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`mode_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->mode_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_type_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `type_id` AS `LinkFld`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_menu_type`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`type_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_srch_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `srch_id` AS `LinkFld`, `srch_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_menu_search`";
			$sWhereWrk = "";
			$this->srch_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`srch_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->srch_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($cpy_menu_edit)) $cpy_menu_edit = new ccpy_menu_edit();

// Page init
$cpy_menu_edit->Page_Init();

// Page main
$cpy_menu_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_menu_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcpy_menuedit = new ew_Form("fcpy_menuedit", "edit");

// Validate form
fcpy_menuedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_menu_pid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->menu_pid->FldCaption(), $cpy_menu->menu_pid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_rid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->menu_rid->FldCaption(), $cpy_menu->menu_rid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->menu_order->FldCaption(), $cpy_menu->menu_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_menu->menu_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_mode_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->mode_id->FldCaption(), $cpy_menu->mode_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_type_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->type_id->FldCaption(), $cpy_menu->type_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->menu_status->FldCaption(), $cpy_menu->menu_status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->menu_name->FldCaption(), $cpy_menu->menu_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_page_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->page_id->FldCaption(), $cpy_menu->page_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_href");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_menu->menu_href->FldCaption(), $cpy_menu->menu_href->ReqErrMsg)) ?>");

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
fcpy_menuedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_menuedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_menuedit.Lists["x_menu_pid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_pname","x_menu_name","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_vmenu"};
fcpy_menuedit.Lists["x_menu_pid"].Data = "<?php echo $cpy_menu_edit->menu_pid->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_menuedit.Lists["x_menu_rid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_pname","x_menu_name","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_vmenu"};
fcpy_menuedit.Lists["x_menu_rid"].Data = "<?php echo $cpy_menu_edit->menu_rid->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_menuedit.Lists["x_mode_id"] = {"LinkField":"x_mode_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_mode_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_mode"};
fcpy_menuedit.Lists["x_mode_id"].Data = "<?php echo $cpy_menu_edit->mode_id->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_menuedit.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_type"};
fcpy_menuedit.Lists["x_type_id"].Data = "<?php echo $cpy_menu_edit->type_id->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_menuedit.Lists["x_srch_id"] = {"LinkField":"x_srch_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_srch_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_search"};
fcpy_menuedit.Lists["x_srch_id"].Data = "<?php echo $cpy_menu_edit->srch_id->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_menuedit.Lists["x_menu_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_menuedit.Lists["x_menu_status"].Options = <?php echo json_encode($cpy_menu_edit->menu_status->Options()) ?>;
fcpy_menuedit.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_menuedit.Lists["x_page_id"].Data = "<?php echo $cpy_menu_edit->page_id->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_menu_edit->ShowPageHeader(); ?>
<?php
$cpy_menu_edit->ShowMessage();
?>
<?php if (!$cpy_menu_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_menu_edit->Pager)) $cpy_menu_edit->Pager = new cPrevNextPager($cpy_menu_edit->StartRec, $cpy_menu_edit->DisplayRecs, $cpy_menu_edit->TotalRecs, $cpy_menu_edit->AutoHidePager) ?>
<?php if ($cpy_menu_edit->Pager->RecordCount > 0 && $cpy_menu_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_menu_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_menu_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_menu_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_menu_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_menu_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_menu_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcpy_menuedit" id="fcpy_menuedit" class="<?php echo $cpy_menu_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_menu_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_menu_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_menu">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($cpy_menu_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($cpy_menu->menu_pid->Visible) { // menu_pid ?>
	<div id="r_menu_pid" class="form-group">
		<label id="elh_cpy_menu_menu_pid" for="x_menu_pid" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->menu_pid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->menu_pid->CellAttributes() ?>>
<span id="el_cpy_menu_menu_pid">
<select data-table="cpy_menu" data-field="x_menu_pid" data-value-separator="<?php echo $cpy_menu->menu_pid->DisplayValueSeparatorAttribute() ?>" id="x_menu_pid" name="x_menu_pid"<?php echo $cpy_menu->menu_pid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_pid->SelectOptionListHtml("x_menu_pid") ?>
</select>
</span>
<?php echo $cpy_menu->menu_pid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->menu_rid->Visible) { // menu_rid ?>
	<div id="r_menu_rid" class="form-group">
		<label id="elh_cpy_menu_menu_rid" for="x_menu_rid" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->menu_rid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->menu_rid->CellAttributes() ?>>
<span id="el_cpy_menu_menu_rid">
<select data-table="cpy_menu" data-field="x_menu_rid" data-value-separator="<?php echo $cpy_menu->menu_rid->DisplayValueSeparatorAttribute() ?>" id="x_menu_rid" name="x_menu_rid"<?php echo $cpy_menu->menu_rid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_rid->SelectOptionListHtml("x_menu_rid") ?>
</select>
</span>
<?php echo $cpy_menu->menu_rid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->menu_order->Visible) { // menu_order ?>
	<div id="r_menu_order" class="form-group">
		<label id="elh_cpy_menu_menu_order" for="x_menu_order" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->menu_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->menu_order->CellAttributes() ?>>
<span id="el_cpy_menu_menu_order">
<input type="text" data-table="cpy_menu" data-field="x_menu_order" name="x_menu_order" id="x_menu_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_order->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_order->EditValue ?>"<?php echo $cpy_menu->menu_order->EditAttributes() ?>>
</span>
<?php echo $cpy_menu->menu_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->mode_id->Visible) { // mode_id ?>
	<div id="r_mode_id" class="form-group">
		<label id="elh_cpy_menu_mode_id" for="x_mode_id" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->mode_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->mode_id->CellAttributes() ?>>
<span id="el_cpy_menu_mode_id">
<select data-table="cpy_menu" data-field="x_mode_id" data-value-separator="<?php echo $cpy_menu->mode_id->DisplayValueSeparatorAttribute() ?>" id="x_mode_id" name="x_mode_id"<?php echo $cpy_menu->mode_id->EditAttributes() ?>>
<?php echo $cpy_menu->mode_id->SelectOptionListHtml("x_mode_id") ?>
</select>
</span>
<?php echo $cpy_menu->mode_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->type_id->Visible) { // type_id ?>
	<div id="r_type_id" class="form-group">
		<label id="elh_cpy_menu_type_id" for="x_type_id" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->type_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->type_id->CellAttributes() ?>>
<span id="el_cpy_menu_type_id">
<select data-table="cpy_menu" data-field="x_type_id" data-value-separator="<?php echo $cpy_menu->type_id->DisplayValueSeparatorAttribute() ?>" id="x_type_id" name="x_type_id"<?php echo $cpy_menu->type_id->EditAttributes() ?>>
<?php echo $cpy_menu->type_id->SelectOptionListHtml("x_type_id") ?>
</select>
</span>
<?php echo $cpy_menu->type_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->srch_id->Visible) { // srch_id ?>
	<div id="r_srch_id" class="form-group">
		<label id="elh_cpy_menu_srch_id" for="x_srch_id" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->srch_id->FldCaption() ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->srch_id->CellAttributes() ?>>
<span id="el_cpy_menu_srch_id">
<select data-table="cpy_menu" data-field="x_srch_id" data-value-separator="<?php echo $cpy_menu->srch_id->DisplayValueSeparatorAttribute() ?>" id="x_srch_id" name="x_srch_id"<?php echo $cpy_menu->srch_id->EditAttributes() ?>>
<?php echo $cpy_menu->srch_id->SelectOptionListHtml("x_srch_id") ?>
</select>
</span>
<?php echo $cpy_menu->srch_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->menu_status->Visible) { // menu_status ?>
	<div id="r_menu_status" class="form-group">
		<label id="elh_cpy_menu_menu_status" for="x_menu_status" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->menu_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->menu_status->CellAttributes() ?>>
<span id="el_cpy_menu_menu_status">
<select data-table="cpy_menu" data-field="x_menu_status" data-value-separator="<?php echo $cpy_menu->menu_status->DisplayValueSeparatorAttribute() ?>" id="x_menu_status" name="x_menu_status"<?php echo $cpy_menu->menu_status->EditAttributes() ?>>
<?php echo $cpy_menu->menu_status->SelectOptionListHtml("x_menu_status") ?>
</select>
</span>
<?php echo $cpy_menu->menu_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->menu_name->Visible) { // menu_name ?>
	<div id="r_menu_name" class="form-group">
		<label id="elh_cpy_menu_menu_name" for="x_menu_name" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->menu_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->menu_name->CellAttributes() ?>>
<span id="el_cpy_menu_menu_name">
<input type="text" data-table="cpy_menu" data-field="x_menu_name" name="x_menu_name" id="x_menu_name" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_name->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_name->EditValue ?>"<?php echo $cpy_menu->menu_name->EditAttributes() ?>>
</span>
<?php echo $cpy_menu->menu_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->menu_icon->Visible) { // menu_icon ?>
	<div id="r_menu_icon" class="form-group">
		<label id="elh_cpy_menu_menu_icon" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->menu_icon->FldCaption() ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->menu_icon->CellAttributes() ?>>
<span id="el_cpy_menu_menu_icon">
<div id="fd_x_menu_icon">
<span title="<?php echo $cpy_menu->menu_icon->FldTitle() ? $cpy_menu->menu_icon->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_menu->menu_icon->ReadOnly || $cpy_menu->menu_icon->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_menu" data-field="x_menu_icon" name="x_menu_icon" id="x_menu_icon"<?php echo $cpy_menu->menu_icon->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_menu_icon" id= "fn_x_menu_icon" value="<?php echo $cpy_menu->menu_icon->Upload->FileName ?>">
<?php if (@$_POST["fa_x_menu_icon"] == "0") { ?>
<input type="hidden" name="fa_x_menu_icon" id= "fa_x_menu_icon" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_menu_icon" id= "fa_x_menu_icon" value="1">
<?php } ?>
<input type="hidden" name="fs_x_menu_icon" id= "fs_x_menu_icon" value="50">
<input type="hidden" name="fx_x_menu_icon" id= "fx_x_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_menu_icon" id= "fm_x_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadMaxFileSize ?>">
</div>
<table id="ft_x_menu_icon" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_menu->menu_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->page_id->Visible) { // page_id ?>
	<div id="r_page_id" class="form-group">
		<label id="elh_cpy_menu_page_id" for="x_page_id" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->page_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->page_id->CellAttributes() ?>>
<span id="el_cpy_menu_page_id">
<select data-table="cpy_menu" data-field="x_page_id" data-value-separator="<?php echo $cpy_menu->page_id->DisplayValueSeparatorAttribute() ?>" id="x_page_id" name="x_page_id"<?php echo $cpy_menu->page_id->EditAttributes() ?>>
<?php echo $cpy_menu->page_id->SelectOptionListHtml("x_page_id") ?>
</select>
</span>
<?php echo $cpy_menu->page_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_menu->menu_href->Visible) { // menu_href ?>
	<div id="r_menu_href" class="form-group">
		<label id="elh_cpy_menu_menu_href" for="x_menu_href" class="<?php echo $cpy_menu_edit->LeftColumnClass ?>"><?php echo $cpy_menu->menu_href->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_menu_edit->RightColumnClass ?>"><div<?php echo $cpy_menu->menu_href->CellAttributes() ?>>
<span id="el_cpy_menu_menu_href">
<input type="text" data-table="cpy_menu" data-field="x_menu_href" name="x_menu_href" id="x_menu_href" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_href->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_href->EditValue ?>"<?php echo $cpy_menu->menu_href->EditAttributes() ?>>
</span>
<?php echo $cpy_menu->menu_href->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="cpy_menu" data-field="x_menu_id" name="x_menu_id" id="x_menu_id" value="<?php echo ew_HtmlEncode($cpy_menu->menu_id->CurrentValue) ?>">
<?php if (!$cpy_menu_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_menu_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_menu_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$cpy_menu_edit->IsModal) { ?>
<?php if (!isset($cpy_menu_edit->Pager)) $cpy_menu_edit->Pager = new cPrevNextPager($cpy_menu_edit->StartRec, $cpy_menu_edit->DisplayRecs, $cpy_menu_edit->TotalRecs, $cpy_menu_edit->AutoHidePager) ?>
<?php if ($cpy_menu_edit->Pager->RecordCount > 0 && $cpy_menu_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_menu_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_menu_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_menu_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_menu_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_menu_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_menu_edit->PageUrl() ?>start=<?php echo $cpy_menu_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_menu_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fcpy_menuedit.Init();
</script>
<?php
$cpy_menu_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_menu_edit->Page_Terminate();
?>
