<?php

//  header ('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * PhSoft 1 configuration file
 */
// Relative path
if (!isset($PH_RELATIVE_PATH))
  $PH_RELATIVE_PATH = "";

// Show SQL for debug
define("PH_DEBUG_ENABLED", FALSE, TRUE); // TRUE to debug
if (PH_DEBUG_ENABLED) {
  @ini_set("display_errors", "1"); // Display errors
  error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE
}

// General
define("PH_IS_WINDOWS", (strtolower(substr(PHP_OS, 0, 3)) === 'win'), TRUE); // Is Windows OS
define("PH_IS_PHP5", (phpversion() >= "5.2.0"), TRUE); // Is PHP 5.2 or later
if (!PH_IS_PHP5)
  die("This script requires PHP 5.2 or later. You are running " . phpversion() . ".");
define("PH_PATH_DELIMITER", ((PH_IS_WINDOWS) ? "\\" : "/"), TRUE); // Physical path delimiter
define("PH_DEFAULT_DATE_FORMAT", "dd/mm/yyyy", TRUE); // Default date format
define("PH_DEFAULT_DATE_FORMAT_ID", "7", TRUE); // Default date format
define("PH_DATE_SEPARATOR", "/", TRUE); // Date separator
define("PH_UNFORMAT_YEAR", 50, TRUE); // Unformat year
define("PH_PROJECT_NAME", "PhApps", TRUE); // Project name
define("PH_CONFIG_FILE_FOLDER", PH_PROJECT_NAME . "", TRUE); // Config file name
define("PH_PROJECT_ID", "{CF04BEB2-A62E-468E-9893-D31CB1F7F490}", TRUE); // Project ID (GUID)
$PH_RELATED_PROJECT_ID = "";
$PH_RELATED_LANGUAGE_FOLDER = "";
define("PH_RANDOM_KEY", 'fprDgaGOpOOk4Sp9', TRUE); // Random key for encryption
define("PH_PROJECT_STYLESHEET_FILENAME", "phcss/PhApp.css", TRUE); // Project stylesheet file name
define("PH_CHARSET", "utf-8", TRUE); // Project charset
define("PH_EMAIL_CHARSET", PH_CHARSET, TRUE); // Email charset
define("PH_EMAIL_KEYWORD_SEPARATOR", "", TRUE); // Email keyword separator
$PH_COMPOSITE_KEY_SEPARATOR = ","; // Composite key separator
define("PH_HIGHLIGHT_COMPARE", TRUE, TRUE); // Highlight compare mode, TRUE(case-insensitive)|FALSE(case-sensitive)
if (!function_exists('xml_parser_create') && !class_exists("DOMDocument"))
  die("This script requires PHP XML Parser or DOM.");
define('PH_USE_DOM_XML', ((!function_exists('xml_parser_create') && class_exists("DOMDocument")) || FALSE), TRUE);
if (!isset($ADODB_OUTP))
  $ADODB_OUTP = 'ew_SetDebugMsg';
define("PH_FONT_SIZE", 14, TRUE);
define("PH_TMP_IMAGE_FONT", "DejaVuSans", TRUE); // Font for temp files
// Set up font path
$PH_FONT_PATH = realpath('./phfont');

// Database connection info
define("PH_CONN_HOST", 'localhost', TRUE);
define("PH_CONN_PORT", 3306, TRUE);
define("PH_CONN_USER", 'root', TRUE);
define("PH_CONN_PASS", '', TRUE);
define("PH_CONN_DB", 'dhlsy', TRUE);

// ADODB (Access/SQL Server)
define("PH_CODEPAGE", 65001, TRUE); // Code page

/**
 * Character encoding
 * Note: If you use non English languages, you need to set character encoding
 * for some features. Make sure either iconv functions or multibyte string
 * functions are enabled and your encoding is supported. See PHP manual for
 * details.
 */
define("PH_ENCODING", "UTF-8", TRUE); // Character encoding
define("PH_IS_DOUBLE_BYTE", in_array(PH_ENCODING, array("GBK", "BIG5", "SHIFT_JIS")), TRUE); // Double-byte character encoding
define("PH_FILE_SYSTEM_ENCODING", "", TRUE); // File system encoding
// Database
define("PH_IS_MSACCESS", FALSE, TRUE); // Access
define("PH_IS_MSSQL", FALSE, TRUE); // SQL Server
define("PH_IS_MYSQL", TRUE, TRUE); // MySQL
define("PH_IS_POSTGRESQL", FALSE, TRUE); // PostgreSQL
define("PH_IS_ORACLE", FALSE, TRUE); // Oracle
if (!PH_IS_WINDOWS && (PH_IS_MSACCESS || PH_IS_MSSQL))
  die("Microsoft Access or SQL Server is supported on Windows server only.");
