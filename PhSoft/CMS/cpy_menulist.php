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

$cpy_menu_list = NULL; // Initialize page object first

class ccpy_menu_list extends ccpy_menu {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_menu';

	// Page object name
	var $PageObjName = 'cpy_menu_list';

	// Grid form hidden field names
	var $FormName = 'fcpy_menulist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cpy_menuadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cpy_menudelete.php";
		$this->MultiUpdateUrl = "cpy_menuupdate.php";

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fcpy_menulistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Exit inline mode
	function ClearInlineMode() {
		$this->setKey("menu_id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (isset($_GET["menu_id"])) {
			$this->menu_id->setQueryStringValue($_GET["menu_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("menu_id", $this->menu_id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("menu_id")) <> strval($this->menu_id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old record
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->menu_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->menu_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_menu_pid") && $objForm->HasValue("o_menu_pid") && $this->menu_pid->CurrentValue <> $this->menu_pid->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_menu_rid") && $objForm->HasValue("o_menu_rid") && $this->menu_rid->CurrentValue <> $this->menu_rid->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_menu_order") && $objForm->HasValue("o_menu_order") && $this->menu_order->CurrentValue <> $this->menu_order->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_mode_id") && $objForm->HasValue("o_mode_id") && $this->mode_id->CurrentValue <> $this->mode_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_type_id") && $objForm->HasValue("o_type_id") && $this->type_id->CurrentValue <> $this->type_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_srch_id") && $objForm->HasValue("o_srch_id") && $this->srch_id->CurrentValue <> $this->srch_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_menu_status") && $objForm->HasValue("o_menu_status") && $this->menu_status->CurrentValue <> $this->menu_status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_menu_name") && $objForm->HasValue("o_menu_name") && $this->menu_name->CurrentValue <> $this->menu_name->OldValue)
			return FALSE;
		if (!ew_Empty($this->menu_icon->Upload->Value))
			return FALSE;
		if ($objForm->HasValue("x_page_id") && $objForm->HasValue("o_page_id") && $this->page_id->CurrentValue <> $this->page_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_menu_href") && $objForm->HasValue("o_menu_href") && $this->menu_href->CurrentValue <> $this->menu_href->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fcpy_menulistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->menu_pid->AdvancedSearch->ToJson(), ","); // Field menu_pid
		$sFilterList = ew_Concat($sFilterList, $this->menu_rid->AdvancedSearch->ToJson(), ","); // Field menu_rid
		$sFilterList = ew_Concat($sFilterList, $this->menu_order->AdvancedSearch->ToJson(), ","); // Field menu_order
		$sFilterList = ew_Concat($sFilterList, $this->mode_id->AdvancedSearch->ToJson(), ","); // Field mode_id
		$sFilterList = ew_Concat($sFilterList, $this->type_id->AdvancedSearch->ToJson(), ","); // Field type_id
		$sFilterList = ew_Concat($sFilterList, $this->srch_id->AdvancedSearch->ToJson(), ","); // Field srch_id
		$sFilterList = ew_Concat($sFilterList, $this->menu_status->AdvancedSearch->ToJson(), ","); // Field menu_status
		$sFilterList = ew_Concat($sFilterList, $this->menu_name->AdvancedSearch->ToJson(), ","); // Field menu_name
		$sFilterList = ew_Concat($sFilterList, $this->menu_icon->AdvancedSearch->ToJson(), ","); // Field menu_icon
		$sFilterList = ew_Concat($sFilterList, $this->page_id->AdvancedSearch->ToJson(), ","); // Field page_id
		$sFilterList = ew_Concat($sFilterList, $this->menu_href->AdvancedSearch->ToJson(), ","); // Field menu_href
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fcpy_menulistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field menu_pid
		$this->menu_pid->AdvancedSearch->SearchValue = @$filter["x_menu_pid"];
		$this->menu_pid->AdvancedSearch->SearchOperator = @$filter["z_menu_pid"];
		$this->menu_pid->AdvancedSearch->SearchCondition = @$filter["v_menu_pid"];
		$this->menu_pid->AdvancedSearch->SearchValue2 = @$filter["y_menu_pid"];
		$this->menu_pid->AdvancedSearch->SearchOperator2 = @$filter["w_menu_pid"];
		$this->menu_pid->AdvancedSearch->Save();

		// Field menu_rid
		$this->menu_rid->AdvancedSearch->SearchValue = @$filter["x_menu_rid"];
		$this->menu_rid->AdvancedSearch->SearchOperator = @$filter["z_menu_rid"];
		$this->menu_rid->AdvancedSearch->SearchCondition = @$filter["v_menu_rid"];
		$this->menu_rid->AdvancedSearch->SearchValue2 = @$filter["y_menu_rid"];
		$this->menu_rid->AdvancedSearch->SearchOperator2 = @$filter["w_menu_rid"];
		$this->menu_rid->AdvancedSearch->Save();

		// Field menu_order
		$this->menu_order->AdvancedSearch->SearchValue = @$filter["x_menu_order"];
		$this->menu_order->AdvancedSearch->SearchOperator = @$filter["z_menu_order"];
		$this->menu_order->AdvancedSearch->SearchCondition = @$filter["v_menu_order"];
		$this->menu_order->AdvancedSearch->SearchValue2 = @$filter["y_menu_order"];
		$this->menu_order->AdvancedSearch->SearchOperator2 = @$filter["w_menu_order"];
		$this->menu_order->AdvancedSearch->Save();

		// Field mode_id
		$this->mode_id->AdvancedSearch->SearchValue = @$filter["x_mode_id"];
		$this->mode_id->AdvancedSearch->SearchOperator = @$filter["z_mode_id"];
		$this->mode_id->AdvancedSearch->SearchCondition = @$filter["v_mode_id"];
		$this->mode_id->AdvancedSearch->SearchValue2 = @$filter["y_mode_id"];
		$this->mode_id->AdvancedSearch->SearchOperator2 = @$filter["w_mode_id"];
		$this->mode_id->AdvancedSearch->Save();

		// Field type_id
		$this->type_id->AdvancedSearch->SearchValue = @$filter["x_type_id"];
		$this->type_id->AdvancedSearch->SearchOperator = @$filter["z_type_id"];
		$this->type_id->AdvancedSearch->SearchCondition = @$filter["v_type_id"];
		$this->type_id->AdvancedSearch->SearchValue2 = @$filter["y_type_id"];
		$this->type_id->AdvancedSearch->SearchOperator2 = @$filter["w_type_id"];
		$this->type_id->AdvancedSearch->Save();

		// Field srch_id
		$this->srch_id->AdvancedSearch->SearchValue = @$filter["x_srch_id"];
		$this->srch_id->AdvancedSearch->SearchOperator = @$filter["z_srch_id"];
		$this->srch_id->AdvancedSearch->SearchCondition = @$filter["v_srch_id"];
		$this->srch_id->AdvancedSearch->SearchValue2 = @$filter["y_srch_id"];
		$this->srch_id->AdvancedSearch->SearchOperator2 = @$filter["w_srch_id"];
		$this->srch_id->AdvancedSearch->Save();

		// Field menu_status
		$this->menu_status->AdvancedSearch->SearchValue = @$filter["x_menu_status"];
		$this->menu_status->AdvancedSearch->SearchOperator = @$filter["z_menu_status"];
		$this->menu_status->AdvancedSearch->SearchCondition = @$filter["v_menu_status"];
		$this->menu_status->AdvancedSearch->SearchValue2 = @$filter["y_menu_status"];
		$this->menu_status->AdvancedSearch->SearchOperator2 = @$filter["w_menu_status"];
		$this->menu_status->AdvancedSearch->Save();

		// Field menu_name
		$this->menu_name->AdvancedSearch->SearchValue = @$filter["x_menu_name"];
		$this->menu_name->AdvancedSearch->SearchOperator = @$filter["z_menu_name"];
		$this->menu_name->AdvancedSearch->SearchCondition = @$filter["v_menu_name"];
		$this->menu_name->AdvancedSearch->SearchValue2 = @$filter["y_menu_name"];
		$this->menu_name->AdvancedSearch->SearchOperator2 = @$filter["w_menu_name"];
		$this->menu_name->AdvancedSearch->Save();

		// Field menu_icon
		$this->menu_icon->AdvancedSearch->SearchValue = @$filter["x_menu_icon"];
		$this->menu_icon->AdvancedSearch->SearchOperator = @$filter["z_menu_icon"];
		$this->menu_icon->AdvancedSearch->SearchCondition = @$filter["v_menu_icon"];
		$this->menu_icon->AdvancedSearch->SearchValue2 = @$filter["y_menu_icon"];
		$this->menu_icon->AdvancedSearch->SearchOperator2 = @$filter["w_menu_icon"];
		$this->menu_icon->AdvancedSearch->Save();

		// Field page_id
		$this->page_id->AdvancedSearch->SearchValue = @$filter["x_page_id"];
		$this->page_id->AdvancedSearch->SearchOperator = @$filter["z_page_id"];
		$this->page_id->AdvancedSearch->SearchCondition = @$filter["v_page_id"];
		$this->page_id->AdvancedSearch->SearchValue2 = @$filter["y_page_id"];
		$this->page_id->AdvancedSearch->SearchOperator2 = @$filter["w_page_id"];
		$this->page_id->AdvancedSearch->Save();

		// Field menu_href
		$this->menu_href->AdvancedSearch->SearchValue = @$filter["x_menu_href"];
		$this->menu_href->AdvancedSearch->SearchOperator = @$filter["z_menu_href"];
		$this->menu_href->AdvancedSearch->SearchCondition = @$filter["v_menu_href"];
		$this->menu_href->AdvancedSearch->SearchValue2 = @$filter["y_menu_href"];
		$this->menu_href->AdvancedSearch->SearchOperator2 = @$filter["w_menu_href"];
		$this->menu_href->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->menu_pid, $Default, FALSE); // menu_pid
		$this->BuildSearchSql($sWhere, $this->menu_rid, $Default, FALSE); // menu_rid
		$this->BuildSearchSql($sWhere, $this->menu_order, $Default, FALSE); // menu_order
		$this->BuildSearchSql($sWhere, $this->mode_id, $Default, FALSE); // mode_id
		$this->BuildSearchSql($sWhere, $this->type_id, $Default, FALSE); // type_id
		$this->BuildSearchSql($sWhere, $this->srch_id, $Default, FALSE); // srch_id
		$this->BuildSearchSql($sWhere, $this->menu_status, $Default, FALSE); // menu_status
		$this->BuildSearchSql($sWhere, $this->menu_name, $Default, FALSE); // menu_name
		$this->BuildSearchSql($sWhere, $this->menu_icon, $Default, FALSE); // menu_icon
		$this->BuildSearchSql($sWhere, $this->page_id, $Default, FALSE); // page_id
		$this->BuildSearchSql($sWhere, $this->menu_href, $Default, FALSE); // menu_href

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->menu_pid->AdvancedSearch->Save(); // menu_pid
			$this->menu_rid->AdvancedSearch->Save(); // menu_rid
			$this->menu_order->AdvancedSearch->Save(); // menu_order
			$this->mode_id->AdvancedSearch->Save(); // mode_id
			$this->type_id->AdvancedSearch->Save(); // type_id
			$this->srch_id->AdvancedSearch->Save(); // srch_id
			$this->menu_status->AdvancedSearch->Save(); // menu_status
			$this->menu_name->AdvancedSearch->Save(); // menu_name
			$this->menu_icon->AdvancedSearch->Save(); // menu_icon
			$this->page_id->AdvancedSearch->Save(); // page_id
			$this->menu_href->AdvancedSearch->Save(); // menu_href
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = $Fld->FldParm();
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->menu_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->menu_icon, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->menu_href, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->menu_pid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->menu_rid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->menu_order->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->mode_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->type_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->srch_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->menu_status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->menu_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->menu_icon->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->page_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->menu_href->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->menu_pid->AdvancedSearch->UnsetSession();
		$this->menu_rid->AdvancedSearch->UnsetSession();
		$this->menu_order->AdvancedSearch->UnsetSession();
		$this->mode_id->AdvancedSearch->UnsetSession();
		$this->type_id->AdvancedSearch->UnsetSession();
		$this->srch_id->AdvancedSearch->UnsetSession();
		$this->menu_status->AdvancedSearch->UnsetSession();
		$this->menu_name->AdvancedSearch->UnsetSession();
		$this->menu_icon->AdvancedSearch->UnsetSession();
		$this->page_id->AdvancedSearch->UnsetSession();
		$this->menu_href->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->menu_pid->AdvancedSearch->Load();
		$this->menu_rid->AdvancedSearch->Load();
		$this->menu_order->AdvancedSearch->Load();
		$this->mode_id->AdvancedSearch->Load();
		$this->type_id->AdvancedSearch->Load();
		$this->srch_id->AdvancedSearch->Load();
		$this->menu_status->AdvancedSearch->Load();
		$this->menu_name->AdvancedSearch->Load();
		$this->menu_icon->AdvancedSearch->Load();
		$this->page_id->AdvancedSearch->Load();
		$this->menu_href->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->menu_pid); // menu_pid
			$this->UpdateSort($this->menu_rid); // menu_rid
			$this->UpdateSort($this->menu_order); // menu_order
			$this->UpdateSort($this->mode_id); // mode_id
			$this->UpdateSort($this->type_id); // type_id
			$this->UpdateSort($this->srch_id); // srch_id
			$this->UpdateSort($this->menu_status); // menu_status
			$this->UpdateSort($this->menu_name); // menu_name
			$this->UpdateSort($this->menu_icon); // menu_icon
			$this->UpdateSort($this->page_id); // page_id
			$this->UpdateSort($this->menu_href); // menu_href
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->menu_pid->setSort("ASC");
				$this->menu_order->setSort("ASC");
				$this->type_id->setSort("ASC");
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->menu_pid->setSort("");
				$this->menu_rid->setSort("");
				$this->menu_order->setSort("");
				$this->mode_id->setSort("");
				$this->type_id->setSort("");
				$this->srch_id->setSort("");
				$this->menu_status->setSort("");
				$this->menu_name->setSort("");
				$this->menu_icon->setSort("");
				$this->page_id->setSort("");
				$this->menu_href->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->menu_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"cpy_menu\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "',btn:null});\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->menu_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->menu_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fcpy_menulist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fcpy_menulistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fcpy_menulistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fcpy_menulist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fcpy_menulistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"cpy_menusrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Search highlight button
		$item = &$this->SearchOptions->Add("searchhighlight");
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewHighlight active\" title=\"" . $Language->Phrase("Highlight") . "\" data-caption=\"" . $Language->Phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fcpy_menulistsrch\" data-name=\"" . $this->HighlightName() . "\">" . $Language->Phrase("HighlightBtn") . "</button>";
		$item->Visible = ($this->SearchWhere <> "" && $this->TotalRecs > 0);

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load default values
	function LoadDefaultValues() {
		$this->menu_id->CurrentValue = NULL;
		$this->menu_id->OldValue = $this->menu_id->CurrentValue;
		$this->menu_pid->CurrentValue = NULL;
		$this->menu_pid->OldValue = $this->menu_pid->CurrentValue;
		$this->menu_rid->CurrentValue = NULL;
		$this->menu_rid->OldValue = $this->menu_rid->CurrentValue;
		$this->menu_order->CurrentValue = 0;
		$this->menu_order->OldValue = $this->menu_order->CurrentValue;
		$this->mode_id->CurrentValue = NULL;
		$this->mode_id->OldValue = $this->mode_id->CurrentValue;
		$this->type_id->CurrentValue = 0;
		$this->type_id->OldValue = $this->type_id->CurrentValue;
		$this->srch_id->CurrentValue = 1;
		$this->srch_id->OldValue = $this->srch_id->CurrentValue;
		$this->menu_status->CurrentValue = 1;
		$this->menu_status->OldValue = $this->menu_status->CurrentValue;
		$this->menu_name->CurrentValue = NULL;
		$this->menu_name->OldValue = $this->menu_name->CurrentValue;
		$this->menu_icon->Upload->DbValue = NULL;
		$this->menu_icon->OldValue = $this->menu_icon->Upload->DbValue;
		$this->page_id->CurrentValue = 0;
		$this->page_id->OldValue = $this->page_id->CurrentValue;
		$this->menu_href->CurrentValue = "#";
		$this->menu_href->OldValue = $this->menu_href->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// menu_pid

		$this->menu_pid->AdvancedSearch->SearchValue = @$_GET["x_menu_pid"];
		if ($this->menu_pid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->menu_pid->AdvancedSearch->SearchOperator = @$_GET["z_menu_pid"];

		// menu_rid
		$this->menu_rid->AdvancedSearch->SearchValue = @$_GET["x_menu_rid"];
		if ($this->menu_rid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->menu_rid->AdvancedSearch->SearchOperator = @$_GET["z_menu_rid"];

		// menu_order
		$this->menu_order->AdvancedSearch->SearchValue = @$_GET["x_menu_order"];
		if ($this->menu_order->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->menu_order->AdvancedSearch->SearchOperator = @$_GET["z_menu_order"];

		// mode_id
		$this->mode_id->AdvancedSearch->SearchValue = @$_GET["x_mode_id"];
		if ($this->mode_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->mode_id->AdvancedSearch->SearchOperator = @$_GET["z_mode_id"];

		// type_id
		$this->type_id->AdvancedSearch->SearchValue = @$_GET["x_type_id"];
		if ($this->type_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->type_id->AdvancedSearch->SearchOperator = @$_GET["z_type_id"];

		// srch_id
		$this->srch_id->AdvancedSearch->SearchValue = @$_GET["x_srch_id"];
		if ($this->srch_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->srch_id->AdvancedSearch->SearchOperator = @$_GET["z_srch_id"];

		// menu_status
		$this->menu_status->AdvancedSearch->SearchValue = @$_GET["x_menu_status"];
		if ($this->menu_status->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->menu_status->AdvancedSearch->SearchOperator = @$_GET["z_menu_status"];

		// menu_name
		$this->menu_name->AdvancedSearch->SearchValue = @$_GET["x_menu_name"];
		if ($this->menu_name->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->menu_name->AdvancedSearch->SearchOperator = @$_GET["z_menu_name"];

		// menu_icon
		$this->menu_icon->AdvancedSearch->SearchValue = @$_GET["x_menu_icon"];
		if ($this->menu_icon->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->menu_icon->AdvancedSearch->SearchOperator = @$_GET["z_menu_icon"];

		// page_id
		$this->page_id->AdvancedSearch->SearchValue = @$_GET["x_page_id"];
		if ($this->page_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->page_id->AdvancedSearch->SearchOperator = @$_GET["z_page_id"];

		// menu_href
		$this->menu_href->AdvancedSearch->SearchValue = @$_GET["x_menu_href"];
		if ($this->menu_href->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->menu_href->AdvancedSearch->SearchOperator = @$_GET["z_menu_href"];
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
		$this->LoadDefaultValues();
		$row = array();
		$row['menu_id'] = $this->menu_id->CurrentValue;
		$row['menu_pid'] = $this->menu_pid->CurrentValue;
		$row['menu_rid'] = $this->menu_rid->CurrentValue;
		$row['menu_order'] = $this->menu_order->CurrentValue;
		$row['mode_id'] = $this->mode_id->CurrentValue;
		$row['type_id'] = $this->type_id->CurrentValue;
		$row['srch_id'] = $this->srch_id->CurrentValue;
		$row['menu_status'] = $this->menu_status->CurrentValue;
		$row['menu_name'] = $this->menu_name->CurrentValue;
		$row['menu_icon'] = $this->menu_icon->Upload->DbValue;
		$row['page_id'] = $this->page_id->CurrentValue;
		$row['menu_href'] = $this->menu_href->CurrentValue;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
			if ($this->Export == "")
				$this->menu_order->ViewValue = $this->HighlightValue($this->menu_order);

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
			if ($this->Export == "")
				$this->menu_name->ViewValue = $this->HighlightValue($this->menu_name);

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
				$this->menu_icon->LinkAttrs["data-rel"] = "cpy_menu_x" . $this->RowCnt . "_menu_icon";
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
			if ($this->Export == "")
				$this->menu_href->ViewValue = $this->HighlightValue($this->menu_href);
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->menu_icon, $this->RowIndex);

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

			// Add refer script
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
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->menu_icon, $this->RowIndex);

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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
			$this->menu_icon->OldUploadPath = '../../assets/img/icons/';
			$this->menu_icon->UploadPath = $this->menu_icon->OldUploadPath;
		}
		$rsnew = array();

		// menu_pid
		$this->menu_pid->SetDbValueDef($rsnew, $this->menu_pid->CurrentValue, 0, FALSE);

		// menu_rid
		$this->menu_rid->SetDbValueDef($rsnew, $this->menu_rid->CurrentValue, 0, FALSE);

		// menu_order
		$this->menu_order->SetDbValueDef($rsnew, $this->menu_order->CurrentValue, 0, strval($this->menu_order->CurrentValue) == "");

		// mode_id
		$this->mode_id->SetDbValueDef($rsnew, $this->mode_id->CurrentValue, 0, FALSE);

		// type_id
		$this->type_id->SetDbValueDef($rsnew, $this->type_id->CurrentValue, 0, strval($this->type_id->CurrentValue) == "");

		// srch_id
		$this->srch_id->SetDbValueDef($rsnew, $this->srch_id->CurrentValue, 0, strval($this->srch_id->CurrentValue) == "");

		// menu_status
		$this->menu_status->SetDbValueDef($rsnew, $this->menu_status->CurrentValue, 0, strval($this->menu_status->CurrentValue) == "");

		// menu_name
		$this->menu_name->SetDbValueDef($rsnew, $this->menu_name->CurrentValue, "", FALSE);

		// menu_icon
		if ($this->menu_icon->Visible && !$this->menu_icon->Upload->KeepFile) {
			$this->menu_icon->Upload->DbValue = ""; // No need to delete old file
			if ($this->menu_icon->Upload->FileName == "") {
				$rsnew['menu_icon'] = NULL;
			} else {
				$rsnew['menu_icon'] = $this->menu_icon->Upload->FileName;
			}
		}

		// page_id
		$this->page_id->SetDbValueDef($rsnew, $this->page_id->CurrentValue, 0, strval($this->page_id->CurrentValue) == "");

		// menu_href
		$this->menu_href->SetDbValueDef($rsnew, $this->menu_href->CurrentValue, "", strval($this->menu_href->CurrentValue) == "");
		if ($this->menu_icon->Visible && !$this->menu_icon->Upload->KeepFile) {
			$this->menu_icon->UploadPath = '../../assets/img/icons/';
			if (!ew_Empty($this->menu_icon->Upload->Value)) {
				$rsnew['menu_icon'] = ew_UploadFileNameEx($this->menu_icon->PhysicalUploadPath(), $rsnew['menu_icon']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['menu_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// menu_icon
		ew_CleanUploadTempPath($this->menu_icon, $this->menu_icon->Upload->Index);
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->menu_pid->AdvancedSearch->Load();
		$this->menu_rid->AdvancedSearch->Load();
		$this->menu_order->AdvancedSearch->Load();
		$this->mode_id->AdvancedSearch->Load();
		$this->type_id->AdvancedSearch->Load();
		$this->srch_id->AdvancedSearch->Load();
		$this->menu_status->AdvancedSearch->Load();
		$this->menu_name->AdvancedSearch->Load();
		$this->menu_icon->AdvancedSearch->Load();
		$this->page_id->AdvancedSearch->Load();
		$this->menu_href->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_menu_list)) $cpy_menu_list = new ccpy_menu_list();

// Page init
$cpy_menu_list->Page_Init();

// Page main
$cpy_menu_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_menu_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fcpy_menulist = new ew_Form("fcpy_menulist", "list");
fcpy_menulist.FormKeyCountName = '<?php echo $cpy_menu_list->FormKeyCountName ?>';

// Validate form
fcpy_menulist.Validate = function() {
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
	return true;
}

// Form_CustomValidate event
fcpy_menulist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_menulist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_menulist.Lists["x_menu_pid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_pname","x_menu_name","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_vmenu"};
fcpy_menulist.Lists["x_menu_pid"].Data = "<?php echo $cpy_menu_list->menu_pid->LookupFilterQuery(FALSE, "list") ?>";
fcpy_menulist.Lists["x_menu_rid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_pname","x_menu_name","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_vmenu"};
fcpy_menulist.Lists["x_menu_rid"].Data = "<?php echo $cpy_menu_list->menu_rid->LookupFilterQuery(FALSE, "list") ?>";
fcpy_menulist.Lists["x_mode_id"] = {"LinkField":"x_mode_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_mode_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_mode"};
fcpy_menulist.Lists["x_mode_id"].Data = "<?php echo $cpy_menu_list->mode_id->LookupFilterQuery(FALSE, "list") ?>";
fcpy_menulist.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_type"};
fcpy_menulist.Lists["x_type_id"].Data = "<?php echo $cpy_menu_list->type_id->LookupFilterQuery(FALSE, "list") ?>";
fcpy_menulist.Lists["x_srch_id"] = {"LinkField":"x_srch_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_srch_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_menu_search"};
fcpy_menulist.Lists["x_srch_id"].Data = "<?php echo $cpy_menu_list->srch_id->LookupFilterQuery(FALSE, "list") ?>";
fcpy_menulist.Lists["x_menu_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_menulist.Lists["x_menu_status"].Options = <?php echo json_encode($cpy_menu_list->menu_status->Options()) ?>;
fcpy_menulist.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_menulist.Lists["x_page_id"].Data = "<?php echo $cpy_menu_list->page_id->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = fcpy_menulistsrch = new ew_Form("fcpy_menulistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($cpy_menu_list->TotalRecs > 0 && $cpy_menu_list->ExportOptions->Visible()) { ?>
<?php $cpy_menu_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($cpy_menu_list->SearchOptions->Visible()) { ?>
<?php $cpy_menu_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($cpy_menu_list->FilterOptions->Visible()) { ?>
<?php $cpy_menu_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $cpy_menu_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_menu_list->TotalRecs <= 0)
			$cpy_menu_list->TotalRecs = $cpy_menu->ListRecordCount();
	} else {
		if (!$cpy_menu_list->Recordset && ($cpy_menu_list->Recordset = $cpy_menu_list->LoadRecordset()))
			$cpy_menu_list->TotalRecs = $cpy_menu_list->Recordset->RecordCount();
	}
	$cpy_menu_list->StartRec = 1;
	if ($cpy_menu_list->DisplayRecs <= 0 || ($cpy_menu->Export <> "" && $cpy_menu->ExportAll)) // Display all records
		$cpy_menu_list->DisplayRecs = $cpy_menu_list->TotalRecs;
	if (!($cpy_menu->Export <> "" && $cpy_menu->ExportAll))
		$cpy_menu_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cpy_menu_list->Recordset = $cpy_menu_list->LoadRecordset($cpy_menu_list->StartRec-1, $cpy_menu_list->DisplayRecs);

	// Set no record found message
	if ($cpy_menu->CurrentAction == "" && $cpy_menu_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_menu_list->setWarningMessage(ew_DeniedMsg());
		if ($cpy_menu_list->SearchWhere == "0=101")
			$cpy_menu_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_menu_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$cpy_menu_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cpy_menu->Export == "" && $cpy_menu->CurrentAction == "") { ?>
<form name="fcpy_menulistsrch" id="fcpy_menulistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($cpy_menu_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fcpy_menulistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cpy_menu">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($cpy_menu_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($cpy_menu_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $cpy_menu_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($cpy_menu_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($cpy_menu_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($cpy_menu_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($cpy_menu_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cpy_menu_list->ShowPageHeader(); ?>
<?php
$cpy_menu_list->ShowMessage();
?>
<?php if ($cpy_menu_list->TotalRecs > 0 || $cpy_menu->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_menu_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_menu">
<div class="box-header ewGridUpperPanel">
<?php if ($cpy_menu->CurrentAction <> "gridadd" && $cpy_menu->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_menu_list->Pager)) $cpy_menu_list->Pager = new cPrevNextPager($cpy_menu_list->StartRec, $cpy_menu_list->DisplayRecs, $cpy_menu_list->TotalRecs, $cpy_menu_list->AutoHidePager) ?>
<?php if ($cpy_menu_list->Pager->RecordCount > 0 && $cpy_menu_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_menu_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_menu_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_menu_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_menu_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_menu_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_menu_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cpy_menu_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cpy_menu_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cpy_menu_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_menu_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fcpy_menulist" id="fcpy_menulist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_menu_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_menu_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_menu">
<div id="gmp_cpy_menu" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($cpy_menu_list->TotalRecs > 0 || $cpy_menu->CurrentAction == "add" || $cpy_menu->CurrentAction == "copy" || $cpy_menu->CurrentAction == "gridedit") { ?>
<table id="tbl_cpy_menulist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_menu_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_menu_list->RenderListOptions();

// Render list options (header, left)
$cpy_menu_list->ListOptions->Render("header", "left");
?>
<?php if ($cpy_menu->menu_pid->Visible) { // menu_pid ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->menu_pid) == "") { ?>
		<th data-name="menu_pid" class="<?php echo $cpy_menu->menu_pid->HeaderCellClass() ?>"><div id="elh_cpy_menu_menu_pid" class="cpy_menu_menu_pid"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_pid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_pid" class="<?php echo $cpy_menu->menu_pid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->menu_pid) ?>',1);"><div id="elh_cpy_menu_menu_pid" class="cpy_menu_menu_pid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_pid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->menu_pid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->menu_pid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->menu_rid->Visible) { // menu_rid ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->menu_rid) == "") { ?>
		<th data-name="menu_rid" class="<?php echo $cpy_menu->menu_rid->HeaderCellClass() ?>"><div id="elh_cpy_menu_menu_rid" class="cpy_menu_menu_rid"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_rid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_rid" class="<?php echo $cpy_menu->menu_rid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->menu_rid) ?>',1);"><div id="elh_cpy_menu_menu_rid" class="cpy_menu_menu_rid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_rid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->menu_rid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->menu_rid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->menu_order->Visible) { // menu_order ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->menu_order) == "") { ?>
		<th data-name="menu_order" class="<?php echo $cpy_menu->menu_order->HeaderCellClass() ?>"><div id="elh_cpy_menu_menu_order" class="cpy_menu_menu_order"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_order" class="<?php echo $cpy_menu->menu_order->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->menu_order) ?>',1);"><div id="elh_cpy_menu_menu_order" class="cpy_menu_menu_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->menu_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->menu_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->mode_id->Visible) { // mode_id ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->mode_id) == "") { ?>
		<th data-name="mode_id" class="<?php echo $cpy_menu->mode_id->HeaderCellClass() ?>"><div id="elh_cpy_menu_mode_id" class="cpy_menu_mode_id"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->mode_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mode_id" class="<?php echo $cpy_menu->mode_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->mode_id) ?>',1);"><div id="elh_cpy_menu_mode_id" class="cpy_menu_mode_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->mode_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->mode_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->mode_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->type_id->Visible) { // type_id ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->type_id) == "") { ?>
		<th data-name="type_id" class="<?php echo $cpy_menu->type_id->HeaderCellClass() ?>"><div id="elh_cpy_menu_type_id" class="cpy_menu_type_id"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->type_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="type_id" class="<?php echo $cpy_menu->type_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->type_id) ?>',1);"><div id="elh_cpy_menu_type_id" class="cpy_menu_type_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->type_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->type_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->type_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->srch_id->Visible) { // srch_id ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->srch_id) == "") { ?>
		<th data-name="srch_id" class="<?php echo $cpy_menu->srch_id->HeaderCellClass() ?>"><div id="elh_cpy_menu_srch_id" class="cpy_menu_srch_id"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->srch_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="srch_id" class="<?php echo $cpy_menu->srch_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->srch_id) ?>',1);"><div id="elh_cpy_menu_srch_id" class="cpy_menu_srch_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->srch_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->srch_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->srch_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->menu_status->Visible) { // menu_status ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->menu_status) == "") { ?>
		<th data-name="menu_status" class="<?php echo $cpy_menu->menu_status->HeaderCellClass() ?>"><div id="elh_cpy_menu_menu_status" class="cpy_menu_menu_status"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_status" class="<?php echo $cpy_menu->menu_status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->menu_status) ?>',1);"><div id="elh_cpy_menu_menu_status" class="cpy_menu_menu_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->menu_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->menu_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->menu_name->Visible) { // menu_name ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->menu_name) == "") { ?>
		<th data-name="menu_name" class="<?php echo $cpy_menu->menu_name->HeaderCellClass() ?>"><div id="elh_cpy_menu_menu_name" class="cpy_menu_menu_name"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_name" class="<?php echo $cpy_menu->menu_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->menu_name) ?>',1);"><div id="elh_cpy_menu_menu_name" class="cpy_menu_menu_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->menu_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->menu_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->menu_icon->Visible) { // menu_icon ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->menu_icon) == "") { ?>
		<th data-name="menu_icon" class="<?php echo $cpy_menu->menu_icon->HeaderCellClass() ?>"><div id="elh_cpy_menu_menu_icon" class="cpy_menu_menu_icon"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_icon->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_icon" class="<?php echo $cpy_menu->menu_icon->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->menu_icon) ?>',1);"><div id="elh_cpy_menu_menu_icon" class="cpy_menu_menu_icon">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_icon->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->menu_icon->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->menu_icon->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->page_id->Visible) { // page_id ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->page_id) == "") { ?>
		<th data-name="page_id" class="<?php echo $cpy_menu->page_id->HeaderCellClass() ?>"><div id="elh_cpy_menu_page_id" class="cpy_menu_page_id"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->page_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_id" class="<?php echo $cpy_menu->page_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->page_id) ?>',1);"><div id="elh_cpy_menu_page_id" class="cpy_menu_page_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->page_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->page_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->page_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_menu->menu_href->Visible) { // menu_href ?>
	<?php if ($cpy_menu->SortUrl($cpy_menu->menu_href) == "") { ?>
		<th data-name="menu_href" class="<?php echo $cpy_menu->menu_href->HeaderCellClass() ?>"><div id="elh_cpy_menu_menu_href" class="cpy_menu_menu_href"><div class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_href->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_href" class="<?php echo $cpy_menu->menu_href->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_menu->SortUrl($cpy_menu->menu_href) ?>',1);"><div id="elh_cpy_menu_menu_href" class="cpy_menu_menu_href">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_menu->menu_href->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($cpy_menu->menu_href->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_menu->menu_href->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_menu_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($cpy_menu->CurrentAction == "add" || $cpy_menu->CurrentAction == "copy") {
		$cpy_menu_list->RowIndex = 0;
		$cpy_menu_list->KeyCount = $cpy_menu_list->RowIndex;
		if ($cpy_menu->CurrentAction == "add")
			$cpy_menu_list->LoadRowValues();
		if ($cpy_menu->EventCancelled) // Insert failed
			$cpy_menu_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$cpy_menu->ResetAttrs();
		$cpy_menu->RowAttrs = array_merge($cpy_menu->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_cpy_menu', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$cpy_menu->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_menu_list->RenderRow();

		// Render list options
		$cpy_menu_list->RenderListOptions();
		$cpy_menu_list->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_menu->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_menu_list->ListOptions->Render("body", "left", $cpy_menu_list->RowCnt);
?>
	<?php if ($cpy_menu->menu_pid->Visible) { // menu_pid ?>
		<td data-name="menu_pid">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_pid" class="form-group cpy_menu_menu_pid">
<select data-table="cpy_menu" data-field="x_menu_pid" data-value-separator="<?php echo $cpy_menu->menu_pid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid"<?php echo $cpy_menu->menu_pid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_pid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_pid" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" value="<?php echo ew_HtmlEncode($cpy_menu->menu_pid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_rid->Visible) { // menu_rid ?>
		<td data-name="menu_rid">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_rid" class="form-group cpy_menu_menu_rid">
<select data-table="cpy_menu" data-field="x_menu_rid" data-value-separator="<?php echo $cpy_menu->menu_rid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid"<?php echo $cpy_menu->menu_rid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_rid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_rid" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" value="<?php echo ew_HtmlEncode($cpy_menu->menu_rid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_order->Visible) { // menu_order ?>
		<td data-name="menu_order">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_order" class="form-group cpy_menu_menu_order">
<input type="text" data-table="cpy_menu" data-field="x_menu_order" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_order->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_order->EditValue ?>"<?php echo $cpy_menu->menu_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_order" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_order" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_order" value="<?php echo ew_HtmlEncode($cpy_menu->menu_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->mode_id->Visible) { // mode_id ?>
		<td data-name="mode_id">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_mode_id" class="form-group cpy_menu_mode_id">
<select data-table="cpy_menu" data-field="x_mode_id" data-value-separator="<?php echo $cpy_menu->mode_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id"<?php echo $cpy_menu->mode_id->EditAttributes() ?>>
<?php echo $cpy_menu->mode_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_mode_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_mode_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_mode_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_mode_id" value="<?php echo ew_HtmlEncode($cpy_menu->mode_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->type_id->Visible) { // type_id ?>
		<td data-name="type_id">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_type_id" class="form-group cpy_menu_type_id">
<select data-table="cpy_menu" data-field="x_type_id" data-value-separator="<?php echo $cpy_menu->type_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_type_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_type_id"<?php echo $cpy_menu->type_id->EditAttributes() ?>>
<?php echo $cpy_menu->type_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_type_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_type_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_type_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_type_id" value="<?php echo ew_HtmlEncode($cpy_menu->type_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->srch_id->Visible) { // srch_id ?>
		<td data-name="srch_id">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_srch_id" class="form-group cpy_menu_srch_id">
<select data-table="cpy_menu" data-field="x_srch_id" data-value-separator="<?php echo $cpy_menu->srch_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id"<?php echo $cpy_menu->srch_id->EditAttributes() ?>>
<?php echo $cpy_menu->srch_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_srch_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_srch_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_srch_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_srch_id" value="<?php echo ew_HtmlEncode($cpy_menu->srch_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_status->Visible) { // menu_status ?>
		<td data-name="menu_status">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_status" class="form-group cpy_menu_menu_status">
<select data-table="cpy_menu" data-field="x_menu_status" data-value-separator="<?php echo $cpy_menu->menu_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status"<?php echo $cpy_menu->menu_status->EditAttributes() ?>>
<?php echo $cpy_menu->menu_status->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_status" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_status" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_status" value="<?php echo ew_HtmlEncode($cpy_menu->menu_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_name->Visible) { // menu_name ?>
		<td data-name="menu_name">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_name" class="form-group cpy_menu_menu_name">
<input type="text" data-table="cpy_menu" data-field="x_menu_name" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_name->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_name->EditValue ?>"<?php echo $cpy_menu->menu_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_name" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_name" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_name" value="<?php echo ew_HtmlEncode($cpy_menu->menu_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_icon->Visible) { // menu_icon ?>
		<td data-name="menu_icon">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_icon" class="form-group cpy_menu_menu_icon">
<div id="fd_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon">
<span title="<?php echo $cpy_menu->menu_icon->FldTitle() ? $cpy_menu->menu_icon->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_menu->menu_icon->ReadOnly || $cpy_menu->menu_icon->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_menu" data-field="x_menu_icon" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon"<?php echo $cpy_menu->menu_icon->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="50">
<input type="hidden" name="fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_icon" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo ew_HtmlEncode($cpy_menu->menu_icon->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->page_id->Visible) { // page_id ?>
		<td data-name="page_id">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_page_id" class="form-group cpy_menu_page_id">
<select data-table="cpy_menu" data-field="x_page_id" data-value-separator="<?php echo $cpy_menu->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_page_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_page_id"<?php echo $cpy_menu->page_id->EditAttributes() ?>>
<?php echo $cpy_menu->page_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_page_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_page_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_page_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_menu->page_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_href->Visible) { // menu_href ?>
		<td data-name="menu_href">
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_href" class="form-group cpy_menu_menu_href">
<input type="text" data-table="cpy_menu" data-field="x_menu_href" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_href->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_href->EditValue ?>"<?php echo $cpy_menu->menu_href->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_href" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_href" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_href" value="<?php echo ew_HtmlEncode($cpy_menu->menu_href->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_menu_list->ListOptions->Render("body", "right", $cpy_menu_list->RowCnt);
?>
<script type="text/javascript">
fcpy_menulist.UpdateOpts(<?php echo $cpy_menu_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($cpy_menu->ExportAll && $cpy_menu->Export <> "") {
	$cpy_menu_list->StopRec = $cpy_menu_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cpy_menu_list->TotalRecs > $cpy_menu_list->StartRec + $cpy_menu_list->DisplayRecs - 1)
		$cpy_menu_list->StopRec = $cpy_menu_list->StartRec + $cpy_menu_list->DisplayRecs - 1;
	else
		$cpy_menu_list->StopRec = $cpy_menu_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_menu_list->FormKeyCountName) && ($cpy_menu->CurrentAction == "gridadd" || $cpy_menu->CurrentAction == "gridedit" || $cpy_menu->CurrentAction == "F")) {
		$cpy_menu_list->KeyCount = $objForm->GetValue($cpy_menu_list->FormKeyCountName);
		$cpy_menu_list->StopRec = $cpy_menu_list->StartRec + $cpy_menu_list->KeyCount - 1;
	}
}
$cpy_menu_list->RecCnt = $cpy_menu_list->StartRec - 1;
if ($cpy_menu_list->Recordset && !$cpy_menu_list->Recordset->EOF) {
	$cpy_menu_list->Recordset->MoveFirst();
	$bSelectLimit = $cpy_menu_list->UseSelectLimit;
	if (!$bSelectLimit && $cpy_menu_list->StartRec > 1)
		$cpy_menu_list->Recordset->Move($cpy_menu_list->StartRec - 1);
} elseif (!$cpy_menu->AllowAddDeleteRow && $cpy_menu_list->StopRec == 0) {
	$cpy_menu_list->StopRec = $cpy_menu->GridAddRowCount;
}

// Initialize aggregate
$cpy_menu->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_menu->ResetAttrs();
$cpy_menu_list->RenderRow();
$cpy_menu_list->EditRowCnt = 0;
if ($cpy_menu->CurrentAction == "edit")
	$cpy_menu_list->RowIndex = 1;
if ($cpy_menu->CurrentAction == "gridedit")
	$cpy_menu_list->RowIndex = 0;
while ($cpy_menu_list->RecCnt < $cpy_menu_list->StopRec) {
	$cpy_menu_list->RecCnt++;
	if (intval($cpy_menu_list->RecCnt) >= intval($cpy_menu_list->StartRec)) {
		$cpy_menu_list->RowCnt++;
		if ($cpy_menu->CurrentAction == "gridadd" || $cpy_menu->CurrentAction == "gridedit" || $cpy_menu->CurrentAction == "F") {
			$cpy_menu_list->RowIndex++;
			$objForm->Index = $cpy_menu_list->RowIndex;
			if ($objForm->HasValue($cpy_menu_list->FormActionName))
				$cpy_menu_list->RowAction = strval($objForm->GetValue($cpy_menu_list->FormActionName));
			elseif ($cpy_menu->CurrentAction == "gridadd")
				$cpy_menu_list->RowAction = "insert";
			else
				$cpy_menu_list->RowAction = "";
		}

		// Set up key count
		$cpy_menu_list->KeyCount = $cpy_menu_list->RowIndex;

		// Init row class and style
		$cpy_menu->ResetAttrs();
		$cpy_menu->CssClass = "";
		if ($cpy_menu->CurrentAction == "gridadd") {
			$cpy_menu_list->LoadRowValues(); // Load default values
		} else {
			$cpy_menu_list->LoadRowValues($cpy_menu_list->Recordset); // Load row values
		}
		$cpy_menu->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_menu->CurrentAction == "edit") {
			if ($cpy_menu_list->CheckInlineEditKey() && $cpy_menu_list->EditRowCnt == 0) { // Inline edit
				$cpy_menu->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cpy_menu->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_menu->EventCancelled) {
				$cpy_menu_list->RestoreCurrentRowFormValues($cpy_menu_list->RowIndex); // Restore form values
			}
			if ($cpy_menu_list->RowAction == "insert")
				$cpy_menu->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_menu->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_menu->CurrentAction == "edit" && $cpy_menu->RowType == EW_ROWTYPE_EDIT && $cpy_menu->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cpy_menu_list->RestoreFormValues(); // Restore form values
		}
		if ($cpy_menu->CurrentAction == "gridedit" && ($cpy_menu->RowType == EW_ROWTYPE_EDIT || $cpy_menu->RowType == EW_ROWTYPE_ADD) && $cpy_menu->EventCancelled) // Update failed
			$cpy_menu_list->RestoreCurrentRowFormValues($cpy_menu_list->RowIndex); // Restore form values
		if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_menu_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cpy_menu->RowAttrs = array_merge($cpy_menu->RowAttrs, array('data-rowindex'=>$cpy_menu_list->RowCnt, 'id'=>'r' . $cpy_menu_list->RowCnt . '_cpy_menu', 'data-rowtype'=>$cpy_menu->RowType));

		// Render row
		$cpy_menu_list->RenderRow();

		// Render list options
		$cpy_menu_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_menu_list->RowAction <> "delete" && $cpy_menu_list->RowAction <> "insertdelete" && !($cpy_menu_list->RowAction == "insert" && $cpy_menu->CurrentAction == "F" && $cpy_menu_list->EmptyRow())) {
?>
	<tr<?php echo $cpy_menu->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_menu_list->ListOptions->Render("body", "left", $cpy_menu_list->RowCnt);
?>
	<?php if ($cpy_menu->menu_pid->Visible) { // menu_pid ?>
		<td data-name="menu_pid"<?php echo $cpy_menu->menu_pid->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_pid" class="form-group cpy_menu_menu_pid">
<select data-table="cpy_menu" data-field="x_menu_pid" data-value-separator="<?php echo $cpy_menu->menu_pid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid"<?php echo $cpy_menu->menu_pid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_pid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_pid" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" value="<?php echo ew_HtmlEncode($cpy_menu->menu_pid->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_pid" class="form-group cpy_menu_menu_pid">
<select data-table="cpy_menu" data-field="x_menu_pid" data-value-separator="<?php echo $cpy_menu->menu_pid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid"<?php echo $cpy_menu->menu_pid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_pid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_pid" class="cpy_menu_menu_pid">
<span<?php echo $cpy_menu->menu_pid->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_pid->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_id" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($cpy_menu->menu_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_menu" data-field="x_menu_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($cpy_menu->menu_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT || $cpy_menu->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_id" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($cpy_menu->menu_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_menu->menu_rid->Visible) { // menu_rid ?>
		<td data-name="menu_rid"<?php echo $cpy_menu->menu_rid->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_rid" class="form-group cpy_menu_menu_rid">
<select data-table="cpy_menu" data-field="x_menu_rid" data-value-separator="<?php echo $cpy_menu->menu_rid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid"<?php echo $cpy_menu->menu_rid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_rid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_rid" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" value="<?php echo ew_HtmlEncode($cpy_menu->menu_rid->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_rid" class="form-group cpy_menu_menu_rid">
<select data-table="cpy_menu" data-field="x_menu_rid" data-value-separator="<?php echo $cpy_menu->menu_rid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid"<?php echo $cpy_menu->menu_rid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_rid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_rid" class="cpy_menu_menu_rid">
<span<?php echo $cpy_menu->menu_rid->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_rid->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_order->Visible) { // menu_order ?>
		<td data-name="menu_order"<?php echo $cpy_menu->menu_order->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_order" class="form-group cpy_menu_menu_order">
<input type="text" data-table="cpy_menu" data-field="x_menu_order" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_order->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_order->EditValue ?>"<?php echo $cpy_menu->menu_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_order" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_order" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_order" value="<?php echo ew_HtmlEncode($cpy_menu->menu_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_order" class="form-group cpy_menu_menu_order">
<input type="text" data-table="cpy_menu" data-field="x_menu_order" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_order->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_order->EditValue ?>"<?php echo $cpy_menu->menu_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_order" class="cpy_menu_menu_order">
<span<?php echo $cpy_menu->menu_order->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_order->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->mode_id->Visible) { // mode_id ?>
		<td data-name="mode_id"<?php echo $cpy_menu->mode_id->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_mode_id" class="form-group cpy_menu_mode_id">
<select data-table="cpy_menu" data-field="x_mode_id" data-value-separator="<?php echo $cpy_menu->mode_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id"<?php echo $cpy_menu->mode_id->EditAttributes() ?>>
<?php echo $cpy_menu->mode_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_mode_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_mode_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_mode_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_mode_id" value="<?php echo ew_HtmlEncode($cpy_menu->mode_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_mode_id" class="form-group cpy_menu_mode_id">
<select data-table="cpy_menu" data-field="x_mode_id" data-value-separator="<?php echo $cpy_menu->mode_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id"<?php echo $cpy_menu->mode_id->EditAttributes() ?>>
<?php echo $cpy_menu->mode_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_mode_id") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_mode_id" class="cpy_menu_mode_id">
<span<?php echo $cpy_menu->mode_id->ViewAttributes() ?>>
<?php echo $cpy_menu->mode_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->type_id->Visible) { // type_id ?>
		<td data-name="type_id"<?php echo $cpy_menu->type_id->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_type_id" class="form-group cpy_menu_type_id">
<select data-table="cpy_menu" data-field="x_type_id" data-value-separator="<?php echo $cpy_menu->type_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_type_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_type_id"<?php echo $cpy_menu->type_id->EditAttributes() ?>>
<?php echo $cpy_menu->type_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_type_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_type_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_type_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_type_id" value="<?php echo ew_HtmlEncode($cpy_menu->type_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_type_id" class="form-group cpy_menu_type_id">
<select data-table="cpy_menu" data-field="x_type_id" data-value-separator="<?php echo $cpy_menu->type_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_type_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_type_id"<?php echo $cpy_menu->type_id->EditAttributes() ?>>
<?php echo $cpy_menu->type_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_type_id") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_type_id" class="cpy_menu_type_id">
<span<?php echo $cpy_menu->type_id->ViewAttributes() ?>>
<?php echo $cpy_menu->type_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->srch_id->Visible) { // srch_id ?>
		<td data-name="srch_id"<?php echo $cpy_menu->srch_id->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_srch_id" class="form-group cpy_menu_srch_id">
<select data-table="cpy_menu" data-field="x_srch_id" data-value-separator="<?php echo $cpy_menu->srch_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id"<?php echo $cpy_menu->srch_id->EditAttributes() ?>>
<?php echo $cpy_menu->srch_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_srch_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_srch_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_srch_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_srch_id" value="<?php echo ew_HtmlEncode($cpy_menu->srch_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_srch_id" class="form-group cpy_menu_srch_id">
<select data-table="cpy_menu" data-field="x_srch_id" data-value-separator="<?php echo $cpy_menu->srch_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id"<?php echo $cpy_menu->srch_id->EditAttributes() ?>>
<?php echo $cpy_menu->srch_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_srch_id") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_srch_id" class="cpy_menu_srch_id">
<span<?php echo $cpy_menu->srch_id->ViewAttributes() ?>>
<?php echo $cpy_menu->srch_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_status->Visible) { // menu_status ?>
		<td data-name="menu_status"<?php echo $cpy_menu->menu_status->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_status" class="form-group cpy_menu_menu_status">
<select data-table="cpy_menu" data-field="x_menu_status" data-value-separator="<?php echo $cpy_menu->menu_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status"<?php echo $cpy_menu->menu_status->EditAttributes() ?>>
<?php echo $cpy_menu->menu_status->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_status" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_status" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_status" value="<?php echo ew_HtmlEncode($cpy_menu->menu_status->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_status" class="form-group cpy_menu_menu_status">
<select data-table="cpy_menu" data-field="x_menu_status" data-value-separator="<?php echo $cpy_menu->menu_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status"<?php echo $cpy_menu->menu_status->EditAttributes() ?>>
<?php echo $cpy_menu->menu_status->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_status") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_status" class="cpy_menu_menu_status">
<span<?php echo $cpy_menu->menu_status->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_status->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_name->Visible) { // menu_name ?>
		<td data-name="menu_name"<?php echo $cpy_menu->menu_name->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_name" class="form-group cpy_menu_menu_name">
<input type="text" data-table="cpy_menu" data-field="x_menu_name" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_name->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_name->EditValue ?>"<?php echo $cpy_menu->menu_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_name" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_name" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_name" value="<?php echo ew_HtmlEncode($cpy_menu->menu_name->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_name" class="form-group cpy_menu_menu_name">
<input type="text" data-table="cpy_menu" data-field="x_menu_name" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_name->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_name->EditValue ?>"<?php echo $cpy_menu->menu_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_name" class="cpy_menu_menu_name">
<span<?php echo $cpy_menu->menu_name->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_name->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_icon->Visible) { // menu_icon ?>
		<td data-name="menu_icon"<?php echo $cpy_menu->menu_icon->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_icon" class="form-group cpy_menu_menu_icon">
<div id="fd_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon">
<span title="<?php echo $cpy_menu->menu_icon->FldTitle() ? $cpy_menu->menu_icon->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_menu->menu_icon->ReadOnly || $cpy_menu->menu_icon->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_menu" data-field="x_menu_icon" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon"<?php echo $cpy_menu->menu_icon->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="50">
<input type="hidden" name="fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_icon" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo ew_HtmlEncode($cpy_menu->menu_icon->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_icon" class="form-group cpy_menu_menu_icon">
<div id="fd_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon">
<span title="<?php echo $cpy_menu->menu_icon->FldTitle() ? $cpy_menu->menu_icon->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_menu->menu_icon->ReadOnly || $cpy_menu->menu_icon->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_menu" data-field="x_menu_icon" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon"<?php echo $cpy_menu->menu_icon->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="50">
<input type="hidden" name="fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_icon" class="cpy_menu_menu_icon">
<span>
<?php echo ew_GetFileViewTag($cpy_menu->menu_icon, $cpy_menu->menu_icon->ListViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->page_id->Visible) { // page_id ?>
		<td data-name="page_id"<?php echo $cpy_menu->page_id->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_page_id" class="form-group cpy_menu_page_id">
<select data-table="cpy_menu" data-field="x_page_id" data-value-separator="<?php echo $cpy_menu->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_page_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_page_id"<?php echo $cpy_menu->page_id->EditAttributes() ?>>
<?php echo $cpy_menu->page_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_page_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_page_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_page_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_menu->page_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_page_id" class="form-group cpy_menu_page_id">
<select data-table="cpy_menu" data-field="x_page_id" data-value-separator="<?php echo $cpy_menu->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_page_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_page_id"<?php echo $cpy_menu->page_id->EditAttributes() ?>>
<?php echo $cpy_menu->page_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_page_id" class="cpy_menu_page_id">
<span<?php echo $cpy_menu->page_id->ViewAttributes() ?>>
<?php echo $cpy_menu->page_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_href->Visible) { // menu_href ?>
		<td data-name="menu_href"<?php echo $cpy_menu->menu_href->CellAttributes() ?>>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_href" class="form-group cpy_menu_menu_href">
<input type="text" data-table="cpy_menu" data-field="x_menu_href" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_href->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_href->EditValue ?>"<?php echo $cpy_menu->menu_href->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_href" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_href" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_href" value="<?php echo ew_HtmlEncode($cpy_menu->menu_href->OldValue) ?>">
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_href" class="form-group cpy_menu_menu_href">
<input type="text" data-table="cpy_menu" data-field="x_menu_href" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_href->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_href->EditValue ?>"<?php echo $cpy_menu->menu_href->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_menu_list->RowCnt ?>_cpy_menu_menu_href" class="cpy_menu_menu_href">
<span<?php echo $cpy_menu->menu_href->ViewAttributes() ?>>
<?php echo $cpy_menu->menu_href->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_menu_list->ListOptions->Render("body", "right", $cpy_menu_list->RowCnt);
?>
	</tr>
<?php if ($cpy_menu->RowType == EW_ROWTYPE_ADD || $cpy_menu->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_menulist.UpdateOpts(<?php echo $cpy_menu_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_menu->CurrentAction <> "gridadd")
		if (!$cpy_menu_list->Recordset->EOF) $cpy_menu_list->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_menu->CurrentAction == "gridadd" || $cpy_menu->CurrentAction == "gridedit") {
		$cpy_menu_list->RowIndex = '$rowindex$';
		$cpy_menu_list->LoadRowValues();

		// Set row properties
		$cpy_menu->ResetAttrs();
		$cpy_menu->RowAttrs = array_merge($cpy_menu->RowAttrs, array('data-rowindex'=>$cpy_menu_list->RowIndex, 'id'=>'r0_cpy_menu', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_menu->RowAttrs["class"], "ewTemplate");
		$cpy_menu->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_menu_list->RenderRow();

		// Render list options
		$cpy_menu_list->RenderListOptions();
		$cpy_menu_list->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_menu->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_menu_list->ListOptions->Render("body", "left", $cpy_menu_list->RowIndex);
?>
	<?php if ($cpy_menu->menu_pid->Visible) { // menu_pid ?>
		<td data-name="menu_pid">
<span id="el$rowindex$_cpy_menu_menu_pid" class="form-group cpy_menu_menu_pid">
<select data-table="cpy_menu" data-field="x_menu_pid" data-value-separator="<?php echo $cpy_menu->menu_pid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid"<?php echo $cpy_menu->menu_pid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_pid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_pid") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_pid" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_pid" value="<?php echo ew_HtmlEncode($cpy_menu->menu_pid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_rid->Visible) { // menu_rid ?>
		<td data-name="menu_rid">
<span id="el$rowindex$_cpy_menu_menu_rid" class="form-group cpy_menu_menu_rid">
<select data-table="cpy_menu" data-field="x_menu_rid" data-value-separator="<?php echo $cpy_menu->menu_rid->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid"<?php echo $cpy_menu->menu_rid->EditAttributes() ?>>
<?php echo $cpy_menu->menu_rid->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_rid") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_rid" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_rid" value="<?php echo ew_HtmlEncode($cpy_menu->menu_rid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_order->Visible) { // menu_order ?>
		<td data-name="menu_order">
<span id="el$rowindex$_cpy_menu_menu_order" class="form-group cpy_menu_menu_order">
<input type="text" data-table="cpy_menu" data-field="x_menu_order" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_order->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_order->EditValue ?>"<?php echo $cpy_menu->menu_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_order" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_order" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_order" value="<?php echo ew_HtmlEncode($cpy_menu->menu_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->mode_id->Visible) { // mode_id ?>
		<td data-name="mode_id">
<span id="el$rowindex$_cpy_menu_mode_id" class="form-group cpy_menu_mode_id">
<select data-table="cpy_menu" data-field="x_mode_id" data-value-separator="<?php echo $cpy_menu->mode_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_mode_id"<?php echo $cpy_menu->mode_id->EditAttributes() ?>>
<?php echo $cpy_menu->mode_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_mode_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_mode_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_mode_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_mode_id" value="<?php echo ew_HtmlEncode($cpy_menu->mode_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->type_id->Visible) { // type_id ?>
		<td data-name="type_id">
<span id="el$rowindex$_cpy_menu_type_id" class="form-group cpy_menu_type_id">
<select data-table="cpy_menu" data-field="x_type_id" data-value-separator="<?php echo $cpy_menu->type_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_type_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_type_id"<?php echo $cpy_menu->type_id->EditAttributes() ?>>
<?php echo $cpy_menu->type_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_type_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_type_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_type_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_type_id" value="<?php echo ew_HtmlEncode($cpy_menu->type_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->srch_id->Visible) { // srch_id ?>
		<td data-name="srch_id">
<span id="el$rowindex$_cpy_menu_srch_id" class="form-group cpy_menu_srch_id">
<select data-table="cpy_menu" data-field="x_srch_id" data-value-separator="<?php echo $cpy_menu->srch_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_srch_id"<?php echo $cpy_menu->srch_id->EditAttributes() ?>>
<?php echo $cpy_menu->srch_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_srch_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_srch_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_srch_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_srch_id" value="<?php echo ew_HtmlEncode($cpy_menu->srch_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_status->Visible) { // menu_status ?>
		<td data-name="menu_status">
<span id="el$rowindex$_cpy_menu_menu_status" class="form-group cpy_menu_menu_status">
<select data-table="cpy_menu" data-field="x_menu_status" data-value-separator="<?php echo $cpy_menu->menu_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_status"<?php echo $cpy_menu->menu_status->EditAttributes() ?>>
<?php echo $cpy_menu->menu_status->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_menu_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_status" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_status" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_status" value="<?php echo ew_HtmlEncode($cpy_menu->menu_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_name->Visible) { // menu_name ?>
		<td data-name="menu_name">
<span id="el$rowindex$_cpy_menu_menu_name" class="form-group cpy_menu_menu_name">
<input type="text" data-table="cpy_menu" data-field="x_menu_name" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_name" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_name->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_name->EditValue ?>"<?php echo $cpy_menu->menu_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_name" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_name" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_name" value="<?php echo ew_HtmlEncode($cpy_menu->menu_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_icon->Visible) { // menu_icon ?>
		<td data-name="menu_icon">
<span id="el$rowindex$_cpy_menu_menu_icon" class="form-group cpy_menu_menu_icon">
<div id="fd_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon">
<span title="<?php echo $cpy_menu->menu_icon->FldTitle() ? $cpy_menu->menu_icon->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_menu->menu_icon->ReadOnly || $cpy_menu->menu_icon->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_menu" data-field="x_menu_icon" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon"<?php echo $cpy_menu->menu_icon->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fn_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fa_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fs_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="50">
<input type="hidden" name="fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fx_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id= "fm_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo $cpy_menu->menu_icon->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_icon" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_icon" value="<?php echo ew_HtmlEncode($cpy_menu->menu_icon->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->page_id->Visible) { // page_id ?>
		<td data-name="page_id">
<span id="el$rowindex$_cpy_menu_page_id" class="form-group cpy_menu_page_id">
<select data-table="cpy_menu" data-field="x_page_id" data-value-separator="<?php echo $cpy_menu->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_menu_list->RowIndex ?>_page_id" name="x<?php echo $cpy_menu_list->RowIndex ?>_page_id"<?php echo $cpy_menu->page_id->EditAttributes() ?>>
<?php echo $cpy_menu->page_id->SelectOptionListHtml("x<?php echo $cpy_menu_list->RowIndex ?>_page_id") ?>
</select>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_page_id" name="o<?php echo $cpy_menu_list->RowIndex ?>_page_id" id="o<?php echo $cpy_menu_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_menu->page_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_menu->menu_href->Visible) { // menu_href ?>
		<td data-name="menu_href">
<span id="el$rowindex$_cpy_menu_menu_href" class="form-group cpy_menu_menu_href">
<input type="text" data-table="cpy_menu" data-field="x_menu_href" name="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" id="x<?php echo $cpy_menu_list->RowIndex ?>_menu_href" placeholder="<?php echo ew_HtmlEncode($cpy_menu->menu_href->getPlaceHolder()) ?>" value="<?php echo $cpy_menu->menu_href->EditValue ?>"<?php echo $cpy_menu->menu_href->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_menu" data-field="x_menu_href" name="o<?php echo $cpy_menu_list->RowIndex ?>_menu_href" id="o<?php echo $cpy_menu_list->RowIndex ?>_menu_href" value="<?php echo ew_HtmlEncode($cpy_menu->menu_href->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_menu_list->ListOptions->Render("body", "right", $cpy_menu_list->RowCnt);
?>
<script type="text/javascript">
fcpy_menulist.UpdateOpts(<?php echo $cpy_menu_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cpy_menu->CurrentAction == "add" || $cpy_menu->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $cpy_menu_list->FormKeyCountName ?>" id="<?php echo $cpy_menu_list->FormKeyCountName ?>" value="<?php echo $cpy_menu_list->KeyCount ?>">
<?php } ?>
<?php if ($cpy_menu->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $cpy_menu_list->FormKeyCountName ?>" id="<?php echo $cpy_menu_list->FormKeyCountName ?>" value="<?php echo $cpy_menu_list->KeyCount ?>">
<?php } ?>
<?php if ($cpy_menu->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_menu_list->FormKeyCountName ?>" id="<?php echo $cpy_menu_list->FormKeyCountName ?>" value="<?php echo $cpy_menu_list->KeyCount ?>">
<?php echo $cpy_menu_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_menu->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cpy_menu_list->Recordset)
	$cpy_menu_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($cpy_menu->CurrentAction <> "gridadd" && $cpy_menu->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_menu_list->Pager)) $cpy_menu_list->Pager = new cPrevNextPager($cpy_menu_list->StartRec, $cpy_menu_list->DisplayRecs, $cpy_menu_list->TotalRecs, $cpy_menu_list->AutoHidePager) ?>
<?php if ($cpy_menu_list->Pager->RecordCount > 0 && $cpy_menu_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_menu_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_menu_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_menu_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_menu_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_menu_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_menu_list->PageUrl() ?>start=<?php echo $cpy_menu_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_menu_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cpy_menu_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cpy_menu_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cpy_menu_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_menu_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($cpy_menu_list->TotalRecs == 0 && $cpy_menu->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_menu_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fcpy_menulistsrch.FilterList = <?php echo $cpy_menu_list->GetFilterList() ?>;
fcpy_menulistsrch.Init();
fcpy_menulist.Init();
</script>
<?php
$cpy_menu_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_menu_list->Page_Terminate();
?>
