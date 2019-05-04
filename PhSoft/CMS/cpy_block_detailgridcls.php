<?php include_once "cpy_block_detailinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php

//
// Page class
//

$cpy_block_detail_grid = NULL; // Initialize page object first

class ccpy_block_detail_grid extends ccpy_block_detail {

	// Page ID
	var $PageID = 'gridcls';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_block_detail';

	// Page object name
	var $PageObjName = 'cpy_block_detail_grid';

	// Grid form hidden field names
	var $FormName = 'fcpy_block_detailgrid';
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
		$this->FormActionName .= '_' . $this->FormName;
		$this->FormKeyName .= '_' . $this->FormName;
		$this->FormOldKeyName .= '_' . $this->FormName;
		$this->FormBlankRowName .= '_' . $this->FormName;
		$this->FormKeyCountName .= '_' . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (cpy_block_detail)
		if (!isset($GLOBALS["cpy_block_detail"]) || get_class($GLOBALS["cpy_block_detail"]) == "ccpy_block_detail") {
			$GLOBALS["cpy_block_detail"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["cpy_block_detail"];

		}
		$this->AddUrl = "cpy_block_detailadd.php";

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'gridcls', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
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
		// Get grid add count

		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->blk_id->SetVisibility();
		$this->dblk_order->SetVisibility();
		$this->dblk_type->SetVisibility();
		$this->dblk_status->SetVisibility();
		$this->dblk_name->SetVisibility();
		$this->dblk_image->SetVisibility();
		$this->dblk_stext->SetVisibility();

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
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url == "")
			return;
		$this->Page_Redirecting($url);

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
	var $ShowOtherOptions = FALSE;
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