define("PH_DB_QUOTE_START", "`", TRUE);
define("PH_DB_QUOTE_END", "`", TRUE);
define("PH_SELECT_LIMIT", (PH_IS_MYSQL || PH_IS_POSTGRESQL || PH_IS_ORACLE), TRUE);

/**
 * MySQL charset (for SET NAMES statement, not used by default)
 * Note: Read http://dev.mysql.com/doc/refman/5.0/en/charset-connection.html
 * before using this setting.
 */
define("PH_MYSQL_CHARSET", "utf8", TRUE);

/**
 * Password (MD5 and case-sensitivity)
 * Note: If you enable MD5 password, make sure that the passwords in your
 * user table are stored as MD5 hash (32-character hexadecimal number) of the
 * clear text password. If you also use case-insensitive password, convert the
 * clear text passwords to lower case first before calculating MD5 hash.
 * Otherwise, existing users will not be able to login. MD5 hash is
 * irreversible, password will be reset during password recovery.
 */
define("PH_ENCRYPTED_PASSWORD", FALSE, TRUE); // Use encrypted password
define("PH_CASE_SENSITIVE_PASSWORD", FALSE, TRUE); // Case-sensitive password

/**
 * Remove XSS
 * Note: If you want to allow these keywords, remove them from the following PH_XSS_ARRAY at your own risks.
 */
