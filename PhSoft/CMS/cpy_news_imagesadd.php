<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_news_imagesinfo.php" ?>
<?php include_once "cpy_newsinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_news_images_add = NULL; // Initialize page object first

class ccpy_news_images_add extends ccpy_news_images {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_news_images';

	// Page object name
	var $PageObjName = 'cpy_news_images_add';

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

		// Table object (cpy_news_images)
		if (!isset($GLOBALS["cpy_news_images"]) || get_class($GLOBALS["cpy_news_images"]) == "ccpy_news_images") {
			$GLOBALS["cpy_news_images"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_news_images"];
		}

		// Table object (cpy_news)
		if (!isset($GLOBALS['cpy_news'])) $GLOBALS['cpy_news'] = new ccpy_news();

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_news_images', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_news_imageslist.php"));
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
		$this->news_id->SetVisibility();
		$this->nimg_order->SetVisibility();
		$this->nimg_photo->SetVisibility();

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
		global $EW_EXPORT, $cpy_news_images;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_news_images);
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
					if ($pageName == "cpy_news_imagesview.php")
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
			if (@$_GET["nimg_id"] != "") {
				$this->nimg_id->setQueryStringValue($_GET["nimg_id"]);
				$this->setKey("nimg_id", $this->nimg_id->CurrentValue); // Set up key
			} else {
				$this->setKey("nimg_id", ""); // Clear key
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
					$this->Page_Terminate("cpy_news_imageslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_news_imageslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_news_imagesview.php")
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
		$this->nimg_photo->Upload->Index = $objForm->Index;
		$this->nimg_photo->Upload->UploadFile();
		$this->nimg_photo->CurrentValue = $this->nimg_photo->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->nimg_id->CurrentValue = NULL;
		$this->nimg_id->OldValue = $this->nimg_id->CurrentValue;
		$this->news_id->CurrentValue = NULL;
		$this->news_id->OldValue = $this->news_id->CurrentValue;
		$this->nimg_order->CurrentValue = 0;
		$this->nimg_photo->Upload->DbValue = NULL;
		$this->nimg_photo->OldValue = $this->nimg_photo->Upload->DbValue;
		$this->nimg_photo->CurrentValue = NULL; // Clear file related field
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->news_id->FldIsDetailKey) {
			$this->news_id->setFormValue($objForm->GetValue("x_news_id"));
		}
		if (!$this->nimg_order->FldIsDetailKey) {
			$this->nimg_order->setFormValue($objForm->GetValue("x_nimg_order"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->news_id->CurrentValue = $this->news_id->FormValue;
		$this->nimg_order->CurrentValue = $this->nimg_order->FormValue;
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
		$this->nimg_id->setDbValue($row['nimg_id']);
		$this->news_id->setDbValue($row['news_id']);
		$this->nimg_order->setDbValue($row['nimg_order']);
		$this->nimg_photo->Upload->DbValue = $row['nimg_photo'];
		$this->nimg_photo->CurrentValue = $this->nimg_photo->Upload->DbValue;
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['nimg_id'] = $this->nimg_id->CurrentValue;
		$row['news_id'] = $this->news_id->CurrentValue;
		$row['nimg_order'] = $this->nimg_order->CurrentValue;
		$row['nimg_photo'] = $this->nimg_photo->Upload->DbValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->nimg_id->DbValue = $row['nimg_id'];
		$this->news_id->DbValue = $row['news_id'];
		$this->nimg_order->DbValue = $row['nimg_order'];
		$this->nimg_photo->Upload->DbValue = $row['nimg_photo'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("nimg_id")) <> "")
			$this->nimg_id->CurrentValue = $this->getKey("nimg_id"); // nimg_id
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
		// nimg_id
		// news_id
		// nimg_order
		// nimg_photo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// news_id
		if (strval($this->news_id->CurrentValue) <> "") {
			$sFilterWrk = "`news_id`" . ew_SearchString("=", $this->news_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `news_id`, `news_title` AS `DispFld`, `news_date` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_news`";
		$sWhereWrk = "";
		$this->news_id->LookupFilters = array("df2" => "5");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->news_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = ew_FormatDateTime($rswrk->fields('Disp2Fld'), 5);
				$this->news_id->ViewValue = $this->news_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->news_id->ViewValue = $this->news_id->CurrentValue;
			}
		} else {
			$this->news_id->ViewValue = NULL;
		}
		$this->news_id->ViewCustomAttributes = "";

		// nimg_order
		$this->nimg_order->ViewValue = $this->nimg_order->CurrentValue;
		$this->nimg_order->ViewCustomAttributes = "";

		// nimg_photo
		$this->nimg_photo->UploadPath = '../../assets/img/newsImages/';
		if (!ew_Empty($this->nimg_photo->Upload->DbValue)) {
			$this->nimg_photo->ImageWidth = 200;
			$this->nimg_photo->ImageHeight = 0;
			$this->nimg_photo->ImageAlt = $this->nimg_photo->FldAlt();
			$this->nimg_photo->ViewValue = $this->nimg_photo->Upload->DbValue;
		} else {
			$this->nimg_photo->ViewValue = "";
		}
		$this->nimg_photo->ViewCustomAttributes = "";

			// news_id
			$this->news_id->LinkCustomAttributes = "";
			$this->news_id->HrefValue = "";
			$this->news_id->TooltipValue = "";

			// nimg_order
			$this->nimg_order->LinkCustomAttributes = "";
			$this->nimg_order->HrefValue = "";
			$this->nimg_order->TooltipValue = "";

			// nimg_photo
			$this->nimg_photo->LinkCustomAttributes = "";
			$this->nimg_photo->UploadPath = '../../assets/img/newsImages/';
			if (!ew_Empty($this->nimg_photo->Upload->DbValue)) {
				$this->nimg_photo->HrefValue = ew_GetFileUploadUrl($this->nimg_photo, $this->nimg_photo->Upload->DbValue); // Add prefix/suffix
				$this->nimg_photo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->nimg_photo->HrefValue = ew_FullUrl($this->nimg_photo->HrefValue, "href");
			} else {
				$this->nimg_photo->HrefValue = "";
			}
			$this->nimg_photo->HrefValue2 = $this->nimg_photo->UploadPath . $this->nimg_photo->Upload->DbValue;
			$this->nimg_photo->TooltipValue = "";
			if ($this->nimg_photo->UseColorbox) {
				if (ew_Empty($this->nimg_photo->TooltipValue))
					$this->nimg_photo->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->nimg_photo->LinkAttrs["data-rel"] = "cpy_news_images_x_nimg_photo";
				ew_AppendClass($this->nimg_photo->LinkAttrs["class"], "ewLightbox");
			}
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// news_id
			$this->news_id->EditAttrs["class"] = "form-control";
			$this->news_id->EditCustomAttributes = "";
			if ($this->news_id->getSessionValue() <> "") {
				$this->news_id->CurrentValue = $this->news_id->getSessionValue();
			if (strval($this->news_id->CurrentValue) <> "") {
				$sFilterWrk = "`news_id`" . ew_SearchString("=", $this->news_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `news_id`, `news_title` AS `DispFld`, `news_date` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_news`";
			$sWhereWrk = "";
			$this->news_id->LookupFilters = array("df2" => "5");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->news_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$arwrk[2] = ew_FormatDateTime($rswrk->fields('Disp2Fld'), 5);
					$this->news_id->ViewValue = $this->news_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->news_id->ViewValue = $this->news_id->CurrentValue;
				}
			} else {
				$this->news_id->ViewValue = NULL;
			}
			$this->news_id->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->news_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`news_id`" . ew_SearchString("=", $this->news_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `news_id`, `news_title` AS `DispFld`, `news_date` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_news`";
			$sWhereWrk = "";
			$this->news_id->LookupFilters = array("df2" => "5");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->news_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][2] = ew_FormatDateTime($arwrk[$rowcntwrk][2], 5);
			}
			$this->news_id->EditValue = $arwrk;
			}

			// nimg_order
			$this->nimg_order->EditAttrs["class"] = "form-control";
			$this->nimg_order->EditCustomAttributes = "";
			$this->nimg_order->EditValue = ew_HtmlEncode($this->nimg_order->CurrentValue);
			$this->nimg_order->PlaceHolder = ew_RemoveHtml($this->nimg_order->FldCaption());

			// nimg_photo
			$this->nimg_photo->EditAttrs["class"] = "form-control";
			$this->nimg_photo->EditCustomAttributes = "";
			$this->nimg_photo->UploadPath = '../../assets/img/newsImages/';
			if (!ew_Empty($this->nimg_photo->Upload->DbValue)) {
				$this->nimg_photo->ImageWidth = 200;
				$this->nimg_photo->ImageHeight = 0;
				$this->nimg_photo->ImageAlt = $this->nimg_photo->FldAlt();
				$this->nimg_photo->EditValue = $this->nimg_photo->Upload->DbValue;
			} else {
				$this->nimg_photo->EditValue = "";
			}
			if (!ew_Empty($this->nimg_photo->CurrentValue))
				$this->nimg_photo->Upload->FileName = $this->nimg_photo->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->nimg_photo);

			// Add refer script
			// news_id

			$this->news_id->LinkCustomAttributes = "";
			$this->news_id->HrefValue = "";

			// nimg_order
			$this->nimg_order->LinkCustomAttributes = "";
			$this->nimg_order->HrefValue = "";

			// nimg_photo
			$this->nimg_photo->LinkCustomAttributes = "";
			$this->nimg_photo->UploadPath = '../../assets/img/newsImages/';
			if (!ew_Empty($this->nimg_photo->Upload->DbValue)) {
				$this->nimg_photo->HrefValue = ew_GetFileUploadUrl($this->nimg_photo, $this->nimg_photo->Upload->DbValue); // Add prefix/suffix
				$this->nimg_photo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->nimg_photo->HrefValue = ew_FullUrl($this->nimg_photo->HrefValue, "href");
			} else {
				$this->nimg_photo->HrefValue = "";
			}
			$this->nimg_photo->HrefValue2 = $this->nimg_photo->UploadPath . $this->nimg_photo->Upload->DbValue;
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
		if (!$this->news_id->FldIsDetailKey && !is_null($this->news_id->FormValue) && $this->news_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->news_id->FldCaption(), $this->news_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nimg_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->nimg_order->FldErrMsg());
		}
		if ($this->nimg_photo->Upload->FileName == "" && !$this->nimg_photo->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nimg_photo->FldCaption(), $this->nimg_photo->ReqErrMsg));
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
			$this->nimg_photo->OldUploadPath = '../../assets/img/newsImages/';
			$this->nimg_photo->UploadPath = $this->nimg_photo->OldUploadPath;
		}
		$rsnew = array();

		// news_id
		$this->news_id->SetDbValueDef($rsnew, $this->news_id->CurrentValue, 0, FALSE);

		// nimg_order
		$this->nimg_order->SetDbValueDef($rsnew, $this->nimg_order->CurrentValue, 0, strval($this->nimg_order->CurrentValue) == "");

		// nimg_photo
		if ($this->nimg_photo->Visible && !$this->nimg_photo->Upload->KeepFile) {
			$this->nimg_photo->Upload->DbValue = ""; // No need to delete old file
			if ($this->nimg_photo->Upload->FileName == "") {
				$rsnew['nimg_photo'] = NULL;
			} else {
				$rsnew['nimg_photo'] = $this->nimg_photo->Upload->FileName;
			}
		}
		if ($this->nimg_photo->Visible && !$this->nimg_photo->Upload->KeepFile) {
			$this->nimg_photo->UploadPath = '../../assets/img/newsImages/';
			if (!ew_Empty($this->nimg_photo->Upload->Value)) {
				$rsnew['nimg_photo'] = ew_UploadFileNameEx($this->nimg_photo->PhysicalUploadPath(), $rsnew['nimg_photo']); // Get new file name
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
				if ($this->nimg_photo->Visible && !$this->nimg_photo->Upload->KeepFile) {
					if (!ew_Empty($this->nimg_photo->Upload->Value)) {
						if (!$this->nimg_photo->Upload->SaveToFile($rsnew['nimg_photo'], TRUE)) {
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

		// nimg_photo
		ew_CleanUploadTempPath($this->nimg_photo, $this->nimg_photo->Upload->Index);
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
			if ($sMasterTblVar == "cpy_news") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_news_id"] <> "") {
					$GLOBALS["cpy_news"]->news_id->setQueryStringValue($_GET["fk_news_id"]);
					$this->news_id->setQueryStringValue($GLOBALS["cpy_news"]->news_id->QueryStringValue);
					$this->news_id->setSessionValue($this->news_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cpy_news"]->news_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "cpy_news") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_news_id"] <> "") {
					$GLOBALS["cpy_news"]->news_id->setFormValue($_POST["fk_news_id"]);
					$this->news_id->setFormValue($GLOBALS["cpy_news"]->news_id->FormValue);
					$this->news_id->setSessionValue($this->news_id->FormValue);
					if (!is_numeric($GLOBALS["cpy_news"]->news_id->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cpy_news") {
				if ($this->news_id->CurrentValue == "") $this->news_id->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_news_imageslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_news_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `news_id` AS `LinkFld`, `news_title` AS `DispFld`, `news_date` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_news`";
			$sWhereWrk = "";
			$this->news_id->LookupFilters = array("df2" => "5");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`news_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->news_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($cpy_news_images_add)) $cpy_news_images_add = new ccpy_news_images_add();

// Page init
$cpy_news_images_add->Page_Init();

// Page main
$cpy_news_images_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_news_images_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_news_imagesadd = new ew_Form("fcpy_news_imagesadd", "add");

// Validate form
fcpy_news_imagesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_news_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_news_images->news_id->FldCaption(), $cpy_news_images->news_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nimg_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_news_images->nimg_order->FldErrMsg()) ?>");
			felm = this.GetElements("x" + infix + "_nimg_photo");
			elm = this.GetElements("fn_x" + infix + "_nimg_photo");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_news_images->nimg_photo->FldCaption(), $cpy_news_images->nimg_photo->ReqErrMsg)) ?>");

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
fcpy_news_imagesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_news_imagesadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_news_imagesadd.Lists["x_news_id"] = {"LinkField":"x_news_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_news_title","x_news_date","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_news"};
fcpy_news_imagesadd.Lists["x_news_id"].Data = "<?php echo $cpy_news_images_add->news_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_news_images_add->ShowPageHeader(); ?>
<?php
$cpy_news_images_add->ShowMessage();
?>
<form name="fcpy_news_imagesadd" id="fcpy_news_imagesadd" class="<?php echo $cpy_news_images_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_news_images_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_news_images_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_news_images">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_news_images_add->IsModal) ?>">
<?php if ($cpy_news_images->getCurrentMasterTable() == "cpy_news") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cpy_news">
<input type="hidden" name="fk_news_id" value="<?php echo $cpy_news_images->news_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_news_images->news_id->Visible) { // news_id ?>
	<div id="r_news_id" class="form-group">
		<label id="elh_cpy_news_images_news_id" for="x_news_id" class="<?php echo $cpy_news_images_add->LeftColumnClass ?>"><?php echo $cpy_news_images->news_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_news_images_add->RightColumnClass ?>"><div<?php echo $cpy_news_images->news_id->CellAttributes() ?>>
<?php if ($cpy_news_images->news_id->getSessionValue() <> "") { ?>
<span id="el_cpy_news_images_news_id">
<span<?php echo $cpy_news_images->news_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_news_images->news_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_news_id" name="x_news_id" value="<?php echo ew_HtmlEncode($cpy_news_images->news_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cpy_news_images_news_id">
<select data-table="cpy_news_images" data-field="x_news_id" data-value-separator="<?php echo $cpy_news_images->news_id->DisplayValueSeparatorAttribute() ?>" id="x_news_id" name="x_news_id"<?php echo $cpy_news_images->news_id->EditAttributes() ?>>
<?php echo $cpy_news_images->news_id->SelectOptionListHtml("x_news_id") ?>
</select>
</span>
<?php } ?>
<?php echo $cpy_news_images->news_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news_images->nimg_order->Visible) { // nimg_order ?>
	<div id="r_nimg_order" class="form-group">
		<label id="elh_cpy_news_images_nimg_order" for="x_nimg_order" class="<?php echo $cpy_news_images_add->LeftColumnClass ?>"><?php echo $cpy_news_images->nimg_order->FldCaption() ?></label>
		<div class="<?php echo $cpy_news_images_add->RightColumnClass ?>"><div<?php echo $cpy_news_images->nimg_order->CellAttributes() ?>>
<span id="el_cpy_news_images_nimg_order">
<input type="text" data-table="cpy_news_images" data-field="x_nimg_order" name="x_nimg_order" id="x_nimg_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_news_images->nimg_order->getPlaceHolder()) ?>" value="<?php echo $cpy_news_images->nimg_order->EditValue ?>"<?php echo $cpy_news_images->nimg_order->EditAttributes() ?>>
</span>
<?php echo $cpy_news_images->nimg_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_news_images->nimg_photo->Visible) { // nimg_photo ?>
	<div id="r_nimg_photo" class="form-group">
		<label id="elh_cpy_news_images_nimg_photo" class="<?php echo $cpy_news_images_add->LeftColumnClass ?>"><?php echo $cpy_news_images->nimg_photo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_news_images_add->RightColumnClass ?>"><div<?php echo $cpy_news_images->nimg_photo->CellAttributes() ?>>
<span id="el_cpy_news_images_nimg_photo">
<div id="fd_x_nimg_photo">
<span title="<?php echo $cpy_news_images->nimg_photo->FldTitle() ? $cpy_news_images->nimg_photo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_news_images->nimg_photo->ReadOnly || $cpy_news_images->nimg_photo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_news_images" data-field="x_nimg_photo" name="x_nimg_photo" id="x_nimg_photo"<?php echo $cpy_news_images->nimg_photo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_nimg_photo" id= "fn_x_nimg_photo" value="<?php echo $cpy_news_images->nimg_photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_nimg_photo" id= "fa_x_nimg_photo" value="0">
<input type="hidden" name="fs_x_nimg_photo" id= "fs_x_nimg_photo" value="200">
<input type="hidden" name="fx_x_nimg_photo" id= "fx_x_nimg_photo" value="<?php echo $cpy_news_images->nimg_photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_nimg_photo" id= "fm_x_nimg_photo" value="<?php echo $cpy_news_images->nimg_photo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_nimg_photo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_news_images->nimg_photo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_news_images_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_news_images_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_news_images_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_news_imagesadd.Init();
</script>
<?php
$cpy_news_images_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_news_images_add->Page_Terminate();
?>