			// Handle reset command
			$this->ResetCmd();

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetupSortOrder();
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cpy_block") {
			global $cpy_block;
			$rsmaster = $cpy_block->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cpy_blocklist.php"); // Return to master page
			} else {
				$cpy_block->LoadListRowValues($rsmaster);
				$cpy_block->RowType = EW_ROWTYPE_MASTER; // Master row
				$cpy_block->RenderListRow();
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
	}

	// Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
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

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
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
			$this->dblk_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->dblk_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
				$this->LoadOldRecord(); // Load old record
			}
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->dblk_id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_blk_id") && $objForm->HasValue("o_blk_id") && $this->blk_id->CurrentValue <> $this->blk_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_dblk_order") && $objForm->HasValue("o_dblk_order") && $this->dblk_order->CurrentValue <> $this->dblk_order->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_dblk_type") && $objForm->HasValue("o_dblk_type") && $this->dblk_type->CurrentValue <> $this->dblk_type->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_dblk_status") && $objForm->HasValue("o_dblk_status") && $this->dblk_status->CurrentValue <> $this->dblk_status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_dblk_name") && $objForm->HasValue("o_dblk_name") && $this->dblk_name->CurrentValue <> $this->dblk_name->OldValue)
			return FALSE;
		if (!ew_Empty($this->dblk_image->Upload->Value))
			return FALSE;
		if ($objForm->HasValue("x_dblk_stext") && $objForm->HasValue("o_dblk_stext") && $this->dblk_stext->CurrentValue <> $this->dblk_stext->OldValue)
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

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
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
				$this->blk_id->setSort("DESC");
				$this->dblk_order->setSort("ASC");
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->blk_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
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

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($objForm->HasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $OldKeyName . "\" id=\"" . $OldKeyName . "\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
		if ($this->CurrentMode == "view") { // View mode

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"cpy_block_detail\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "',btn:null});\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
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
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->dblk_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('dblk_id');
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;
		$option->ButtonClass = "btn-sm"; // Class for button group
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->Add("add");
			$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
			$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
			$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		}
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && $this->CurrentAction != "F") { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				$item = &$option->Add("addblankrow");
				$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
				$item->Visible = $Security->CanAdd();
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = &$options["addedit"];
			$item = &$option->GetItem("add");
			$this->ShowOtherOptions = $item && $item->Visible;
		}
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
		$this->dblk_order->OldValue = $this->dblk_order->CurrentValue;
		$this->dblk_type->CurrentValue = 1;
		$this->dblk_type->OldValue = $this->dblk_type->CurrentValue;
		$this->dblk_status->CurrentValue = 1;
		$this->dblk_status->OldValue = $this->dblk_status->CurrentValue;
		$this->dblk_name->CurrentValue = NULL;
		$this->dblk_name->OldValue = $this->dblk_name->CurrentValue;
		$this->dblk_image->Upload->DbValue = NULL;
		$this->dblk_image->OldValue = $this->dblk_image->Upload->DbValue;
		$this->dblk_image->Upload->Index = $this->RowIndex;
		$this->dblk_stext->CurrentValue = NULL;
		$this->dblk_stext->OldValue = $this->dblk_stext->CurrentValue;
		$this->dblk_text->CurrentValue = NULL;
		$this->dblk_text->OldValue = $this->dblk_text->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$objForm->FormName = $this->FormName;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->blk_id->FldIsDetailKey) {
			$this->blk_id->setFormValue($objForm->GetValue("x_blk_id"));
		}
		$this->blk_id->setOldValue($objForm->GetValue("o_blk_id"));
		if (!$this->dblk_order->FldIsDetailKey) {
			$this->dblk_order->setFormValue($objForm->GetValue("x_dblk_order"));
		}
		$this->dblk_order->setOldValue($objForm->GetValue("o_dblk_order"));
		if (!$this->dblk_type->FldIsDetailKey) {
			$this->dblk_type->setFormValue($objForm->GetValue("x_dblk_type"));
		}
		$this->dblk_type->setOldValue($objForm->GetValue("o_dblk_type"));
		if (!$this->dblk_status->FldIsDetailKey) {
			$this->dblk_status->setFormValue($objForm->GetValue("x_dblk_status"));
		}
		$this->dblk_status->setOldValue($objForm->GetValue("o_dblk_status"));
		if (!$this->dblk_name->FldIsDetailKey) {
			$this->dblk_name->setFormValue($objForm->GetValue("x_dblk_name"));
		}
		$this->dblk_name->setOldValue($objForm->GetValue("o_dblk_name"));
		if (!$this->dblk_stext->FldIsDetailKey) {
			$this->dblk_stext->setFormValue($objForm->GetValue("x_dblk_stext"));
		}
		$this->dblk_stext->setOldValue($objForm->GetValue("o_dblk_stext"));
		if (!$this->dblk_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->dblk_id->setFormValue($objForm->GetValue("x_dblk_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->dblk_id->CurrentValue = $this->dblk_id->FormValue;
		$this->blk_id->CurrentValue = $this->blk_id->FormValue;
		$this->dblk_order->CurrentValue = $this->dblk_order->FormValue;
		$this->dblk_type->CurrentValue = $this->dblk_type->FormValue;
		$this->dblk_status->CurrentValue = $this->dblk_status->FormValue;
		$this->dblk_name->CurrentValue = $this->dblk_name->FormValue;
		$this->dblk_stext->CurrentValue = $this->dblk_stext->FormValue;
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
		$this->dblk_id->setDbValue($row['dblk_id']);
		$this->blk_id->setDbValue($row['blk_id']);
		$this->dblk_order->setDbValue($row['dblk_order']);
		$this->dblk_type->setDbValue($row['dblk_type']);
		$this->dblk_status->setDbValue($row['dblk_status']);
		$this->dblk_name->setDbValue($row['dblk_name']);
		$this->dblk_image->Upload->DbValue = $row['dblk_image'];
		$this->dblk_image->CurrentValue = $this->dblk_image->Upload->DbValue;
		$this->dblk_image->Upload->Index = $this->RowIndex;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->dblk_id->CurrentValue = strval($arKeys[0]); // dblk_id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// dblk_id

		$this->dblk_id->CellCssStyle = "white-space: nowrap;";

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

			// blk_id
			$this->blk_id->LinkCustomAttributes = "";
			$this->blk_id->HrefValue = "";
			$this->blk_id->TooltipValue = "";

			// dblk_order
			$this->dblk_order->LinkCustomAttributes = "";
			$this->dblk_order->HrefValue = "";
			$this->dblk_order->TooltipValue = "";
			if ($this->Export == "")
				$this->dblk_order->ViewValue = $this->HighlightValue($this->dblk_order);

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
			if ($this->Export == "")
				$this->dblk_name->ViewValue = $this->HighlightValue($this->dblk_name);

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
				$this->dblk_image->LinkAttrs["data-rel"] = "cpy_block_detail_x" . $this->RowCnt . "_dblk_image";
				ew_AppendClass($this->dblk_image->LinkAttrs["class"], "ewLightbox");
			}

			// dblk_stext
			$this->dblk_stext->LinkCustomAttributes = "";
			$this->dblk_stext->HrefValue = "";
			$this->dblk_stext->TooltipValue = "";
			if ($this->Export == "")
				$this->dblk_stext->ViewValue = $this->HighlightValue($this->dblk_stext);
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// blk_id
			$this->blk_id->EditAttrs["class"] = "form-control";
			$this->blk_id->EditCustomAttributes = "";
			if ($this->blk_id->getSessionValue() <> "") {
				$this->blk_id->CurrentValue = $this->blk_id->getSessionValue();
				$this->blk_id->OldValue = $this->blk_id->CurrentValue;
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
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->dblk_image, $this->RowIndex);

			// dblk_stext
			$this->dblk_stext->EditAttrs["class"] = "form-control";
			$this->dblk_stext->EditCustomAttributes = "";
			$this->dblk_stext->EditValue = ew_HtmlEncode($this->dblk_stext->CurrentValue);
			$this->dblk_stext->PlaceHolder = ew_RemoveHtml($this->dblk_stext->FldCaption());

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// blk_id
			$this->blk_id->EditAttrs["class"] = "form-control";
			$this->blk_id->EditCustomAttributes = "";
			if ($this->blk_id->getSessionValue() <> "") {
				$this->blk_id->CurrentValue = $this->blk_id->getSessionValue();
				$this->blk_id->OldValue = $this->blk_id->CurrentValue;
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
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->dblk_image, $this->RowIndex);

			// dblk_stext
			$this->dblk_stext->EditAttrs["class"] = "form-control";
			$this->dblk_stext->EditCustomAttributes = "";
			$this->dblk_stext->EditValue = ew_HtmlEncode($this->dblk_stext->CurrentValue);
			$this->dblk_stext->PlaceHolder = ew_RemoveHtml($this->dblk_stext->FldCaption());

			// Edit refer script
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
				$sThisKey .= $row['dblk_id'];
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
			$this->dblk_image->OldUploadPath = '../../assets/img/blkImages/';
			$this->dblk_image->UploadPath = $this->dblk_image->OldUploadPath;
			$rsnew = array();

			// blk_id
			$this->blk_id->SetDbValueDef($rsnew, $this->blk_id->CurrentValue, 0, $this->blk_id->ReadOnly);

			// dblk_order
			$this->dblk_order->SetDbValueDef($rsnew, $this->dblk_order->CurrentValue, 0, $this->dblk_order->ReadOnly);

			// dblk_type
			$this->dblk_type->SetDbValueDef($rsnew, $this->dblk_type->CurrentValue, 0, $this->dblk_type->ReadOnly);

			// dblk_status
			$this->dblk_status->SetDbValueDef($rsnew, $this->dblk_status->CurrentValue, 0, $this->dblk_status->ReadOnly);

			// dblk_name
			$this->dblk_name->SetDbValueDef($rsnew, $this->dblk_name->CurrentValue, "", $this->dblk_name->ReadOnly);

			// dblk_image
			if ($this->dblk_image->Visible && !$this->dblk_image->ReadOnly && !$this->dblk_image->Upload->KeepFile) {
				$this->dblk_image->Upload->DbValue = $rsold['dblk_image']; // Get original value
				if ($this->dblk_image->Upload->FileName == "") {
					$rsnew['dblk_image'] = NULL;
				} else {
					$rsnew['dblk_image'] = $this->dblk_image->Upload->FileName;
				}
			}

			// dblk_stext
			$this->dblk_stext->SetDbValueDef($rsnew, $this->dblk_stext->CurrentValue, NULL, $this->dblk_stext->ReadOnly);
			if ($this->dblk_image->Visible && !$this->dblk_image->Upload->KeepFile) {
				$this->dblk_image->UploadPath = '../../assets/img/blkImages/';
				if (!ew_Empty($this->dblk_image->Upload->Value)) {
					$rsnew['dblk_image'] = ew_UploadFileNameEx($this->dblk_image->PhysicalUploadPath(), $rsnew['dblk_image']); // Get new file name
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
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// dblk_image
		ew_CleanUploadTempPath($this->dblk_image, $this->dblk_image->Upload->Index);
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "cpy_block") {
				$this->blk_id->CurrentValue = $this->blk_id->getSessionValue();
			}
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

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "cpy_block") {
			$this->blk_id->Visible = FALSE;
			if ($GLOBALS["cpy_block"]->EventCancelled) $this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
