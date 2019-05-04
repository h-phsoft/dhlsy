<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_newsinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "cpy_news_imagesgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_news_edit = NULL; // Initialize page object first

class ccpy_news_edit extends ccpy_news {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_news';

	// Page object name
	var $PageObjName = 'cpy_news_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_newslist.php"));
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
		$this->news_status->SetVisibility();
		$this->type_id->SetVisibility();
		$this->news_date->SetVisibility();
		$this->news_title->SetVisibility();
		$this->news_stext->SetVisibility();
		$this->news_image->SetVisibility();
		$this->news_text->SetVisibility();

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

			// Process auto fill for detail table 'cpy_news_images'
			if (@$_POST["grid"] == "fcpy_news_imagesgrid") {
				if (!isset($GLOBALS["cpy_news_images_grid"])) $GLOBALS["cpy_news_images_grid"] = new ccpy_news_images_grid;
				$GLOBALS["cpy_news_images_grid"]->Page_Init();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "cpy_newsview.php")
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
			if ($objForm->HasValue("x_news_id")) {
				$this->news_id->setFormValue($objForm->GetValue("x_news_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["news_id"])) {
				$this->news_id->setQueryStringValue($_GET["news_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->news_id->CurrentValue = NULL;
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
			$this->Page_Terminate("cpy_newslist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->news_id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->news_id->CurrentValue) == strval($this->Recordset->fields('news_id'))) {
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

			// Set up detail parameters
			$this->SetupDetailParms();
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
					$this->Page_Terminate("cpy_newslist.php"); // Return to list page
				} else {
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "cpy_newslist.php")
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

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->news_image->Upload->Index = $objForm->Index;
		$this->news_image->Upload->UploadFile();
		$this->news_image->CurrentValue = $this->news_image->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->news_status->FldIsDetailKey) {
			$this->news_status->setFormValue($objForm->GetValue("x_news_status"));
		}
		if (!$this->type_id->FldIsDetailKey) {
			$this->type_id->setFormValue($objForm->GetValue("x_type_id"));
		}
		if (!$this->news_date->FldIsDetailKey) {
			$this->news_date->setFormValue($objForm->GetValue("x_news_date"));
			$this->news_date->CurrentValue = ew_UnFormatDateTime($this->news_date->CurrentValue, 5);
		}
		if (!$this->news_title->FldIsDetailKey) {
			$this->news_title->setFormValue($objForm->GetValue("x_news_title"));
		}
		if (!$this->news_stext->FldIsDetailKey) {
			$this->news_stext->setFormValue($objForm->GetValue("x_news_stext"));
		}
		if (!$this->news_text->FldIsDetailKey) {
			$this->news_text->setFormValue($objForm->GetValue("x_news_text"));
		}
		if (!$this->news_id->FldIsDetailKey)
			$this->news_id->setFormValue($objForm->GetValue("x_news_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->news_id->CurrentValue = $this->news_id->FormValue;
		$this->news_status->CurrentValue = $this->news_status->FormValue;
		$this->type_id->CurrentValue = $this->type_id->FormValue;
		$this->news_date->CurrentValue = $this->news_date->FormValue;
		$this->news_date->CurrentValue = ew_UnFormatDateTime($this->news_date->CurrentValue, 5);
		$this->news_title->CurrentValue = $this->news_title->FormValue;
		$this->news_stext->CurrentValue = $this->news_stext->FormValue;
		$this->news_text->CurrentValue = $this->news_text->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("news_id")) <> "")
			$this->news_id->CurrentValue = $this->getKey("news_id"); // news_id
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
		// news_id
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

		// news_text
		$this->news_text->ViewValue = $this->news_text->CurrentValue;
		$this->news_text->ViewCustomAttributes = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// news_status
			$this->news_status->EditAttrs["class"] = "form-control";
			$this->news_status->EditCustomAttributes = "";
			$this->news_status->EditValue = $this->news_status->Options(TRUE);

			// type_id
			$this->type_id->EditAttrs["class"] = "form-control";
			$this->type_id->EditCustomAttributes = "";
			if (trim(strval($this->type_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_news_type`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->type_id->EditValue = $arwrk;

			// news_date
			$this->news_date->EditAttrs["class"] = "form-control";
			$this->news_date->EditCustomAttributes = "";
			$this->news_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->news_date->CurrentValue, 5));
			$this->news_date->PlaceHolder = ew_RemoveHtml($this->news_date->FldCaption());

			// news_title
			$this->news_title->EditAttrs["class"] = "form-control";
			$this->news_title->EditCustomAttributes = "";
			$this->news_title->EditValue = ew_HtmlEncode($this->news_title->CurrentValue);
			$this->news_title->PlaceHolder = ew_RemoveHtml($this->news_title->FldCaption());

			// news_stext
			$this->news_stext->EditAttrs["class"] = "form-control";
			$this->news_stext->EditCustomAttributes = "";
			$this->news_stext->EditValue = ew_HtmlEncode($this->news_stext->CurrentValue);
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
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->news_image);

			// news_text
			$this->news_text->EditAttrs["class"] = "form-control";
			$this->news_text->EditCustomAttributes = "";
			$this->news_text->EditValue = ew_HtmlEncode($this->news_text->CurrentValue);
			$this->news_text->PlaceHolder = ew_RemoveHtml($this->news_text->FldCaption());

			// Edit refer script
			// news_status

			$this->news_status->LinkCustomAttributes = "";
			$this->news_status->HrefValue = "";

			// type_id
			$this->type_id->LinkCustomAttributes = "";
			$this->type_id->HrefValue = "";

			// news_date
			$this->news_date->LinkCustomAttributes = "";
			$this->news_date->HrefValue = "";

			// news_title
			$this->news_title->LinkCustomAttributes = "";
			$this->news_title->HrefValue = "";

			// news_stext
			$this->news_stext->LinkCustomAttributes = "";
			$this->news_stext->HrefValue = "";

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

			// news_text
			$this->news_text->LinkCustomAttributes = "";
			$this->news_text->HrefValue = "";
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
		if (!$this->type_id->FldIsDetailKey && !is_null($this->type_id->FormValue) && $this->type_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->type_id->FldCaption(), $this->type_id->ReqErrMsg));
		}
		if (!$this->news_date->FldIsDetailKey && !is_null($this->news_date->FormValue) && $this->news_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->news_date->FldCaption(), $this->news_date->ReqErrMsg));
		}
		if (!ew_CheckDate($this->news_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->news_date->FldErrMsg());
		}
		if (!$this->news_title->FldIsDetailKey && !is_null($this->news_title->FormValue) && $this->news_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->news_title->FldCaption(), $this->news_title->ReqErrMsg));
		}
		if ($this->news_image->Upload->FileName == "" && !$this->news_image->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->news_image->FldCaption(), $this->news_image->ReqErrMsg));
		}
		if (!$this->news_text->FldIsDetailKey && !is_null($this->news_text->FormValue) && $this->news_text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->news_text->FldCaption(), $this->news_text->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cpy_news_images", $DetailTblVar) && $GLOBALS["cpy_news_images"]->DetailEdit) {
			if (!isset($GLOBALS["cpy_news_images_grid"])) $GLOBALS["cpy_news_images_grid"] = new ccpy_news_images_grid(); // get detail page object
			$GLOBALS["cpy_news_images_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->news_image->OldUploadPath = '../../assets/img/newsImages/';
			$this->news_image->UploadPath = $this->news_image->OldUploadPath;
			$rsnew = array();

			// news_status
			$this->news_status->SetDbValueDef($rsnew, $this->news_status->CurrentValue, 0, $this->news_status->ReadOnly);

			// type_id
			$this->type_id->SetDbValueDef($rsnew, $this->type_id->CurrentValue, 0, $this->type_id->ReadOnly);

			// news_date
			$this->news_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->news_date->CurrentValue, 5), ew_CurrentDate(), $this->news_date->ReadOnly);

			// news_title
			$this->news_title->SetDbValueDef($rsnew, $this->news_title->CurrentValue, "", $this->news_title->ReadOnly);

			// news_stext
			$this->news_stext->SetDbValueDef($rsnew, $this->news_stext->CurrentValue, NULL, $this->news_stext->ReadOnly);

			// news_image
			if ($this->news_image->Visible && !$this->news_image->ReadOnly && !$this->news_image->Upload->KeepFile) {
				$this->news_image->Upload->DbValue = $rsold['news_image']; // Get original value
				if ($this->news_image->Upload->FileName == "") {
					$rsnew['news_image'] = NULL;
				} else {
					$rsnew['news_image'] = $this->news_image->Upload->FileName;
				}
			}

			// news_text
			$this->news_text->SetDbValueDef($rsnew, $this->news_text->CurrentValue, "", $this->news_text->ReadOnly);
			if ($this->news_image->Visible && !$this->news_image->Upload->KeepFile) {
				$this->news_image->UploadPath = '../../assets/img/newsImages/';
				if (!ew_Empty($this->news_image->Upload->Value)) {
					$rsnew['news_image'] = ew_UploadFileNameEx($this->news_image->PhysicalUploadPath(), $rsnew['news_image']); // Get new file name
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
					if ($this->news_image->Visible && !$this->news_image->Upload->KeepFile) {
						if (!ew_Empty($this->news_image->Upload->Value)) {
							if (!$this->news_image->Upload->SaveToFile($rsnew['news_image'], TRUE)) {
								$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
								return FALSE;
							}
						}
					}
				}

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("cpy_news_images", $DetailTblVar) && $GLOBALS["cpy_news_images"]->DetailEdit) {
						if (!isset($GLOBALS["cpy_news_images_grid"])) $GLOBALS["cpy_news_images_grid"] = new ccpy_news_images_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_news_images"); // Load user level of detail table
						$EditRow = $GLOBALS["cpy_news_images_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
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

		// news_image
		ew_CleanUploadTempPath($this->news_image, $this->news_image->Upload->Index);
		return $EditRow;
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
			if (in_array("cpy_news_images", $DetailTblVar)) {
				if (!isset($GLOBALS["cpy_news_images_grid"]))
					$GLOBALS["cpy_news_images_grid"] = new ccpy_news_images_grid;
				if ($GLOBALS["cpy_news_images_grid"]->DetailEdit) {
					$GLOBALS["cpy_news_images_grid"]->CurrentMode = "edit";
					$GLOBALS["cpy_news_images_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["cpy_news_images_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cpy_news_images_grid"]->setStartRecordNumber(1);
					$GLOBALS["cpy_news_images_grid"]->news_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_news_images_grid"]->news_id->CurrentValue = $this->news_id->CurrentValue;
					$GLOBALS["cpy_news_images_grid"]->news_id->setSessionValue($GLOBALS["cpy_news_images_grid"]->news_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_newslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_type_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `type_id` AS `LinkFld`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_news_type`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`type_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($cpy_news_edit)) $cpy_news_edit = new ccpy_news_edit();

// Page init
$cpy_news_edit->Page_Init();

// Page main
$cpy_news_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_news_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcpy_newsedit = new ew_Form("fcpy_newsedit", "edit");

// Validate form
fcpy_newsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_type_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_news->type_id->FldCaption(), $cpy_news->type_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_news_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_news->news_date->FldCaption(), $cpy_news->news_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_news_date");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_news->news_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_news_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_news->news_title->FldCaption(), $cpy_news->news_title->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_news_image");
			elm = this.GetElements("fn_x" + infix + "_news_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_news->news_image->FldCaption(), $cpy_news->news_image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_news_text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_news->news_text->FldCaption(), $cpy_news->news_text->ReqErrMsg)) ?>");

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
fcpy_newsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_newsedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_newsedit.Lists["x_news_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_newsedit.Lists["x_news_status"].Options = <?php echo json_encode($cpy_news_edit->news_status->Options()) ?>;
fcpy_newsedit.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_news_type"};
fcpy_newsedit.Lists["x_type_id"].Data = "<?php echo $cpy_news_edit->type_id->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_news_edit->ShowPageHeader(); ?>
<?php
$cpy_news_edit->ShowMessage();
?>
<?php if (!$cpy_news_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_news_edit->Pager)) $cpy_news_edit->Pager = new cPrevNextPager($cpy_news_edit->StartRec, $cpy_news_edit->DisplayRecs, $cpy_news_edit->TotalRecs, $cpy_news_edit->AutoHidePager) ?>
<?php if ($cpy_news_edit->Pager->RecordCount > 0 && $cpy_news_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_news_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_news_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_news_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_news_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_news_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_news_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcpy_newsedit" id="fcpy_newsedit" class="<?php echo $cpy_news_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_news_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_news_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_news">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($cpy_news_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($cpy_news->news_status->Visible) { // news_status ?>
	<div id="r_news_status" class="form-group">
		<label id="elh_cpy_news_news_status" for="x_news_status" class="<?php echo $cpy_news_edit->LeftColumnClass ?>"><?php echo $cpy_news->news_status->FldCaption() ?></label>
		<div class="<?php echo $cpy_news_edit->RightColumnClass ?>"><div<?php echo $cpy_news->news_status->CellAttributes() ?>>
<span id="el_cpy_news_news_status">
<select data-table="cpy_news" data-field="x_news_status" data-value-separator="<?php echo $cpy_news->news_status->DisplayValueSeparatorAttribute() ?>" id="x_news_status" name="x_news_status"<?php echo $cpy_news->news_status->EditAttributes() ?>>
<?php echo $cpy_news->news_status->SelectOptionListHtml("x_news_status") ?>
</select>
</span>
<?php echo $cpy_news->news_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->type_id->Visible) { // type_id ?>
	<div id="r_type_id" class="form-group">
		<label id="elh_cpy_news_type_id" for="x_type_id" class="<?php echo $cpy_news_edit->LeftColumnClass ?>"><?php echo $cpy_news->type_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_news_edit->RightColumnClass ?>"><div<?php echo $cpy_news->type_id->CellAttributes() ?>>
<span id="el_cpy_news_type_id">
<select data-table="cpy_news" data-field="x_type_id" data-value-separator="<?php echo $cpy_news->type_id->DisplayValueSeparatorAttribute() ?>" id="x_type_id" name="x_type_id"<?php echo $cpy_news->type_id->EditAttributes() ?>>
<?php echo $cpy_news->type_id->SelectOptionListHtml("x_type_id") ?>
</select>
</span>
<?php echo $cpy_news->type_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_date->Visible) { // news_date ?>
	<div id="r_news_date" class="form-group">
		<label id="elh_cpy_news_news_date" for="x_news_date" class="<?php echo $cpy_news_edit->LeftColumnClass ?>"><?php echo $cpy_news->news_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_news_edit->RightColumnClass ?>"><div<?php echo $cpy_news->news_date->CellAttributes() ?>>
<span id="el_cpy_news_news_date">
<input type="text" data-table="cpy_news" data-field="x_news_date" data-format="5" name="x_news_date" id="x_news_date" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_date->getPlaceHolder()) ?>" value="<?php echo $cpy_news->news_date->EditValue ?>"<?php echo $cpy_news->news_date->EditAttributes() ?>>
<?php if (!$cpy_news->news_date->ReadOnly && !$cpy_news->news_date->Disabled && !isset($cpy_news->news_date->EditAttrs["readonly"]) && !isset($cpy_news->news_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_newsedit", "x_news_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
</script>
<?php } ?>
</span>
<?php echo $cpy_news->news_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_title->Visible) { // news_title ?>
	<div id="r_news_title" class="form-group">
		<label id="elh_cpy_news_news_title" for="x_news_title" class="<?php echo $cpy_news_edit->LeftColumnClass ?>"><?php echo $cpy_news->news_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_news_edit->RightColumnClass ?>"><div<?php echo $cpy_news->news_title->CellAttributes() ?>>
<span id="el_cpy_news_news_title">
<input type="text" data-table="cpy_news" data-field="x_news_title" name="x_news_title" id="x_news_title" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_title->getPlaceHolder()) ?>" value="<?php echo $cpy_news->news_title->EditValue ?>"<?php echo $cpy_news->news_title->EditAttributes() ?>>
</span>
<?php echo $cpy_news->news_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_stext->Visible) { // news_stext ?>
	<div id="r_news_stext" class="form-group">
		<label id="elh_cpy_news_news_stext" for="x_news_stext" class="<?php echo $cpy_news_edit->LeftColumnClass ?>"><?php echo $cpy_news->news_stext->FldCaption() ?></label>
		<div class="<?php echo $cpy_news_edit->RightColumnClass ?>"><div<?php echo $cpy_news->news_stext->CellAttributes() ?>>
<span id="el_cpy_news_news_stext">
<textarea data-table="cpy_news" data-field="x_news_stext" name="x_news_stext" id="x_news_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_stext->getPlaceHolder()) ?>"<?php echo $cpy_news->news_stext->EditAttributes() ?>><?php echo $cpy_news->news_stext->EditValue ?></textarea>
</span>
<?php echo $cpy_news->news_stext->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_image->Visible) { // news_image ?>
	<div id="r_news_image" class="form-group">
		<label id="elh_cpy_news_news_image" class="<?php echo $cpy_news_edit->LeftColumnClass ?>"><?php echo $cpy_news->news_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_news_edit->RightColumnClass ?>"><div<?php echo $cpy_news->news_image->CellAttributes() ?>>
<span id="el_cpy_news_news_image">
<div id="fd_x_news_image">
<span title="<?php echo $cpy_news->news_image->FldTitle() ? $cpy_news->news_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_news->news_image->ReadOnly || $cpy_news->news_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_news" data-field="x_news_image" name="x_news_image" id="x_news_image"<?php echo $cpy_news->news_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_news_image" id= "fn_x_news_image" value="<?php echo $cpy_news->news_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x_news_image"] == "0") { ?>
<input type="hidden" name="fa_x_news_image" id= "fa_x_news_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_news_image" id= "fa_x_news_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x_news_image" id= "fs_x_news_image" value="200">
<input type="hidden" name="fx_x_news_image" id= "fx_x_news_image" value="<?php echo $cpy_news->news_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_news_image" id= "fm_x_news_image" value="<?php echo $cpy_news->news_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_news_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_news->news_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_text->Visible) { // news_text ?>
	<div id="r_news_text" class="form-group">
		<label id="elh_cpy_news_news_text" class="<?php echo $cpy_news_edit->LeftColumnClass ?>"><?php echo $cpy_news->news_text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_news_edit->RightColumnClass ?>"><div<?php echo $cpy_news->news_text->CellAttributes() ?>>
<span id="el_cpy_news_news_text">
<?php ew_AppendClass($cpy_news->news_text->EditAttrs["class"], "editor"); ?>
<textarea data-table="cpy_news" data-field="x_news_text" name="x_news_text" id="x_news_text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_text->getPlaceHolder()) ?>"<?php echo $cpy_news->news_text->EditAttributes() ?>><?php echo $cpy_news->news_text->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fcpy_newsedit", "x_news_text", 35, 4, <?php echo ($cpy_news->news_text->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $cpy_news->news_text->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="cpy_news" data-field="x_news_id" name="x_news_id" id="x_news_id" value="<?php echo ew_HtmlEncode($cpy_news->news_id->CurrentValue) ?>">
<?php
	if (in_array("cpy_news_images", explode(",", $cpy_news->getCurrentDetailTable())) && $cpy_news_images->DetailEdit) {
?>
<?php if ($cpy_news->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_news_images", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_news_imagesgrid.php" ?>
<?php } ?>
<?php if (!$cpy_news_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_news_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_news_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$cpy_news_edit->IsModal) { ?>
<?php if (!isset($cpy_news_edit->Pager)) $cpy_news_edit->Pager = new cPrevNextPager($cpy_news_edit->StartRec, $cpy_news_edit->DisplayRecs, $cpy_news_edit->TotalRecs, $cpy_news_edit->AutoHidePager) ?>
<?php if ($cpy_news_edit->Pager->RecordCount > 0 && $cpy_news_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_news_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_news_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_news_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_news_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_news_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_news_edit->PageUrl() ?>start=<?php echo $cpy_news_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_news_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fcpy_newsedit.Init();
</script>
<?php
$cpy_news_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_news_edit->Page_Terminate();
?>