define("PH_REMOVE_XSS", TRUE, TRUE);
$PH_XSS_ARRAY = array('javascript', 'vbscript', 'expression', '<applet', '<meta', '<xml', '<blink', '<link', '<style', '<script', '<embed', '<object', '<iframe', '<frame', '<frameset', '<ilayer', '<layer', '<bgsound', '<title', '<base',
    'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

// Check Token
define("PH_CHECK_TOKEN", TRUE, TRUE); // Check post token
// Session names
define("PH_SESSION_STATUS", PH_PROJECT_NAME . "_status", TRUE); // Login status
define("PH_SESSION_USER_NAME", PH_SESSION_STATUS . "_UserName", TRUE); // User name
define("PH_SESSION_USER_ID", PH_SESSION_STATUS . "_UserID", TRUE); // User ID
define("PH_SESSION_USER_PROFILE", PH_SESSION_STATUS . "_UserProfile", TRUE); // User profile
define("PH_SESSION_USER_PROFILE_USER_NAME", PH_SESSION_USER_PROFILE . "_UserName", TRUE);
define("PH_SESSION_USER_PROFILE_PASSWORD", PH_SESSION_USER_PROFILE . "_Password", TRUE);
define("PH_SESSION_USER_PROFILE_LOGIN_TYPE", PH_SESSION_USER_PROFILE . "_LoginType", TRUE);
define("PH_SESSION_USER_LEVEL_ID", PH_SESSION_STATUS . "_UserLevel", TRUE); // User Level ID
@define("PH_SESSION_USER_LEVEL", PH_SESSION_STATUS . "_UserLevelValue", TRUE); // User Level
define("PH_SESSION_PARENT_USER_ID", PH_SESSION_STATUS . "_ParentUserID", TRUE); // Parent User ID
define("PH_SESSION_SYS_ADMIN", PH_PROJECT_NAME . "_SysAdmin", TRUE); // System admin
define("PH_SESSION_PROJECT_ID", PH_PROJECT_NAME . "_ProjectID", TRUE); // User Level project ID
define("PH_SESSION_AR_USER_LEVEL", PH_PROJECT_NAME . "_arUserLevel", TRUE); // User Level array
define("PH_SESSION_AR_USER_LEVEL_PRIV", PH_PROJECT_NAME . "_arUserLevelPriv", TRUE); // User Level privilege array
define("PH_SESSION_USER_LEVEL_MSG", PH_PROJECT_NAME . "_UserLevelMessage", TRUE); // User Level Message
define("PH_SESSION_SECURITY", PH_PROJECT_NAME . "_Security", TRUE); // Security array
define("PH_SESSION_MESSAGE", PH_PROJECT_NAME . "_Message", TRUE); // System message
define("PH_SESSION_FAILURE_MESSAGE", PH_PROJECT_NAME . "_Failure_Message", TRUE); // System error message
define("PH_SESSION_SUCCESS_MESSAGE", PH_PROJECT_NAME . "_Success_Message", TRUE); // System message
define("PH_SESSION_WARNING_MESSAGE", PH_PROJECT_NAME . "_Warning_Message", TRUE); // Warning message
define("PH_SESSION_INLINE_MODE", PH_PROJECT_NAME . "_InlineMode", TRUE); // Inline mode
define("PH_SESSION_BREADCRUMB", PH_PROJECT_NAME . "_Breadcrumb", TRUE); // Breadcrumb
define("PH_SESSION_TEMP_IMAGES", PH_PROJECT_NAME . "_TempImages", TRUE); // Temp images
// Language settings
define("PH_LANGUAGE_FOLDER", $PH_RELATIVE_PATH . "phplang/", TRUE);
$PH_LANGUAGE_FILE = array();
$PH_LANGUAGE_FILE[] = array("ar", "", "Arabic.xml");
$PH_LANGUAGE_FILE[] = array("en", "", "english.xml");
define("PH_LANGUAGE_DEFAULT_ID", "ar", TRUE);
define("PH_SESSION_LANGUAGE_ID", PH_PROJECT_NAME . "_LanguageId", TRUE); // Language ID
// Page Token
define("PH_TOKEN_NAME", "token", TRUE);
define("PH_SESSION_TOKEN", PH_PROJECT_NAME . "_Token", TRUE);

// Data types
define("PH_DATATYPE_NUMBER", 1, TRUE);
define("PH_DATATYPE_DATE", 2, TRUE);
define("PH_DATATYPE_STRING", 3, TRUE);
define("PH_DATATYPE_BOOLEAN", 4, TRUE);
define("PH_DATATYPE_MEMO", 5, TRUE);
define("PH_DATATYPE_BLOB", 6, TRUE);
define("PH_DATATYPE_TIME", 7, TRUE);
define("PH_DATATYPE_GUID", 8, TRUE);
define("PH_DATATYPE_XML", 9, TRUE);
define("PH_DATATYPE_OTHER", 10, TRUE);

// Row types
define("PH_ROWTYPE_VIEW", 1, TRUE); // Row type view
define("PH_ROWTYPE_ADD", 2, TRUE); // Row type add
define("PH_ROWTYPE_EDIT", 3, TRUE); // Row type edit
define("PH_ROWTYPE_SEARCH", 4, TRUE); // Row type search
define("PH_ROWTYPE_MASTER", 5, TRUE);  // Row type master record
define("PH_ROWTYPE_AGGREGATEINIT", 6, TRUE); // Row type aggregate init
define("PH_ROWTYPE_AGGREGATE", 7, TRUE); // Row type aggregate
// Table parameters
define("PH_TABLE_PREFIX", "||PhReport||", TRUE);
define("PH_TABLE_REC_PER_PAGE", "recperpage", TRUE); // Records per page
define("PH_TABLE_START_REC", "start", TRUE); // Start record
define("PH_TABLE_PAGE_NO", "pageno", TRUE); // Page number
define("PH_TABLE_BASIC_SEARCH", "psearch", TRUE); // Basic search keyword
define("PH_TABLE_BASIC_SEARCH_TYPE", "psearchtype", TRUE); // Basic search type
define("PH_TABLE_ADVANCED_SEARCH", "advsrch", TRUE); // Advanced search
define("PH_TABLE_SEARCH_WHERE", "searchwhere", TRUE); // Search where clause
define("PH_TABLE_WHERE", "where", TRUE); // Table where
define("PH_TABLE_WHERE_LIST", "where_list", TRUE); // Table where (list page)
define("PH_TABLE_ORDER_BY", "orderby", TRUE); // Table order by
define("PH_TABLE_ORDER_BY_LIST", "orderby_list", TRUE); // Table order by (list page)
define("PH_TABLE_SORT", "sort", TRUE); // Table sort
define("PH_TABLE_KEY", "key", TRUE); // Table key
define("PH_TABLE_SHOW_MASTER", "showmaster", TRUE); // Table show master
define("PH_TABLE_SHOW_DETAIL", "showdetail", TRUE); // Table show detail
define("PH_TABLE_MASTER_TABLE", "mastertable", TRUE); // Master table
define("PH_TABLE_DETAIL_TABLE", "detailtable", TRUE); // Detail table
define("PH_TABLE_RETURN_URL", "return", TRUE); // Return URL
define("PH_TABLE_EXPORT_RETURN_URL", "exportreturn", TRUE); // Export return URL
define("PH_TABLE_GRID_ADD_ROW_COUNT", "gridaddcnt", TRUE); // Grid add row count
// Audit Trail
define("PH_AUDIT_TRAIL_TO_DATABASE", FALSE, TRUE); // Write audit trail to DB
define("PH_AUDIT_TRAIL_TABLE_NAME", "", TRUE); // Audit trail table name
define("PH_AUDIT_TRAIL_FIELD_NAME_DATETIME", "", TRUE); // Audit trail DateTime field name
define("PH_AUDIT_TRAIL_FIELD_NAME_SCRIPT", "", TRUE); // Audit trail Script field name
define("PH_AUDIT_TRAIL_FIELD_NAME_USER", "", TRUE); // Audit trail User field name
define("PH_AUDIT_TRAIL_FIELD_NAME_ACTION", "", TRUE); // Audit trail Action field name
define("PH_AUDIT_TRAIL_FIELD_NAME_TABLE", "", TRUE); // Audit trail Table field name
define("PH_AUDIT_TRAIL_FIELD_NAME_FIELD", "", TRUE); // Audit trail Field field name
define("PH_AUDIT_TRAIL_FIELD_NAME_KEYVALUE", "", TRUE); // Audit trail Key Value field name
define("PH_AUDIT_TRAIL_FIELD_NAME_OLDVALUE", "", TRUE); // Audit trail Old Value field name
define("PH_AUDIT_TRAIL_FIELD_NAME_NEWVALUE", "", TRUE); // Audit trail New Value field name
// Security
define("PH_ADMIN_USER_NAME", "PhSoft", TRUE); // Administrator user name
define("PH_ADMIN_PASSWORD", "OneGod", TRUE); // Administrator password
define("PH_USE_CUSTOM_LOGIN", TRUE, TRUE); // Use custom login
// User level constants
define("PH_ALLOW_ADD", 1, TRUE); // Add
define("PH_ALLOW_DELETE", 2, TRUE); // Delete
define("PH_ALLOW_EDIT", 4, TRUE); // Edit
@define("PH_ALLOW_LIST", 8, TRUE); // List
if (defined("PH_USER_LEVEL_COMPAT")) {
  define("PH_ALLOW_VIEW", 8, TRUE); // View
  define("PH_ALLOW_SEARCH", 8, TRUE); // Search
} else {
  define("PH_ALLOW_VIEW", 32, TRUE); // View
  define("PH_ALLOW_SEARCH", 64, TRUE); // Search
}
@define("PH_ALLOW_REPORT", 8, TRUE); // Report
@define("PH_ALLOW_ADMIN", 16, TRUE); // Admin
// Hierarchical User ID
@define("PH_USER_ID_IS_HIERARCHICAL", TRUE, TRUE); // Change to FALSE to show one level only
// Use subquery for master/detail
define("PH_USE_SUBQUERY_FOR_MASTER_USER_ID", FALSE, TRUE);
define("PH_USER_ID_ALLOW", 104, TRUE);

// User table filters
define("PH_USER_TABLE", "`cpy_user`", TRUE);
define("PH_USER_NAME_FILTER", "(`User_Logon` = '%u')", TRUE);
define("PH_USER_ID_FILTER", "", TRUE);
define("PH_USER_EMAIL_FILTER", "(`user_email` = '%e')", TRUE);
define("PH_USER_ACTIVATE_FILTER", "", TRUE);

// User Profile Constants
define("PH_USER_PROFILE_KEY_SEPARATOR", "", TRUE);
define("PH_USER_PROFILE_FIELD_SEPARATOR", "", TRUE);
define("PH_USER_PROFILE_SESSION_ID", "SessionID", TRUE);
define("PH_USER_PROFILE_LAST_ACCESSED_DATE_TIME", "LastAccessedDateTime", TRUE);
define("PH_USER_PROFILE_CONCURRENT_SESSION_COUNT", 1, TRUE); // Maximum sessions allowed
define("PH_USER_PROFILE_SESSION_TIMEOUT", 20, TRUE);
define("PH_USER_PROFILE_LOGIN_RETRY_COUNT", "LoginRetryCount", TRUE);
define("PH_USER_PROFILE_LAST_BAD_LOGIN_DATE_TIME", "LastBadLoginDateTime", TRUE);
define("PH_USER_PROFILE_MAX_RETRY", 3, TRUE);
define("PH_USER_PROFILE_RETRY_LOCKOUT", 20, TRUE);
define("PH_USER_PROFILE_LAST_PASSWORD_CHANGED_DATE", "LastPasswordChangedDate", TRUE);
define("PH_USER_PROFILE_PASSWORD_EXPIRE", 90, TRUE);

// File upload
define("PH_UPLOAD_DEST_PATH", "", TRUE); // Upload destination path (relative to app root)
define("PH_UPLOAD_URL", "ewupload11.php", TRUE); // Upload URL
define("PH_UPLOAD_TEMP_FOLDER_PREFIX", "temp__", TRUE); // Upload temp folders prefix
define("PH_UPLOAD_TEMP_FOLDER_TIME_LIMIT", 1440, TRUE); // Upload temp folder time limit (minutes)
define("PH_UPLOAD_THUMBNAIL_FOLDER", "thumbnail", TRUE); // Temporary thumbnail folder
define("PH_UPLOAD_THUMBNAIL_WIDTH", 200, TRUE); // Temporary thumbnail max width
define("PH_UPLOAD_THUMBNAIL_HEIGHT", 0, TRUE); // Temporary thumbnail max height
define("PH_UPLOAD_ALLOWED_FILE_EXT", "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip", TRUE); // Allowed file extensions
define("PH_IMAGE_ALLOWED_FILE_EXT", "gif,jpg,png,bmp", TRUE); // Allowed file extensions for images
define("PH_MAX_FILE_SIZE", 2000000, TRUE); // Max file size
define("PH_MAX_FILE_COUNT", 0, TRUE); // Max file size
define("PH_THUMBNAIL_DEFAULT_WIDTH", 0, TRUE); // Thumbnail default width
define("PH_THUMBNAIL_DEFAULT_HEIGHT", 0, TRUE); // Thumbnail default height
define("PH_THUMBNAIL_DEFAULT_QUALITY", 75, TRUE); // Thumbnail default qualtity (JPEG)
define("PH_UPLOADED_FILE_MODE", 0666, TRUE); // Uploaded file mode
define("PH_UPLOAD_TMP_PATH", "", TRUE); // User upload temp path (relative to app root) e.g. "tmp/"
define("PH_UPLOAD_CONVERT_ACCENTED_CHARS", FALSE, TRUE); // Convert accented chars in upload file name
define("PH_USE_COLORBOX", TRUE, TRUE); // Use Colorbox
define("PH_MULTIPLE_UPLOAD_SEPARATOR", ",", TRUE); // Multiple upload separator
// Audit trail
define("PH_AUDIT_TRAIL_PATH", "", TRUE); // Audit trail path (relative to app root)
// Export records
define("PH_EXPORT_ALL", TRUE, TRUE); // Export all records
define("PH_EXPORT_ALL_TIME_LIMIT", 120, TRUE); // Export all records time limit
define("PH_XML_ENCODING", "utf-8", TRUE); // Encoding for Export to XML
define("PH_EXPORT_ORIGINAL_VALUE", FALSE, TRUE);
define("PH_EXPORT_FIELD_CAPTION", FALSE, TRUE); // TRUE to export field caption
define("PH_EXPORT_CSS_STYLES", TRUE, TRUE); // TRUE to export CSS styles
define("PH_EXPORT_MASTER_RECORD", TRUE, TRUE); // TRUE to export master record
define("PH_EXPORT_MASTER_RECORD_FOR_CSV", FALSE, TRUE); // TRUE to export master record for CSV
define("PH_EXPORT_DETAIL_RECORDS", TRUE, TRUE); // TRUE to export detail records
define("PH_EXPORT_DETAIL_RECORDS_FOR_CSV", FALSE, TRUE); // TRUE to export detail records for CSV
$PH_EXPORT = array(
    "email" => "cExportEmail",
    "html" => "cExportHtml",
    "word" => "cExportWord",
    "excel" => "cExportExcel",
    "pdf" => "cExportPdf",
    "csv" => "cExportCsv",
    "xml" => "cExportXml"
);

// Export records for reports
$PH_EXPORT_REPORT = array(
    "print" => "ExportReportHtml",
    "html" => "ExportReportHtml",
    "word" => "ExportReportWord",
    "excel" => "ExportReportExcel"
);

// MIME types
$PH_MIME_TYPES = array(
    "pdf" => "application/pdf",
    "exe" => "application/octet-stream",
    "zip" => "application/zip",
    "doc" => "application/msword",
    "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    "xls" => "application/vnd.ms-excel",
    "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "ppt" => "application/vnd.ms-powerpoint",
    "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
    "gif" => "image/gif",
    "png" => "image/png",
    "jpeg" => "image/jpg",
    "jpg" => "image/jpg",
    "mp3" => "audio/mpeg",
    "wav" => "audio/x-wav",
    "mpeg" => "video/mpeg",
    "mpg" => "video/mpeg",
    "mpe" => "video/mpeg",
    "mov" => "video/quicktime",
    "avi" => "video/x-msvideo",
    "3gp" => "video/3gpp",
    "css" => "text/css",
    "js" => "application/javascript",
    "htm" => "text/html",
    "html" => "text/html"
);

// Use token in URL (reserved, not used, do NOT change!)
define("PH_USE_TOKEN_IN_URL", FALSE, TRUE);

// Use ILIKE for PostgreSql
define("PH_USE_ILIKE_FOR_POSTGRESQL", TRUE, TRUE);

// Use collation for MySQL
define("PH_LIKE_COLLATION_FOR_MYSQL", "", TRUE);

// Use collation for MsSQL
define("PH_LIKE_COLLATION_FOR_MSSQL", "", TRUE);

// Null / Not Null values
define("PH_NULL_VALUE", "##null##", TRUE);
define("PH_NOT_NULL_VALUE", "##notnull##", TRUE);

/**
 * Search multi value option
 * 1 - no multi value
 * 2 - AND all multi values
 * 3 - OR all multi values
 */
define("PH_SEARCH_MULTI_VALUE_OPTION", 3, TRUE);

// Basic search ignore special characters
define("PH_BASIC_SEARCH_IGNORE_PATTERN", "/[\?,\.\^\*\(\)\[\]\\\"]/", TRUE);

// Validate option
define("PH_CLIENT_VALIDATE", TRUE, TRUE);
define("PH_SERVER_VALIDATE", FALSE, TRUE);

// Blob field byte count for hash value calculation
define("PH_BLOB_FIELD_BYTE_COUNT", 200, TRUE);

// Auto suggest max entries
define("PH_AUTO_SUGGEST_MAX_ENTRIES", 10, TRUE);

// Auto fill original value
define("PH_AUTO_FILL_ORIGINAL_VALUE", false, TRUE);

// Checkbox and radio button groups
define("PH_ITEM_TEMPLATE_CLASSNAME", "ewTemplate", TRUE);
define("PH_ITEM_TABLE_CLASSNAME", "ewItemTable", TRUE);

// Use responsive layout
$PH_USE_RESPONSIVE_LAYOUT = TRUE;

// Use css flip
define("PH_CSS_FLIP", TRUE, TRUE);

// Time zone
$DEFAULT_TIME_ZONE = "GMT";

/**
 * Numeric and monetary formatting options
 * Note: DO NOT CHANGE THE FOLLOWING $DEFAULT_* VARIABLES!
 * If you want to use custom settings, customize the language file,
 * set "use_system_locale" to "0" to override localeconv and customize the
 * phrases under the <locale> node for ew_FormatCurrency/Number/Percent functions
 * Also read http://www.php.net/localeconv for description of the constants
 */
$DEFAULT_LOCALE = json_decode('{"decimal_point":".","thousands_sep":"","int_curr_symbol":"$","currency_symbol":"$","mon_decimal_point":".","mon_thousands_sep":"","positive_sign":"","negative_sign":"-","int_frac_digits":2,"frac_digits":2,"p_cs_precedes":1,"p_sep_by_space":0,"n_cs_precedes":1,"n_sep_by_space":0,"p_sign_posn":1,"n_sign_posn":1}', TRUE);
$DEFAULT_DECIMAL_POINT = &$DEFAULT_LOCALE["decimal_point"];
$DEFAULT_THOUSANDS_SEP = &$DEFAULT_LOCALE["thousands_sep"];
$DEFAULT_CURRENCY_SYMBOL = &$DEFAULT_LOCALE["currency_symbol"];
$DEFAULT_MON_DECIMAL_POINT = &$DEFAULT_LOCALE["mon_decimal_point"];
$DEFAULT_MON_THOUSANDS_SEP = &$DEFAULT_LOCALE["mon_thousands_sep"];
$DEFAULT_POSITIVE_SIGN = &$DEFAULT_LOCALE["positive_sign"];
$DEFAULT_NEGATIVE_SIGN = &$DEFAULT_LOCALE["negative_sign"];
$DEFAULT_FRAC_DIGITS = &$DEFAULT_LOCALE["frac_digits"];
$DEFAULT_P_CS_PRECEDES = &$DEFAULT_LOCALE["p_cs_precedes"];
$DEFAULT_P_SEP_BY_SPACE = &$DEFAULT_LOCALE["p_sep_by_space"];
$DEFAULT_N_CS_PRECEDES = &$DEFAULT_LOCALE["n_cs_precedes"];
$DEFAULT_N_SEP_BY_SPACE = &$DEFAULT_LOCALE["n_sep_by_space"];
$DEFAULT_P_SIGN_POSN = &$DEFAULT_LOCALE["p_sign_posn"];
$DEFAULT_N_SIGN_POSN = &$DEFAULT_LOCALE["n_sign_posn"];

// Cookies
define("PH_COOKIE_EXPIRY_TIME", time() + 365 * 24 * 60 * 60, TRUE); // Change cookie expiry time here
//
// Global variables
//

if (!isset($conn)) {

  // Common objects
  $conn = NULL; // Connection
  $Page = NULL; // Page
  $UserTable = NULL; // User table
  $Table = NULL; // Main table
  $Grid = NULL; // Grid page object
  $Language = NULL; // Language
  $Security = NULL; // Security
  $UserProfile = NULL; // User profile
  $objForm = NULL; // Form
  // Current language
  $gsLanguage = "";

  // Token
  $gsToken = "";

  // Used by ValidateForm/ValidateSearch
  $gsFormError = ""; // Form error message
  $gsSearchError = ""; // Search form error message
  // Used by *master.php
  $gsMasterReturnUrl = "";

  // Used by header.php, export checking
  $gsExport = "";
  $gsExportFile = "";
  $gsCustomExport = "";

  // Used by header.php/footer.php, skip header/footer checking
  $gbSkipHeaderFooter = FALSE;
  $gbOldSkipHeaderFooter = $gbSkipHeaderFooter;

  // Email error message
  $gsEmailErrDesc = "";

  // Debug message
  $gsDebugMsg = "";

  // Debug timer
  $gTimer = NULL;

  // Keep temp images name for PDF export for delete
  $gTmpImages = array();
}

// Mobile detect
$MobileDetect = NULL;

// Breadcrumb
$Breadcrumb = NULL;
?>
<?php

// Menu
define("PH_MENUBAR_ID", "RootMenu", TRUE);
define("PH_MENUBAR_BRAND", "", TRUE);
define("PH_MENUBAR_BRAND_HYPERLINK", "", TRUE);
define("PH_MENUBAR_CLASSNAME", "", TRUE);

//define("PH_MENU_CLASSNAME", "nav nav-list", TRUE);
define("PH_MENU_CLASSNAME", "dropdown-menu", TRUE);
define("PH_SUBMENU_CLASSNAME", "dropdown-menu", TRUE);
define("PH_SUBMENU_DROPDOWN_IMAGE", "", TRUE);
define("PH_SUBMENU_DROPDOWN_ICON_CLASSNAME", "", TRUE);
define("PH_MENU_DIVIDER_CLASSNAME", "divider", TRUE);
define("PH_MENU_ITEM_CLASSNAME", "dropdown-submenu", TRUE);
define("PH_SUBMENU_ITEM_CLASSNAME", "dropdown-submenu", TRUE);
define("PH_MENU_ACTIVE_ITEM_CLASS", "active", TRUE);
define("PH_SUBMENU_ACTIVE_ITEM_CLASS", "active", TRUE);
define("PH_MENU_ROOT_GROUP_TITLE_AS_SUBMENU", FALSE, TRUE);
define("PH_SHOW_RIGHT_MENU", FALSE, TRUE);
?>
<?php

define("PH_PDF_STYLESHEET_FILENAME", "phcss/ewpdf.css", TRUE); // export PDF CSS styles
define("PH_PDF_MEMORY_LIMIT", "128M", TRUE); // Memory limit
define("PH_PDF_TIME_LIMIT", 120, TRUE); // Time limit
?>
