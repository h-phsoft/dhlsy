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

$cpy_page_block_list = NULL; // Initialize page object first

class ccpy_page_block_list extends ccpy_page_block {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_page_block';

	// Page object name
	var $PageObjName = 'cpy_page_block_list';

	// Grid form hidden field names
	var $FormName = 'fcpy_page_blocklist';
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

		// Table object (cpy_page_block)
		if (!isset($GLOBALS["cpy_page_block"]) || get_class($GLOBALS["cpy_page_block"]) == "ccpy_page_block") {
			$GLOBALS["cpy_page_block"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_page_block"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cpy_page_blockadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cpy_page_blockdelete.php";
		$this->MultiUpdateUrl = "cpy_page_blockupdate.php";

		// Table object (cpy_page)
		if (!isset($GLOBALS['cpy_page'])) $GLOBALS['cpy_page'] = new ccpy_page();

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fcpy_page_blocklistsrch";

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

		// Set up master detail parameters
		$this->SetupMasterParms();

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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cpy_page") {
			global $cpy_page;
			$rsmaster = $cpy_page->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cpy_pagelist.php"); // Return to master page
			} else {
				$cpy_page->LoadListRowValues($rsmaster);
				$cpy_page->RowType = EW_ROWTYPE_MASTER; // Master row
				$cpy_page->RenderListRow();
				$rsmaster->Close();
			}
		}

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
		$this->setKey("pblk_id", ""); // Clear inline edit key
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
		if (isset($_GET["pblk_id"])) {
			$this->pblk_id->setQueryStringValue($_GET["pblk_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("pblk_id", $this->pblk_id->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("pblk_id")) <> strval($this->pblk_id->CurrentValue))
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
			$this->pblk_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->pblk_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_page_id") && $objForm->HasValue("o_page_id") && $this->page_id->CurrentValue <> $this->page_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_blk_id") && $objForm->HasValue("o_blk_id") && $this->blk_id->CurrentValue <> $this->blk_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pblk_order") && $objForm->HasValue("o_pblk_order") && $this->pblk_order->CurrentValue <> $this->pblk_order->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pblk_status") && $objForm->HasValue("o_pblk_status") && $this->pblk_status->CurrentValue <> $this->pblk_status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pblk_name") && $objForm->HasValue("o_pblk_name") && $this->pblk_name->CurrentValue <> $this->pblk_name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pblk_bgcolor") && $objForm->HasValue("o_pblk_bgcolor") && $this->pblk_bgcolor->CurrentValue <> $this->pblk_bgcolor->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pblk_stext") && $objForm->HasValue("o_pblk_stext") && $this->pblk_stext->CurrentValue <> $this->pblk_stext->OldValue)
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fcpy_page_blocklistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->page_id->AdvancedSearch->ToJson(), ","); // Field page_id
		$sFilterList = ew_Concat($sFilterList, $this->blk_id->AdvancedSearch->ToJson(), ","); // Field blk_id
		$sFilterList = ew_Concat($sFilterList, $this->pblk_order->AdvancedSearch->ToJson(), ","); // Field pblk_order
		$sFilterList = ew_Concat($sFilterList, $this->pblk_status->AdvancedSearch->ToJson(), ","); // Field pblk_status
		$sFilterList = ew_Concat($sFilterList, $this->pblk_name->AdvancedSearch->ToJson(), ","); // Field pblk_name
		$sFilterList = ew_Concat($sFilterList, $this->pblk_bgcolor->AdvancedSearch->ToJson(), ","); // Field pblk_bgcolor
		$sFilterList = ew_Concat($sFilterList, $this->pblk_stext->AdvancedSearch->ToJson(), ","); // Field pblk_stext
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fcpy_page_blocklistsrch", $filters);

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

		// Field page_id
		$this->page_id->AdvancedSearch->SearchValue = @$filter["x_page_id"];
		$this->page_id->AdvancedSearch->SearchOperator = @$filter["z_page_id"];
		$this->page_id->AdvancedSearch->SearchCondition = @$filter["v_page_id"];
		$this->page_id->AdvancedSearch->SearchValue2 = @$filter["y_page_id"];
		$this->page_id->AdvancedSearch->SearchOperator2 = @$filter["w_page_id"];
		$this->page_id->AdvancedSearch->Save();

		// Field blk_id
		$this->blk_id->AdvancedSearch->SearchValue = @$filter["x_blk_id"];
		$this->blk_id->AdvancedSearch->SearchOperator = @$filter["z_blk_id"];
		$this->blk_id->AdvancedSearch->SearchCondition = @$filter["v_blk_id"];
		$this->blk_id->AdvancedSearch->SearchValue2 = @$filter["y_blk_id"];
		$this->blk_id->AdvancedSearch->SearchOperator2 = @$filter["w_blk_id"];
		$this->blk_id->AdvancedSearch->Save();

		// Field pblk_order
		$this->pblk_order->AdvancedSearch->SearchValue = @$filter["x_pblk_order"];
		$this->pblk_order->AdvancedSearch->SearchOperator = @$filter["z_pblk_order"];
		$this->pblk_order->AdvancedSearch->SearchCondition = @$filter["v_pblk_order"];
		$this->pblk_order->AdvancedSearch->SearchValue2 = @$filter["y_pblk_order"];
		$this->pblk_order->AdvancedSearch->SearchOperator2 = @$filter["w_pblk_order"];
		$this->pblk_order->AdvancedSearch->Save();

		// Field pblk_status
		$this->pblk_status->AdvancedSearch->SearchValue = @$filter["x_pblk_status"];
		$this->pblk_status->AdvancedSearch->SearchOperator = @$filter["z_pblk_status"];
		$this->pblk_status->AdvancedSearch->SearchCondition = @$filter["v_pblk_status"];
		$this->pblk_status->AdvancedSearch->SearchValue2 = @$filter["y_pblk_status"];
		$this->pblk_status->AdvancedSearch->SearchOperator2 = @$filter["w_pblk_status"];
		$this->pblk_status->AdvancedSearch->Save();

		// Field pblk_name
		$this->pblk_name->AdvancedSearch->SearchValue = @$filter["x_pblk_name"];
		$this->pblk_name->AdvancedSearch->SearchOperator = @$filter["z_pblk_name"];
		$this->pblk_name->AdvancedSearch->SearchCondition = @$filter["v_pblk_name"];
		$this->pblk_name->AdvancedSearch->SearchValue2 = @$filter["y_pblk_name"];
		$this->pblk_name->AdvancedSearch->SearchOperator2 = @$filter["w_pblk_name"];
		$this->pblk_name->AdvancedSearch->Save();

		// Field pblk_bgcolor
		$this->pblk_bgcolor->AdvancedSearch->SearchValue = @$filter["x_pblk_bgcolor"];
		$this->pblk_bgcolor->AdvancedSearch->SearchOperator = @$filter["z_pblk_bgcolor"];
		$this->pblk_bgcolor->AdvancedSearch->SearchCondition = @$filter["v_pblk_bgcolor"];
		$this->pblk_bgcolor->AdvancedSearch->SearchValue2 = @$filter["y_pblk_bgcolor"];
		$this->pblk_bgcolor->AdvancedSearch->SearchOperator2 = @$filter["w_pblk_bgcolor"];
		$this->pblk_bgcolor->AdvancedSearch->Save();

		// Field pblk_stext
		$this->pblk_stext->AdvancedSearch->SearchValue = @$filter["x_pblk_stext"];
		$this->pblk_stext->AdvancedSearch->SearchOperator = @$filter["z_pblk_stext"];
		$this->pblk_stext->AdvancedSearch->SearchCondition = @$filter["v_pblk_stext"];
		$this->pblk_stext->AdvancedSearch->SearchValue2 = @$filter["y_pblk_stext"];
		$this->pblk_stext->AdvancedSearch->SearchOperator2 = @$filter["w_pblk_stext"];
		$this->pblk_stext->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->page_id, $Default, FALSE); // page_id
		$this->BuildSearchSql($sWhere, $this->blk_id, $Default, FALSE); // blk_id
		$this->BuildSearchSql($sWhere, $this->pblk_order, $Default, FALSE); // pblk_order
		$this->BuildSearchSql($sWhere, $this->pblk_status, $Default, FALSE); // pblk_status
		$this->BuildSearchSql($sWhere, $this->pblk_name, $Default, FALSE); // pblk_name
		$this->BuildSearchSql($sWhere, $this->pblk_bgcolor, $Default, FALSE); // pblk_bgcolor
		$this->BuildSearchSql($sWhere, $this->pblk_stext, $Default, FALSE); // pblk_stext

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->page_id->AdvancedSearch->Save(); // page_id
			$this->blk_id->AdvancedSearch->Save(); // blk_id
			$this->pblk_order->AdvancedSearch->Save(); // pblk_order
			$this->pblk_status->AdvancedSearch->Save(); // pblk_status
			$this->pblk_name->AdvancedSearch->Save(); // pblk_name
			$this->pblk_bgcolor->AdvancedSearch->Save(); // pblk_bgcolor
			$this->pblk_stext->AdvancedSearch->Save(); // pblk_stext
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
		$this->BuildBasicSearchSQL($sWhere, $this->pblk_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pblk_bgcolor, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pblk_stext, $arKeywords, $type);
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
		if ($this->page_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->blk_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pblk_order->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pblk_status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pblk_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pblk_bgcolor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pblk_stext->AdvancedSearch->IssetSession())
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
		$this->page_id->AdvancedSearch->UnsetSession();
		$this->blk_id->AdvancedSearch->UnsetSession();
		$this->pblk_order->AdvancedSearch->UnsetSession();
		$this->pblk_status->AdvancedSearch->UnsetSession();
		$this->pblk_name->AdvancedSearch->UnsetSession();
		$this->pblk_bgcolor->AdvancedSearch->UnsetSession();
		$this->pblk_stext->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->page_id->AdvancedSearch->Load();
		$this->blk_id->AdvancedSearch->Load();
		$this->pblk_order->AdvancedSearch->Load();
		$this->pblk_status->AdvancedSearch->Load();
		$this->pblk_name->AdvancedSearch->Load();
		$this->pblk_bgcolor->AdvancedSearch->Load();
		$this->pblk_stext->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->page_id); // page_id
			$this->UpdateSort($this->blk_id); // blk_id
			$this->UpdateSort($this->pblk_order); // pblk_order
			$this->UpdateSort($this->pblk_status); // pblk_status
			$this->UpdateSort($this->pblk_name); // pblk_name
			$this->UpdateSort($this->pblk_bgcolor); // pblk_bgcolor
			$this->UpdateSort($this->pblk_stext); // pblk_stext
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
				$this->page_id->setSort("ASC");
				$this->pblk_order->setSort("ASC");
				$this->blk_id->setSort("ASC");
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->page_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->page_id->setSort("");
				$this->blk_id->setSort("");
				$this->pblk_order->setSort("");
				$this->pblk_status->setSort("");
				$this->pblk_name->setSort("");
				$this->pblk_bgcolor->setSort("");
				$this->pblk_stext->setSort("");
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->pblk_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"cpy_page_block\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "',btn:null});\">" . $Language->Phrase("ViewLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->pblk_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->pblk_id->CurrentValue . "\">";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fcpy_page_blocklist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fcpy_page_blocklistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fcpy_page_blocklistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fcpy_page_blocklist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fcpy_page_blocklistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"cpy_page_blocksrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Search highlight button
		$item = &$this->SearchOptions->Add("searchhighlight");
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewHighlight active\" title=\"" . $Language->Phrase("Highlight") . "\" data-caption=\"" . $Language->Phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fcpy_page_blocklistsrch\" data-name=\"" . $this->HighlightName() . "\">" . $Language->Phrase("HighlightBtn") . "</button>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->pblk_id->CurrentValue = NULL;
		$this->pblk_id->OldValue = $this->pblk_id->CurrentValue;
		$this->page_id->CurrentValue = NULL;
		$this->page_id->OldValue = $this->page_id->CurrentValue;
		$this->blk_id->CurrentValue = NULL;
		$this->blk_id->OldValue = $this->blk_id->CurrentValue;
		$this->pblk_order->CurrentValue = 0;
		$this->pblk_order->OldValue = $this->pblk_order->CurrentValue;
		$this->pblk_status->CurrentValue = 1;
		$this->pblk_status->OldValue = $this->pblk_status->CurrentValue;
		$this->pblk_name->CurrentValue = NULL;
		$this->pblk_name->OldValue = $this->pblk_name->CurrentValue;
		$this->pblk_bgcolor->CurrentValue = NULL;
		$this->pblk_bgcolor->OldValue = $this->pblk_bgcolor->CurrentValue;
		$this->pblk_stext->CurrentValue = NULL;
		$this->pblk_stext->OldValue = $this->pblk_stext->CurrentValue;
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
		// page_id

		$this->page_id->AdvancedSearch->SearchValue = @$_GET["x_page_id"];
		if ($this->page_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->page_id->AdvancedSearch->SearchOperator = @$_GET["z_page_id"];

		// blk_id
		$this->blk_id->AdvancedSearch->SearchValue = @$_GET["x_blk_id"];
		if ($this->blk_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->blk_id->AdvancedSearch->SearchOperator = @$_GET["z_blk_id"];

		// pblk_order
		$this->pblk_order->AdvancedSearch->SearchValue = @$_GET["x_pblk_order"];
		if ($this->pblk_order->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pblk_order->AdvancedSearch->SearchOperator = @$_GET["z_pblk_order"];

		// pblk_status
		$this->pblk_status->AdvancedSearch->SearchValue = @$_GET["x_pblk_status"];
		if ($this->pblk_status->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pblk_status->AdvancedSearch->SearchOperator = @$_GET["z_pblk_status"];

		// pblk_name
		$this->pblk_name->AdvancedSearch->SearchValue = @$_GET["x_pblk_name"];
		if ($this->pblk_name->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pblk_name->AdvancedSearch->SearchOperator = @$_GET["z_pblk_name"];

		// pblk_bgcolor
		$this->pblk_bgcolor->AdvancedSearch->SearchValue = @$_GET["x_pblk_bgcolor"];
		if ($this->pblk_bgcolor->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pblk_bgcolor->AdvancedSearch->SearchOperator = @$_GET["z_pblk_bgcolor"];

		// pblk_stext
		$this->pblk_stext->AdvancedSearch->SearchValue = @$_GET["x_pblk_stext"];
		if ($this->pblk_stext->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pblk_stext->AdvancedSearch->SearchOperator = @$_GET["z_pblk_stext"];
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
		if (!$this->pblk_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->pblk_id->setFormValue($objForm->GetValue("x_pblk_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
			if ($this->Export == "")
				$this->pblk_order->ViewValue = $this->HighlightValue($this->pblk_order);

			// pblk_status
			$this->pblk_status->LinkCustomAttributes = "";
			$this->pblk_status->HrefValue = "";
			$this->pblk_status->TooltipValue = "";

			// pblk_name
			$this->pblk_name->LinkCustomAttributes = "";
			$this->pblk_name->HrefValue = "";
			$this->pblk_name->TooltipValue = "";
			if ($this->Export == "")
				$this->pblk_name->ViewValue = $this->HighlightValue($this->pblk_name);

			// pblk_bgcolor
			$this->pblk_bgcolor->LinkCustomAttributes = "";
			$this->pblk_bgcolor->HrefValue = "";
			$this->pblk_bgcolor->TooltipValue = "";

			// pblk_stext
			$this->pblk_stext->LinkCustomAttributes = "";
			$this->pblk_stext->HrefValue = "";
			$this->pblk_stext->TooltipValue = "";
			if ($this->Export == "")
				$this->pblk_stext->ViewValue = $this->HighlightValue($this->pblk_stext);
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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->page_id->AdvancedSearch->Load();
		$this->blk_id->AdvancedSearch->Load();
		$this->pblk_order->AdvancedSearch->Load();
		$this->pblk_status->AdvancedSearch->Load();
		$this->pblk_name->AdvancedSearch->Load();
		$this->pblk_bgcolor->AdvancedSearch->Load();
		$this->pblk_stext->AdvancedSearch->Load();
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
if (!isset($cpy_page_block_list)) $cpy_page_block_list = new ccpy_page_block_list();

// Page init
$cpy_page_block_list->Page_Init();

// Page main
$cpy_page_block_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_page_block_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fcpy_page_blocklist = new ew_Form("fcpy_page_blocklist", "list");
fcpy_page_blocklist.FormKeyCountName = '<?php echo $cpy_page_block_list->FormKeyCountName ?>';

// Validate form
fcpy_page_blocklist.Validate = function() {
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
	return true;
}

// Form_CustomValidate event
fcpy_page_blocklist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_page_blocklist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_page_blocklist.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_page_blocklist.Lists["x_page_id"].Data = "<?php echo $cpy_page_block_list->page_id->LookupFilterQuery(FALSE, "list") ?>";
fcpy_page_blocklist.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_page_blocklist.Lists["x_blk_id"].Data = "<?php echo $cpy_page_block_list->blk_id->LookupFilterQuery(FALSE, "list") ?>";
fcpy_page_blocklist.Lists["x_pblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blocklist.Lists["x_pblk_status"].Options = <?php echo json_encode($cpy_page_block_list->pblk_status->Options()) ?>;
fcpy_page_blocklist.Lists["x_pblk_bgcolor"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_page_blocklist.Lists["x_pblk_bgcolor"].Options = <?php echo json_encode($cpy_page_block_list->pblk_bgcolor->Options()) ?>;

// Form object for search
var CurrentSearchForm = fcpy_page_blocklistsrch = new ew_Form("fcpy_page_blocklistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($cpy_page_block_list->TotalRecs > 0 && $cpy_page_block_list->ExportOptions->Visible()) { ?>
<?php $cpy_page_block_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($cpy_page_block_list->SearchOptions->Visible()) { ?>
<?php $cpy_page_block_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($cpy_page_block_list->FilterOptions->Visible()) { ?>
<?php $cpy_page_block_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php if (($cpy_page_block->Export == "") || (EW_EXPORT_MASTER_RECORD && $cpy_page_block->Export == "print")) { ?>
<?php
if ($cpy_page_block_list->DbMasterFilter <> "" && $cpy_page_block->getCurrentMasterTable() == "cpy_page") {
	if ($cpy_page_block_list->MasterRecordExists) {
?>
<?php include_once "cpy_pagemaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $cpy_page_block_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_page_block_list->TotalRecs <= 0)
			$cpy_page_block_list->TotalRecs = $cpy_page_block->ListRecordCount();
	} else {
		if (!$cpy_page_block_list->Recordset && ($cpy_page_block_list->Recordset = $cpy_page_block_list->LoadRecordset()))
			$cpy_page_block_list->TotalRecs = $cpy_page_block_list->Recordset->RecordCount();
	}
	$cpy_page_block_list->StartRec = 1;
	if ($cpy_page_block_list->DisplayRecs <= 0 || ($cpy_page_block->Export <> "" && $cpy_page_block->ExportAll)) // Display all records
		$cpy_page_block_list->DisplayRecs = $cpy_page_block_list->TotalRecs;
	if (!($cpy_page_block->Export <> "" && $cpy_page_block->ExportAll))
		$cpy_page_block_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cpy_page_block_list->Recordset = $cpy_page_block_list->LoadRecordset($cpy_page_block_list->StartRec-1, $cpy_page_block_list->DisplayRecs);

	// Set no record found message
	if ($cpy_page_block->CurrentAction == "" && $cpy_page_block_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_page_block_list->setWarningMessage(ew_DeniedMsg());
		if ($cpy_page_block_list->SearchWhere == "0=101")
			$cpy_page_block_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_page_block_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$cpy_page_block_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($cpy_page_block->Export == "" && $cpy_page_block->CurrentAction == "") { ?>
<form name="fcpy_page_blocklistsrch" id="fcpy_page_blocklistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($cpy_page_block_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fcpy_page_blocklistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cpy_page_block">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($cpy_page_block_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($cpy_page_block_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $cpy_page_block_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($cpy_page_block_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($cpy_page_block_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($cpy_page_block_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($cpy_page_block_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $cpy_page_block_list->ShowPageHeader(); ?>
<?php
$cpy_page_block_list->ShowMessage();
?>
<?php if ($cpy_page_block_list->TotalRecs > 0 || $cpy_page_block->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_page_block_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_page_block">
<div class="box-header ewGridUpperPanel">
<?php if ($cpy_page_block->CurrentAction <> "gridadd" && $cpy_page_block->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_page_block_list->Pager)) $cpy_page_block_list->Pager = new cPrevNextPager($cpy_page_block_list->StartRec, $cpy_page_block_list->DisplayRecs, $cpy_page_block_list->TotalRecs, $cpy_page_block_list->AutoHidePager) ?>
<?php if ($cpy_page_block_list->Pager->RecordCount > 0 && $cpy_page_block_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_page_block_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_page_block_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_page_block_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_page_block_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_page_block_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_page_block_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fcpy_page_blocklist" id="fcpy_page_blocklist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_page_block_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_page_block_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_page_block">
<?php if ($cpy_page_block->getCurrentMasterTable() == "cpy_page" && $cpy_page_block->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cpy_page">
<input type="hidden" name="fk_page_id" value="<?php echo $cpy_page_block->page_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_cpy_page_block" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($cpy_page_block_list->TotalRecs > 0 || $cpy_page_block->CurrentAction == "add" || $cpy_page_block->CurrentAction == "copy" || $cpy_page_block->CurrentAction == "gridedit") { ?>
<table id="tbl_cpy_page_blocklist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_page_block_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_page_block_list->RenderListOptions();

// Render list options (header, left)
$cpy_page_block_list->ListOptions->Render("header", "left");
?>
<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->page_id) == "") { ?>
		<th data-name="page_id" class="<?php echo $cpy_page_block->page_id->HeaderCellClass() ?>"><div id="elh_cpy_page_block_page_id" class="cpy_page_block_page_id"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->page_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_id" class="<?php echo $cpy_page_block->page_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_page_block->SortUrl($cpy_page_block->page_id) ?>',1);"><div id="elh_cpy_page_block_page_id" class="cpy_page_block_page_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->page_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->page_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->page_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->blk_id) == "") { ?>
		<th data-name="blk_id" class="<?php echo $cpy_page_block->blk_id->HeaderCellClass() ?>"><div id="elh_cpy_page_block_blk_id" class="cpy_page_block_blk_id"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->blk_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="blk_id" class="<?php echo $cpy_page_block->blk_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_page_block->SortUrl($cpy_page_block->blk_id) ?>',1);"><div id="elh_cpy_page_block_blk_id" class="cpy_page_block_blk_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->blk_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->blk_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->blk_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_order) == "") { ?>
		<th data-name="pblk_order" class="<?php echo $cpy_page_block->pblk_order->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_order" class="<?php echo $cpy_page_block->pblk_order->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_page_block->SortUrl($cpy_page_block->pblk_order) ?>',1);"><div id="elh_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_status) == "") { ?>
		<th data-name="pblk_status" class="<?php echo $cpy_page_block->pblk_status->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_status" class="<?php echo $cpy_page_block->pblk_status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_page_block->SortUrl($cpy_page_block->pblk_status) ?>',1);"><div id="elh_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_name) == "") { ?>
		<th data-name="pblk_name" class="<?php echo $cpy_page_block->pblk_name->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_name" class="<?php echo $cpy_page_block->pblk_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_page_block->SortUrl($cpy_page_block->pblk_name) ?>',1);"><div id="elh_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_bgcolor) == "") { ?>
		<th data-name="pblk_bgcolor" class="<?php echo $cpy_page_block->pblk_bgcolor->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_bgcolor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_bgcolor" class="<?php echo $cpy_page_block->pblk_bgcolor->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_page_block->SortUrl($cpy_page_block->pblk_bgcolor) ?>',1);"><div id="elh_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_bgcolor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_bgcolor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_bgcolor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
	<?php if ($cpy_page_block->SortUrl($cpy_page_block->pblk_stext) == "") { ?>
		<th data-name="pblk_stext" class="<?php echo $cpy_page_block->pblk_stext->HeaderCellClass() ?>"><div id="elh_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext"><div class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_stext->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pblk_stext" class="<?php echo $cpy_page_block->pblk_stext->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cpy_page_block->SortUrl($cpy_page_block->pblk_stext) ?>',1);"><div id="elh_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_block->pblk_stext->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_block->pblk_stext->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_block->pblk_stext->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_page_block_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($cpy_page_block->CurrentAction == "add" || $cpy_page_block->CurrentAction == "copy") {
		$cpy_page_block_list->RowIndex = 0;
		$cpy_page_block_list->KeyCount = $cpy_page_block_list->RowIndex;
		if ($cpy_page_block->CurrentAction == "add")
			$cpy_page_block_list->LoadRowValues();
		if ($cpy_page_block->EventCancelled) // Insert failed
			$cpy_page_block_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$cpy_page_block->ResetAttrs();
		$cpy_page_block->RowAttrs = array_merge($cpy_page_block->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_cpy_page_block', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$cpy_page_block->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_page_block_list->RenderRow();

		// Render list options
		$cpy_page_block_list->RenderListOptions();
		$cpy_page_block_list->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_page_block->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_page_block_list->ListOptions->Render("body", "left", $cpy_page_block_list->RowCnt);
?>
	<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
		<td data-name="page_id">
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="o<?php echo $cpy_page_block_list->RowIndex ?>_page_id" id="o<?php echo $cpy_page_block_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
		<td data-name="blk_id">
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="o<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" id="o<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
		<td data-name="pblk_order">
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
		<td data-name="pblk_status">
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
		<td data-name="pblk_name">
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
		<td data-name="pblk_bgcolor">
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
		<td data-name="pblk_stext">
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_page_block_list->ListOptions->Render("body", "right", $cpy_page_block_list->RowCnt);
?>
<script type="text/javascript">
fcpy_page_blocklist.UpdateOpts(<?php echo $cpy_page_block_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($cpy_page_block->ExportAll && $cpy_page_block->Export <> "") {
	$cpy_page_block_list->StopRec = $cpy_page_block_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cpy_page_block_list->TotalRecs > $cpy_page_block_list->StartRec + $cpy_page_block_list->DisplayRecs - 1)
		$cpy_page_block_list->StopRec = $cpy_page_block_list->StartRec + $cpy_page_block_list->DisplayRecs - 1;
	else
		$cpy_page_block_list->StopRec = $cpy_page_block_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_page_block_list->FormKeyCountName) && ($cpy_page_block->CurrentAction == "gridadd" || $cpy_page_block->CurrentAction == "gridedit" || $cpy_page_block->CurrentAction == "F")) {
		$cpy_page_block_list->KeyCount = $objForm->GetValue($cpy_page_block_list->FormKeyCountName);
		$cpy_page_block_list->StopRec = $cpy_page_block_list->StartRec + $cpy_page_block_list->KeyCount - 1;
	}
}
$cpy_page_block_list->RecCnt = $cpy_page_block_list->StartRec - 1;
if ($cpy_page_block_list->Recordset && !$cpy_page_block_list->Recordset->EOF) {
	$cpy_page_block_list->Recordset->MoveFirst();
	$bSelectLimit = $cpy_page_block_list->UseSelectLimit;
	if (!$bSelectLimit && $cpy_page_block_list->StartRec > 1)
		$cpy_page_block_list->Recordset->Move($cpy_page_block_list->StartRec - 1);
} elseif (!$cpy_page_block->AllowAddDeleteRow && $cpy_page_block_list->StopRec == 0) {
	$cpy_page_block_list->StopRec = $cpy_page_block->GridAddRowCount;
}

// Initialize aggregate
$cpy_page_block->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_page_block->ResetAttrs();
$cpy_page_block_list->RenderRow();
$cpy_page_block_list->EditRowCnt = 0;
if ($cpy_page_block->CurrentAction == "edit")
	$cpy_page_block_list->RowIndex = 1;
if ($cpy_page_block->CurrentAction == "gridedit")
	$cpy_page_block_list->RowIndex = 0;
while ($cpy_page_block_list->RecCnt < $cpy_page_block_list->StopRec) {
	$cpy_page_block_list->RecCnt++;
	if (intval($cpy_page_block_list->RecCnt) >= intval($cpy_page_block_list->StartRec)) {
		$cpy_page_block_list->RowCnt++;
		if ($cpy_page_block->CurrentAction == "gridadd" || $cpy_page_block->CurrentAction == "gridedit" || $cpy_page_block->CurrentAction == "F") {
			$cpy_page_block_list->RowIndex++;
			$objForm->Index = $cpy_page_block_list->RowIndex;
			if ($objForm->HasValue($cpy_page_block_list->FormActionName))
				$cpy_page_block_list->RowAction = strval($objForm->GetValue($cpy_page_block_list->FormActionName));
			elseif ($cpy_page_block->CurrentAction == "gridadd")
				$cpy_page_block_list->RowAction = "insert";
			else
				$cpy_page_block_list->RowAction = "";
		}

		// Set up key count
		$cpy_page_block_list->KeyCount = $cpy_page_block_list->RowIndex;

		// Init row class and style
		$cpy_page_block->ResetAttrs();
		$cpy_page_block->CssClass = "";
		if ($cpy_page_block->CurrentAction == "gridadd") {
			$cpy_page_block_list->LoadRowValues(); // Load default values
		} else {
			$cpy_page_block_list->LoadRowValues($cpy_page_block_list->Recordset); // Load row values
		}
		$cpy_page_block->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_page_block->CurrentAction == "edit") {
			if ($cpy_page_block_list->CheckInlineEditKey() && $cpy_page_block_list->EditRowCnt == 0) { // Inline edit
				$cpy_page_block->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($cpy_page_block->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_page_block->EventCancelled) {
				$cpy_page_block_list->RestoreCurrentRowFormValues($cpy_page_block_list->RowIndex); // Restore form values
			}
			if ($cpy_page_block_list->RowAction == "insert")
				$cpy_page_block->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_page_block->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_page_block->CurrentAction == "edit" && $cpy_page_block->RowType == EW_ROWTYPE_EDIT && $cpy_page_block->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$cpy_page_block_list->RestoreFormValues(); // Restore form values
		}
		if ($cpy_page_block->CurrentAction == "gridedit" && ($cpy_page_block->RowType == EW_ROWTYPE_EDIT || $cpy_page_block->RowType == EW_ROWTYPE_ADD) && $cpy_page_block->EventCancelled) // Update failed
			$cpy_page_block_list->RestoreCurrentRowFormValues($cpy_page_block_list->RowIndex); // Restore form values
		if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_page_block_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cpy_page_block->RowAttrs = array_merge($cpy_page_block->RowAttrs, array('data-rowindex'=>$cpy_page_block_list->RowCnt, 'id'=>'r' . $cpy_page_block_list->RowCnt . '_cpy_page_block', 'data-rowtype'=>$cpy_page_block->RowType));

		// Render row
		$cpy_page_block_list->RenderRow();

		// Render list options
		$cpy_page_block_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_page_block_list->RowAction <> "delete" && $cpy_page_block_list->RowAction <> "insertdelete" && !($cpy_page_block_list->RowAction == "insert" && $cpy_page_block->CurrentAction == "F" && $cpy_page_block_list->EmptyRow())) {
?>
	<tr<?php echo $cpy_page_block->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_page_block_list->ListOptions->Render("body", "left", $cpy_page_block_list->RowCnt);
?>
	<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
		<td data-name="page_id"<?php echo $cpy_page_block->page_id->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="o<?php echo $cpy_page_block_list->RowIndex ?>_page_id" id="o<?php echo $cpy_page_block_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_page_id" class="cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<?php echo $cpy_page_block->page_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_id" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_id" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_id" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT || $cpy_page_block->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_id" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
		<td data-name="blk_id"<?php echo $cpy_page_block->blk_id->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="o<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" id="o<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_blk_id" class="cpy_page_block_blk_id">
<span<?php echo $cpy_page_block->blk_id->ViewAttributes() ?>>
<?php echo $cpy_page_block->blk_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
		<td data-name="pblk_order"<?php echo $cpy_page_block->pblk_order->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_order" class="cpy_page_block_pblk_order">
<span<?php echo $cpy_page_block->pblk_order->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_order->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
		<td data-name="pblk_status"<?php echo $cpy_page_block->pblk_status->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_status" class="cpy_page_block_pblk_status">
<span<?php echo $cpy_page_block->pblk_status->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
		<td data-name="pblk_name"<?php echo $cpy_page_block->pblk_name->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_name" class="cpy_page_block_pblk_name">
<span<?php echo $cpy_page_block->pblk_name->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_name->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
		<td data-name="pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor") ?>
</select>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_bgcolor" class="cpy_page_block_pblk_bgcolor">
<span<?php echo $cpy_page_block->pblk_bgcolor->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
		<td data-name="pblk_stext"<?php echo $cpy_page_block->pblk_stext->CellAttributes() ?>>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_block_list->RowCnt ?>_cpy_page_block_pblk_stext" class="cpy_page_block_pblk_stext">
<span<?php echo $cpy_page_block->pblk_stext->ViewAttributes() ?>>
<?php echo $cpy_page_block->pblk_stext->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_page_block_list->ListOptions->Render("body", "right", $cpy_page_block_list->RowCnt);
?>
	</tr>
<?php if ($cpy_page_block->RowType == EW_ROWTYPE_ADD || $cpy_page_block->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_page_blocklist.UpdateOpts(<?php echo $cpy_page_block_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_page_block->CurrentAction <> "gridadd")
		if (!$cpy_page_block_list->Recordset->EOF) $cpy_page_block_list->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_page_block->CurrentAction == "gridadd" || $cpy_page_block->CurrentAction == "gridedit") {
		$cpy_page_block_list->RowIndex = '$rowindex$';
		$cpy_page_block_list->LoadRowValues();

		// Set row properties
		$cpy_page_block->ResetAttrs();
		$cpy_page_block->RowAttrs = array_merge($cpy_page_block->RowAttrs, array('data-rowindex'=>$cpy_page_block_list->RowIndex, 'id'=>'r0_cpy_page_block', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_page_block->RowAttrs["class"], "ewTemplate");
		$cpy_page_block->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_page_block_list->RenderRow();

		// Render list options
		$cpy_page_block_list->RenderListOptions();
		$cpy_page_block_list->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_page_block->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_page_block_list->ListOptions->Render("body", "left", $cpy_page_block_list->RowIndex);
?>
	<?php if ($cpy_page_block->page_id->Visible) { // page_id ?>
		<td data-name="page_id">
<?php if ($cpy_page_block->page_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<span<?php echo $cpy_page_block->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_block->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_page_block_page_id" class="form-group cpy_page_block_page_id">
<select data-table="cpy_page_block" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_block->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id" name="x<?php echo $cpy_page_block_list->RowIndex ?>_page_id"<?php echo $cpy_page_block->page_id->EditAttributes() ?>>
<?php echo $cpy_page_block->page_id->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_page_block" data-field="x_page_id" name="o<?php echo $cpy_page_block_list->RowIndex ?>_page_id" id="o<?php echo $cpy_page_block_list->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_block->page_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->blk_id->Visible) { // blk_id ?>
		<td data-name="blk_id">
<span id="el$rowindex$_cpy_page_block_blk_id" class="form-group cpy_page_block_blk_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id"><?php echo (strval($cpy_page_block->blk_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $cpy_page_block->blk_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($cpy_page_block->blk_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $cpy_page_block->blk_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" id="x<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" value="<?php echo $cpy_page_block->blk_id->CurrentValue ?>"<?php echo $cpy_page_block->blk_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_blk_id" name="o<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" id="o<?php echo $cpy_page_block_list->RowIndex ?>_blk_id" value="<?php echo ew_HtmlEncode($cpy_page_block->blk_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_order->Visible) { // pblk_order ?>
		<td data-name="pblk_order">
<span id="el$rowindex$_cpy_page_block_pblk_order" class="form-group cpy_page_block_pblk_order">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_order" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_order->EditValue ?>"<?php echo $cpy_page_block->pblk_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_order" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_order" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_status->Visible) { // pblk_status ?>
		<td data-name="pblk_status">
<span id="el$rowindex$_cpy_page_block_pblk_status" class="form-group cpy_page_block_pblk_status">
<select data-table="cpy_page_block" data-field="x_pblk_status" data-value-separator="<?php echo $cpy_page_block->pblk_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status"<?php echo $cpy_page_block->pblk_status->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_status->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_status" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_status" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_name->Visible) { // pblk_name ?>
		<td data-name="pblk_name">
<span id="el$rowindex$_cpy_page_block_pblk_name" class="form-group cpy_page_block_pblk_name">
<input type="text" data-table="cpy_page_block" data-field="x_pblk_name" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_page_block->pblk_name->EditValue ?>"<?php echo $cpy_page_block->pblk_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_name" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_name" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_bgcolor->Visible) { // pblk_bgcolor ?>
		<td data-name="pblk_bgcolor">
<span id="el$rowindex$_cpy_page_block_pblk_bgcolor" class="form-group cpy_page_block_pblk_bgcolor">
<select data-table="cpy_page_block" data-field="x_pblk_bgcolor" data-value-separator="<?php echo $cpy_page_block->pblk_bgcolor->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor"<?php echo $cpy_page_block->pblk_bgcolor->EditAttributes() ?>>
<?php echo $cpy_page_block->pblk_bgcolor->SelectOptionListHtml("x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor") ?>
</select>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_bgcolor" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_bgcolor" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_bgcolor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_block->pblk_stext->Visible) { // pblk_stext ?>
		<td data-name="pblk_stext">
<span id="el$rowindex$_cpy_page_block_pblk_stext" class="form-group cpy_page_block_pblk_stext">
<textarea data-table="cpy_page_block" data-field="x_pblk_stext" name="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" id="x<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->getPlaceHolder()) ?>"<?php echo $cpy_page_block->pblk_stext->EditAttributes() ?>><?php echo $cpy_page_block->pblk_stext->EditValue ?></textarea>
</span>
<input type="hidden" data-table="cpy_page_block" data-field="x_pblk_stext" name="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" id="o<?php echo $cpy_page_block_list->RowIndex ?>_pblk_stext" value="<?php echo ew_HtmlEncode($cpy_page_block->pblk_stext->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_page_block_list->ListOptions->Render("body", "right", $cpy_page_block_list->RowCnt);
?>
<script type="text/javascript">
fcpy_page_blocklist.UpdateOpts(<?php echo $cpy_page_block_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cpy_page_block->CurrentAction == "add" || $cpy_page_block->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $cpy_page_block_list->FormKeyCountName ?>" id="<?php echo $cpy_page_block_list->FormKeyCountName ?>" value="<?php echo $cpy_page_block_list->KeyCount ?>">
<?php } ?>
<?php if ($cpy_page_block->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $cpy_page_block_list->FormKeyCountName ?>" id="<?php echo $cpy_page_block_list->FormKeyCountName ?>" value="<?php echo $cpy_page_block_list->KeyCount ?>">
<?php } ?>
<?php if ($cpy_page_block->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_page_block_list->FormKeyCountName ?>" id="<?php echo $cpy_page_block_list->FormKeyCountName ?>" value="<?php echo $cpy_page_block_list->KeyCount ?>">
<?php echo $cpy_page_block_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_page_block->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cpy_page_block_list->Recordset)
	$cpy_page_block_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($cpy_page_block->CurrentAction <> "gridadd" && $cpy_page_block->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_page_block_list->Pager)) $cpy_page_block_list->Pager = new cPrevNextPager($cpy_page_block_list->StartRec, $cpy_page_block_list->DisplayRecs, $cpy_page_block_list->TotalRecs, $cpy_page_block_list->AutoHidePager) ?>
<?php if ($cpy_page_block_list->Pager->RecordCount > 0 && $cpy_page_block_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_page_block_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_page_block_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_page_block_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_page_block_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_page_block_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_page_block_list->PageUrl() ?>start=<?php echo $cpy_page_block_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cpy_page_block_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_page_block_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($cpy_page_block_list->TotalRecs == 0 && $cpy_page_block->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_page_block_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fcpy_page_blocklistsrch.FilterList = <?php echo $cpy_page_block_list->GetFilterList() ?>;
fcpy_page_blocklistsrch.Init();
fcpy_page_blocklist.Init();
</script>
<?php
$cpy_page_block_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_page_block_list->Page_Terminate();
?>
