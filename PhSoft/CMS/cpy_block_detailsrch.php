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

$cpy_block_detail_search = NULL; // Initialize page object first

class ccpy_block_detail_search extends ccpy_block_detail {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_block_detail';

	// Page object name
	var $PageObjName = 'cpy_block_detail_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "cpy_block_detaillist.php" . "?" . $sSrchStr;
						$this->Page_Terminate($sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->blk_id); // blk_id
		$this->BuildSearchUrl($sSrchUrl, $this->dblk_order); // dblk_order
		$this->BuildSearchUrl($sSrchUrl, $this->dblk_type); // dblk_type
		$this->BuildSearchUrl($sSrchUrl, $this->dblk_status); // dblk_status
		$this->BuildSearchUrl($sSrchUrl, $this->dblk_name); // dblk_name
		$this->BuildSearchUrl($sSrchUrl, $this->dblk_image); // dblk_image
		$this->BuildSearchUrl($sSrchUrl, $this->dblk_stext); // dblk_stext
		$this->BuildSearchUrl($sSrchUrl, $this->dblk_text); // dblk_text
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = $Fld->FldParm();
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = $FldVal;
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $FldVal2;
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// blk_id

		$this->blk_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_blk_id");
		$this->blk_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_blk_id");

		// dblk_order
		$this->dblk_order->AdvancedSearch->SearchValue = $objForm->GetValue("x_dblk_order");
		$this->dblk_order->AdvancedSearch->SearchOperator = $objForm->GetValue("z_dblk_order");

		// dblk_type
		$this->dblk_type->AdvancedSearch->SearchValue = $objForm->GetValue("x_dblk_type");
		$this->dblk_type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_dblk_type");

		// dblk_status
		$this->dblk_status->AdvancedSearch->SearchValue = $objForm->GetValue("x_dblk_status");
		$this->dblk_status->AdvancedSearch->SearchOperator = $objForm->GetValue("z_dblk_status");

		// dblk_name
		$this->dblk_name->AdvancedSearch->SearchValue = $objForm->GetValue("x_dblk_name");
		$this->dblk_name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_dblk_name");

		// dblk_image
		$this->dblk_image->AdvancedSearch->SearchValue = $objForm->GetValue("x_dblk_image");
		$this->dblk_image->AdvancedSearch->SearchOperator = $objForm->GetValue("z_dblk_image");

		// dblk_stext
		$this->dblk_stext->AdvancedSearch->SearchValue = $objForm->GetValue("x_dblk_stext");
		$this->dblk_stext->AdvancedSearch->SearchOperator = $objForm->GetValue("z_dblk_stext");

