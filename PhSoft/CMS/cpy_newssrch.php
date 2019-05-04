<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_newsinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_news_search = NULL; // Initialize page object first

class ccpy_news_search extends ccpy_news {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}';

	// Table name
	var $TableName = 'cpy_news';

	// Page object name
	var $PageObjName = 'cpy_news_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
		if (!$Security->CanSearch()) {
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
						$sSrchStr = "cpy_newslist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->news_status); // news_status
		$this->BuildSearchUrl($sSrchUrl, $this->type_id); // type_id
		$this->BuildSearchUrl($sSrchUrl, $this->news_date); // news_date
		$this->BuildSearchUrl($sSrchUrl, $this->news_title); // news_title
		$this->BuildSearchUrl($sSrchUrl, $this->news_stext); // news_stext
		$this->BuildSearchUrl($sSrchUrl, $this->news_image); // news_image
		$this->BuildSearchUrl($sSrchUrl, $this->news_text); // news_text
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
		// news_status

		$this->news_status->AdvancedSearch->SearchValue = $objForm->GetValue("x_news_status");
		$this->news_status->AdvancedSearch->SearchOperator = $objForm->GetValue("z_news_status");

		// type_id
		$this->type_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_type_id");
		$this->type_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_type_id");

		// news_date
		$this->news_date->AdvancedSearch->SearchValue = $objForm->GetValue("x_news_date");
		$this->news_date->AdvancedSearch->SearchOperator = $objForm->GetValue("z_news_date");

		// news_title
		$this->news_title->AdvancedSearch->SearchValue = $objForm->GetValue("x_news_title");
		$this->news_title->AdvancedSearch->SearchOperator = $objForm->GetValue("z_news_title");

		// news_stext
		$this->news_stext->AdvancedSearch->SearchValue = $objForm->GetValue("x_news_stext");
		$this->news_stext->AdvancedSearch->SearchOperator = $objForm->GetValue("z_news_stext");

		// news_image
		$this->news_image->AdvancedSearch->SearchValue = $objForm->GetValue("x_news_image");
		$this->news_image->AdvancedSearch->SearchOperator = $objForm->GetValue("z_news_image");

		// news_text
		$this->news_text->AdvancedSearch->SearchValue = $objForm->GetValue("x_news_text");
		$this->news_text->AdvancedSearch->SearchOperator = $objForm->GetValue("z_news_text");
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// news_status
			$this->news_status->EditAttrs["class"] = "form-control";
			$this->news_status->EditCustomAttributes = "";
			$this->news_status->EditValue = $this->news_status->Options(TRUE);

			// type_id
			$this->type_id->EditAttrs["class"] = "form-control";
			$this->type_id->EditCustomAttributes = "";
			if (trim(strval($this->type_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
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
			$this->news_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->news_date->AdvancedSearch->SearchValue, 5), 5));
			$this->news_date->PlaceHolder = ew_RemoveHtml($this->news_date->FldCaption());

			// news_title
			$this->news_title->EditAttrs["class"] = "form-control";
			$this->news_title->EditCustomAttributes = "";
			$this->news_title->EditValue = ew_HtmlEncode($this->news_title->AdvancedSearch->SearchValue);
			$this->news_title->PlaceHolder = ew_RemoveHtml($this->news_title->FldCaption());

			// news_stext
			$this->news_stext->EditAttrs["class"] = "form-control";
			$this->news_stext->EditCustomAttributes = "";
			$this->news_stext->EditValue = ew_HtmlEncode($this->news_stext->AdvancedSearch->SearchValue);
			$this->news_stext->PlaceHolder = ew_RemoveHtml($this->news_stext->FldCaption());

			// news_image
			$this->news_image->EditAttrs["class"] = "form-control";
			$this->news_image->EditCustomAttributes = "";
			$this->news_image->EditValue = ew_HtmlEncode($this->news_image->AdvancedSearch->SearchValue);
			$this->news_image->PlaceHolder = ew_RemoveHtml($this->news_image->FldCaption());

			// news_text
			$this->news_text->EditAttrs["class"] = "form-control";
			$this->news_text->EditCustomAttributes = "";
			$this->news_text->EditValue = ew_HtmlEncode($this->news_text->AdvancedSearch->SearchValue);
			$this->news_text->PlaceHolder = ew_RemoveHtml($this->news_text->FldCaption());
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
		if (!ew_CheckDate($this->news_date->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->news_date->FldErrMsg());
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
		$this->news_status->AdvancedSearch->Load();
		$this->type_id->AdvancedSearch->Load();
		$this->news_date->AdvancedSearch->Load();
		$this->news_title->AdvancedSearch->Load();
		$this->news_stext->AdvancedSearch->Load();
		$this->news_image->AdvancedSearch->Load();
		$this->news_text->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_newslist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($cpy_news_search)) $cpy_news_search = new ccpy_news_search();

// Page init
$cpy_news_search->Page_Init();

// Page main
$cpy_news_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_news_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($cpy_news_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fcpy_newssearch = new ew_Form("fcpy_newssearch", "search");
<?php } else { ?>
var CurrentForm = fcpy_newssearch = new ew_Form("fcpy_newssearch", "search");
<?php } ?>

// Form_CustomValidate event
fcpy_newssearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_newssearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_newssearch.Lists["x_news_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcpy_newssearch.Lists["x_news_status"].Options = <?php echo json_encode($cpy_news_search->news_status->Options()) ?>;
fcpy_newssearch.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_news_type"};
fcpy_newssearch.Lists["x_type_id"].Data = "<?php echo $cpy_news_search->type_id->LookupFilterQuery(FALSE, "search") ?>";

// Form object for search
// Validate function for search

fcpy_newssearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_news_date");
	if (elm && !ew_CheckDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_news->news_date->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_news_search->ShowPageHeader(); ?>
<?php
$cpy_news_search->ShowMessage();
?>
<form name="fcpy_newssearch" id="fcpy_newssearch" class="<?php echo $cpy_news_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_news_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_news_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_news">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($cpy_news_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($cpy_news->news_status->Visible) { // news_status ?>
	<div id="r_news_status" class="form-group">
		<label for="x_news_status" class="<?php echo $cpy_news_search->LeftColumnClass ?>"><span id="elh_cpy_news_news_status"><?php echo $cpy_news->news_status->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_news_status" id="z_news_status" value="="></p>
		</label>
		<div class="<?php echo $cpy_news_search->RightColumnClass ?>"><div<?php echo $cpy_news->news_status->CellAttributes() ?>>
			<span id="el_cpy_news_news_status">
<select data-table="cpy_news" data-field="x_news_status" data-value-separator="<?php echo $cpy_news->news_status->DisplayValueSeparatorAttribute() ?>" id="x_news_status" name="x_news_status"<?php echo $cpy_news->news_status->EditAttributes() ?>>
<?php echo $cpy_news->news_status->SelectOptionListHtml("x_news_status") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->type_id->Visible) { // type_id ?>
	<div id="r_type_id" class="form-group">
		<label for="x_type_id" class="<?php echo $cpy_news_search->LeftColumnClass ?>"><span id="elh_cpy_news_type_id"><?php echo $cpy_news->type_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_type_id" id="z_type_id" value="="></p>
		</label>
		<div class="<?php echo $cpy_news_search->RightColumnClass ?>"><div<?php echo $cpy_news->type_id->CellAttributes() ?>>
			<span id="el_cpy_news_type_id">
<select data-table="cpy_news" data-field="x_type_id" data-value-separator="<?php echo $cpy_news->type_id->DisplayValueSeparatorAttribute() ?>" id="x_type_id" name="x_type_id"<?php echo $cpy_news->type_id->EditAttributes() ?>>
<?php echo $cpy_news->type_id->SelectOptionListHtml("x_type_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_date->Visible) { // news_date ?>
	<div id="r_news_date" class="form-group">
		<label for="x_news_date" class="<?php echo $cpy_news_search->LeftColumnClass ?>"><span id="elh_cpy_news_news_date"><?php echo $cpy_news->news_date->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_news_date" id="z_news_date" value="="></p>
		</label>
		<div class="<?php echo $cpy_news_search->RightColumnClass ?>"><div<?php echo $cpy_news->news_date->CellAttributes() ?>>
			<span id="el_cpy_news_news_date">
<input type="text" data-table="cpy_news" data-field="x_news_date" data-format="5" name="x_news_date" id="x_news_date" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_date->getPlaceHolder()) ?>" value="<?php echo $cpy_news->news_date->EditValue ?>"<?php echo $cpy_news->news_date->EditAttributes() ?>>
<?php if (!$cpy_news->news_date->ReadOnly && !$cpy_news->news_date->Disabled && !isset($cpy_news->news_date->EditAttrs["readonly"]) && !isset($cpy_news->news_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_newssearch", "x_news_date", {"ignoreReadonly":true,"useCurrent":false,"format":5});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_title->Visible) { // news_title ?>
	<div id="r_news_title" class="form-group">
		<label for="x_news_title" class="<?php echo $cpy_news_search->LeftColumnClass ?>"><span id="elh_cpy_news_news_title"><?php echo $cpy_news->news_title->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_news_title" id="z_news_title" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_news_search->RightColumnClass ?>"><div<?php echo $cpy_news->news_title->CellAttributes() ?>>
			<span id="el_cpy_news_news_title">
<input type="text" data-table="cpy_news" data-field="x_news_title" name="x_news_title" id="x_news_title" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_title->getPlaceHolder()) ?>" value="<?php echo $cpy_news->news_title->EditValue ?>"<?php echo $cpy_news->news_title->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_stext->Visible) { // news_stext ?>
	<div id="r_news_stext" class="form-group">
		<label for="x_news_stext" class="<?php echo $cpy_news_search->LeftColumnClass ?>"><span id="elh_cpy_news_news_stext"><?php echo $cpy_news->news_stext->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_news_stext" id="z_news_stext" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_news_search->RightColumnClass ?>"><div<?php echo $cpy_news->news_stext->CellAttributes() ?>>
			<span id="el_cpy_news_news_stext">
<input type="text" data-table="cpy_news" data-field="x_news_stext" name="x_news_stext" id="x_news_stext" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_stext->getPlaceHolder()) ?>" value="<?php echo $cpy_news->news_stext->EditValue ?>"<?php echo $cpy_news->news_stext->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_image->Visible) { // news_image ?>
	<div id="r_news_image" class="form-group">
		<label class="<?php echo $cpy_news_search->LeftColumnClass ?>"><span id="elh_cpy_news_news_image"><?php echo $cpy_news->news_image->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_news_image" id="z_news_image" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_news_search->RightColumnClass ?>"><div<?php echo $cpy_news->news_image->CellAttributes() ?>>
			<span id="el_cpy_news_news_image">
<input type="text" data-table="cpy_news" data-field="x_news_image" name="x_news_image" id="x_news_image" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_image->getPlaceHolder()) ?>" value="<?php echo $cpy_news->news_image->EditValue ?>"<?php echo $cpy_news->news_image->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_news->news_text->Visible) { // news_text ?>
	<div id="r_news_text" class="form-group">
		<label class="<?php echo $cpy_news_search->LeftColumnClass ?>"><span id="elh_cpy_news_news_text"><?php echo $cpy_news->news_text->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_news_text" id="z_news_text" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_news_search->RightColumnClass ?>"><div<?php echo $cpy_news->news_text->CellAttributes() ?>>
			<span id="el_cpy_news_news_text">
<input type="text" data-table="cpy_news" data-field="x_news_text" name="x_news_text" id="x_news_text" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_news->news_text->getPlaceHolder()) ?>" value="<?php echo $cpy_news->news_text->EditValue ?>"<?php echo $cpy_news->news_text->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_news_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_news_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_newssearch.Init();
</script>
<?php
$cpy_news_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_news_search->Page_Terminate();
?>