		// dblk_text
		$this->dblk_text->AdvancedSearch->SearchValue = $objForm->GetValue("x_dblk_text");
		$this->dblk_text->AdvancedSearch->SearchOperator = $objForm->GetValue("z_dblk_text");
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// blk_id
			$this->blk_id->EditAttrs["class"] = "form-control";
			$this->blk_id->EditCustomAttributes = "";
			if (trim(strval($this->blk_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`blk_id`" . ew_SearchString("=", $this->blk_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
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

			// dblk_order
			$this->dblk_order->EditAttrs["class"] = "form-control";
			$this->dblk_order->EditCustomAttributes = "";
			$this->dblk_order->EditValue = ew_HtmlEncode($this->dblk_order->AdvancedSearch->SearchValue);
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
			$this->dblk_name->EditValue = ew_HtmlEncode($this->dblk_name->AdvancedSearch->SearchValue);
			$this->dblk_name->PlaceHolder = ew_RemoveHtml($this->dblk_name->FldCaption());

			// dblk_image
			$this->dblk_image->EditAttrs["class"] = "form-control";
			$this->dblk_image->EditCustomAttributes = "";
			$this->dblk_image->EditValue = ew_HtmlEncode($this->dblk_image->AdvancedSearch->SearchValue);
			$this->dblk_image->PlaceHolder = ew_RemoveHtml($this->dblk_image->FldCaption());

			// dblk_stext
			$this->dblk_stext->EditAttrs["class"] = "form-control";
			$this->dblk_stext->EditCustomAttributes = "";
			$this->dblk_stext->EditValue = ew_HtmlEncode($this->dblk_stext->AdvancedSearch->SearchValue);
			$this->dblk_stext->PlaceHolder = ew_RemoveHtml($this->dblk_stext->FldCaption());

			// dblk_text
			$this->dblk_text->EditAttrs["class"] = "form-control";
			$this->dblk_text->EditCustomAttributes = "";
			$this->dblk_text->EditValue = ew_HtmlEncode($this->dblk_text->AdvancedSearch->SearchValue);
			$this->dblk_text->PlaceHolder = ew_RemoveHtml($this->dblk_text->FldCaption());
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
		if (!ew_CheckInteger($this->dblk_order->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->dblk_order->FldErrMsg());
		}

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->blk_id->AdvancedSearch->Load();
		$this->dblk_order->AdvancedSearch->Load();
		$this->dblk_type->AdvancedSearch->Load();
		$this->dblk_status->AdvancedSearch->Load();
		$this->dblk_name->AdvancedSearch->Load();
		$this->dblk_image->AdvancedSearch->Load();
		$this->dblk_stext->AdvancedSearch->Load();
		$this->dblk_text->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_block_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($cpy_block_detail_search)) $cpy_block_detail_search = new ccpy_block_detail_search();

// Page init
$cpy_block_detail_search->Page_Init();

// Page main
$cpy_block_detail_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_block_detail_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($cpy_block_detail_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fcpy_block_detailsearch = new ew_Form("fcpy_block_detailsearch", "search");
<?php } else { ?>
var CurrentForm = fcpy_block_detailsearch = new ew_Form("fcpy_block_detailsearch", "search");
<?php } ?>

// Form_CustomValidate event
fcpy_block_detailsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_block_detailsearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_block_detailsearch.Lists["x_blk_id"] = {"LinkField":"x_blk_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_blk_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_block"};
fcpy_block_detailsearch.Lists["x_blk_id"].Data = "<?php echo $cpy_block_detail_search->blk_id->LookupFilterQuery(FALSE, "search") ?>";
fcpy_block_detailsearch.Lists["x_dblk_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_block_detailsearch.Lists["x_dblk_type"].Options = <?php echo json_encode($cpy_block_detail_search->dblk_type->Options()) ?>;
fcpy_block_detailsearch.Lists["x_dblk_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_block_detailsearch.Lists["x_dblk_status"].Options = <?php echo json_encode($cpy_block_detail_search->dblk_status->Options()) ?>;

// Form object for search
// Validate function for search

fcpy_block_detailsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_dblk_order");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_block_detail->dblk_order->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_block_detail_search->ShowPageHeader(); ?>
<?php
$cpy_block_detail_search->ShowMessage();
?>
<form name="fcpy_block_detailsearch" id="fcpy_block_detailsearch" class="<?php echo $cpy_block_detail_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_block_detail_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_block_detail_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_block_detail">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($cpy_block_detail_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($cpy_block_detail->blk_id->Visible) { // blk_id ?>
	<div id="r_blk_id" class="form-group">
		<label for="x_blk_id" class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_blk_id"><?php echo $cpy_block_detail->blk_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_blk_id" id="z_blk_id" value="="></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->blk_id->CellAttributes() ?>>
			<span id="el_cpy_block_detail_blk_id">
<select data-table="cpy_block_detail" data-field="x_blk_id" data-value-separator="<?php echo $cpy_block_detail->blk_id->DisplayValueSeparatorAttribute() ?>" id="x_blk_id" name="x_blk_id"<?php echo $cpy_block_detail->blk_id->EditAttributes() ?>>
<?php echo $cpy_block_detail->blk_id->SelectOptionListHtml("x_blk_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_order->Visible) { // dblk_order ?>
	<div id="r_dblk_order" class="form-group">
		<label for="x_dblk_order" class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_dblk_order"><?php echo $cpy_block_detail->dblk_order->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_dblk_order" id="z_dblk_order" value="="></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_order->CellAttributes() ?>>
			<span id="el_cpy_block_detail_dblk_order">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_order" name="x_dblk_order" id="x_dblk_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_order->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_order->EditValue ?>"<?php echo $cpy_block_detail->dblk_order->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_type->Visible) { // dblk_type ?>
	<div id="r_dblk_type" class="form-group">
		<label for="x_dblk_type" class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_dblk_type"><?php echo $cpy_block_detail->dblk_type->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_dblk_type" id="z_dblk_type" value="="></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_type->CellAttributes() ?>>
			<span id="el_cpy_block_detail_dblk_type">
<select data-table="cpy_block_detail" data-field="x_dblk_type" data-value-separator="<?php echo $cpy_block_detail->dblk_type->DisplayValueSeparatorAttribute() ?>" id="x_dblk_type" name="x_dblk_type"<?php echo $cpy_block_detail->dblk_type->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_type->SelectOptionListHtml("x_dblk_type") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_status->Visible) { // dblk_status ?>
	<div id="r_dblk_status" class="form-group">
		<label for="x_dblk_status" class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_dblk_status"><?php echo $cpy_block_detail->dblk_status->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_dblk_status" id="z_dblk_status" value="="></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_status->CellAttributes() ?>>
			<span id="el_cpy_block_detail_dblk_status">
<select data-table="cpy_block_detail" data-field="x_dblk_status" data-value-separator="<?php echo $cpy_block_detail->dblk_status->DisplayValueSeparatorAttribute() ?>" id="x_dblk_status" name="x_dblk_status"<?php echo $cpy_block_detail->dblk_status->EditAttributes() ?>>
<?php echo $cpy_block_detail->dblk_status->SelectOptionListHtml("x_dblk_status") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_name->Visible) { // dblk_name ?>
	<div id="r_dblk_name" class="form-group">
		<label for="x_dblk_name" class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_dblk_name"><?php echo $cpy_block_detail->dblk_name->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_dblk_name" id="z_dblk_name" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_name->CellAttributes() ?>>
			<span id="el_cpy_block_detail_dblk_name">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_name" name="x_dblk_name" id="x_dblk_name" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_name->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_name->EditValue ?>"<?php echo $cpy_block_detail->dblk_name->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_image->Visible) { // dblk_image ?>
	<div id="r_dblk_image" class="form-group">
		<label class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_dblk_image"><?php echo $cpy_block_detail->dblk_image->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_dblk_image" id="z_dblk_image" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_image->CellAttributes() ?>>
			<span id="el_cpy_block_detail_dblk_image">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_image" name="x_dblk_image" id="x_dblk_image" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_image->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_image->EditValue ?>"<?php echo $cpy_block_detail->dblk_image->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_stext->Visible) { // dblk_stext ?>
	<div id="r_dblk_stext" class="form-group">
		<label for="x_dblk_stext" class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_dblk_stext"><?php echo $cpy_block_detail->dblk_stext->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_dblk_stext" id="z_dblk_stext" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_stext->CellAttributes() ?>>
			<span id="el_cpy_block_detail_dblk_stext">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_stext" name="x_dblk_stext" id="x_dblk_stext" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_stext->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_stext->EditValue ?>"<?php echo $cpy_block_detail->dblk_stext->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_block_detail->dblk_text->Visible) { // dblk_text ?>
	<div id="r_dblk_text" class="form-group">
		<label class="<?php echo $cpy_block_detail_search->LeftColumnClass ?>"><span id="elh_cpy_block_detail_dblk_text"><?php echo $cpy_block_detail->dblk_text->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_dblk_text" id="z_dblk_text" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_block_detail_search->RightColumnClass ?>"><div<?php echo $cpy_block_detail->dblk_text->CellAttributes() ?>>
			<span id="el_cpy_block_detail_dblk_text">
<input type="text" data-table="cpy_block_detail" data-field="x_dblk_text" name="x_dblk_text" id="x_dblk_text" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_block_detail->dblk_text->getPlaceHolder()) ?>" value="<?php echo $cpy_block_detail->dblk_text->EditValue ?>"<?php echo $cpy_block_detail->dblk_text->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_block_detail_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_block_detail_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_block_detailsearch.Init();
</script>
<?php
$cpy_block_detail_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_block_detail_search->Page_Terminate();
?>
