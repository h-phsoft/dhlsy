<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * PhSoft Common classes and functions
 * (C) 2000-2015 PhSoft.
 */
// Include PHPMailer class
include_once("phpmailer527/class.phpmailer.php");

// Email
/*
  define("PH_SMTP_SERVER", "localhost", TRUE); // SMTP server
  define("PH_SMTP_SERVER_PORT", 25, TRUE); // SMTP server port
  define("PH_SMTP_SECURE_OPTION", "", TRUE); // SMTP Secur options: "", "ssl" or "tls"
  define("PH_SMTP_SERVER_USERNAME", "", TRUE); // SMTP server user name
  define("PH_SMTP_SERVER_PASSWORD", "", TRUE); // SMTP server password
 */

// Function to send email
function ph_SendEmail($sRecipients = array(
    "From" => "",
    "To" => "",
    "Cc" => "",
    "Bcc" => ""
), $sSubject = "no Subject", $sMail = "", $SMTPOptions = array(
    "PH_SMTP_SERVER" => "localhost",
    "PH_SMTP_SERVER_PORT" => 25,
    "PH_SMTP_SERVER_USERNAME" => "",
    "PH_SMTP_SERVER_PASSWORD" => "",
    "PH_SMTP_SERVER_SECURE" => ""
), $arAttachments = array(), $sFormat = "", $sCharset = "UTF-8", $arImages = array(), $mail = NULL) {
  $gsEmailErrDesc = '';
  $res = FALSE;
  if (is_null($mail)) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $SMTPOptions["PH_SMTP_SERVER"];
    $mail->SMTPAuth = ($SMTPOptions["PH_SMTP_SERVER_USERNAME"] <> "" && $SMTPOptions["PH_SMTP_SERVER_PASSWORD"] <> "");
    $mail->Username = $SMTPOptions["PH_SMTP_SERVER_USERNAME"];
    $mail->Password = $SMTPOptions["PH_SMTP_SERVER_PASSWORD"];
    $mail->Port = $SMTPOptions["PH_SMTP_SERVER_PORT"];
  }
  if ($SMTPOptions["PH_SMTP_SERVER_SECURE"] <> "") {
    $mail->SMTPSecure = $SMTPOptions["PH_SMTP_SERVER_SECURE"];
  }
  if (preg_match('/^(.+)<([\w.%+-]+@[\w.-]+\.[A-Z]{2,6})>$/i', trim($sRecipients['FROM']), $m)) {
    $mail->From = $m[2];
    $mail->FromName = trim($m[1]);
  } else {
    $mail->From = $sRecipients['FROM'];
    $mail->FromName = $sRecipients['FROM'];
  }
  $mail->Subject = $sSubject;
  $mail->Body = $sMail;
  if ($sCharset <> "" && strtolower($sCharset) <> "iso-8859-1") {
    $mail->CharSet = $sCharset;
  }
  $sRecipients['TO'] = str_replace(";", ",", $sRecipients['TO']);
  $arrTo = explode(",", $sRecipients['TO']);
  foreach ($arrTo as $sTo) {
    $mail->AddAddress(trim($sTo));
  }
  if ($sRecipients['CC'] <> "") {
    $sRecipients['CC'] = str_replace(";", ",", $sRecipients['CC']);
    $arrCc = explode(",", $sRecipients['CC']);
    foreach ($arrCc as $sCc) {
      $mail->AddCC(trim($sCc));
    }
  }
  if ($sRecipients['BCC'] <> "") {
    $sRecipients['BCC'] = str_replace(";", ",", $sRecipients['BCC']);
    $arrBcc = explode(",", $sRecipients['BCC']);
    foreach ($arrBcc as $sBcc) {
      $mail->AddBCC(trim($sBcc));
    }
  }
  if (strtolower($sFormat) == "html") {
    $mail->ContentType = "text/html";
  } else {
    $mail->ContentType = "text/plain";
  }
  if (is_array($arAttachments)) {
    foreach ($arAttachments as $attachment) {
      $mail->AddAttachment($attachment);
    }
  }
  if (is_array($arImages)) {
    foreach ($arImages as $tmpimage) {
      $file = $tmpimage;
      $cid = ew_TmpImageLnk($tmpimage, "cid");
      $mail->AddEmbeddedImage($file, $cid, $tmpimage);
    }
  }
  $res = $mail->Send();
  $gsEmailErrDesc = $mail->ErrorInfo;

  // Uncomment to debug
  // var_dump($mail); exit();

  return $gsEmailErrDesc;
}

function ph_EncodePassword($sPass) {
  $vRet = md5(ph_Clean_Password($sPass));
  return $vRet;
}

// Get DB Setting Varchar Value from Database
function ph_Setting($vKey) {
  $vRet = ph_SettingValue($vKey, 'set_val');
  return $vRet;
}

// Get DB Setting Number Value from Database
function ph_SettingValue($vKey, $vValue = 'set_val') {
  $vRet = ph_GetDBValue($vValue, 'phs_setting', 'upper(`set_name`)=upper("' . $vKey . '")');
  return $vRet;
}

// Get value from database from table by condition
function ph_GetDBValue($sField, $sTable, $sWhere = '') {
  $sRetVal = '';
  $sSQL = "SELECT " . $sField . " AS `vValue` FROM " . $sTable;
  if ($sWhere != '') {
    $sSQL .= " WHERE " . $sWhere;
  }
  try {
    $res = ph_Execute($sSQL);
    if ($res != "") {
      if (!$res->EOF) {
        $sRetVal = $res->fields('vValue');
      }
      $res->Close();
    }
  } catch (Exception $ex) {
    $sRetVal = "";
  }
  return $sRetVal;
}

// Load Metta Data
function ph_GetMetta() {
  $sSQL = "SELECT `metta_name`, `metta_value` FROM `phs_metta` ORDER BY `metta_name`";
  $vRet = '';
  $res = ph_Execute($sSQL);
  if ($res != "") {
    if (!$res->EOF) {
      while (!$res->EOF) {
        $vRet = '<meta name="' . $res->fields('metta_name') . '" content="' . $res->fields('metta_value') . '">';
        $res->MoveNext();
      }
      $res->Close();
    }
  }
  return $vRet;
}

// Generate random number
function ph_Random() {
  return mt_rand();
}

// Connect to database
function &ph_Connect($info = NULL) {
  $GLOBALS["ADODB_FETCH_MODE"] = ADODB_FETCH_BOTH;
  $conn = new mysqlt_driver_ADOConnection();
  $conn->debug = PH_DEBUG_ENABLED;
  $conn->debug_echo = FALSE;
  if (!$info) {
    $info = array("host" => PH_CONN_HOST,
        "port" => PH_CONN_PORT,
        "user" => PH_CONN_USER,
        "pass" => PH_CONN_PASS,
        "db" => PH_CONN_DB);
  }
  // Database connecting event
  $conn->port = intval($info["port"]);
  $conn->raiseErrorFn = 'ph_ErrorFn';
  $conn->Connect($info["host"], $info["user"], $info["pass"], $info["db"]);
  if (PH_MYSQL_CHARSET <> "") {
    $conn->Execute("SET NAMES '" . PH_MYSQL_CHARSET . "'");
  }
  $conn->raiseErrorFn = '';

  // Database connected event
  return $conn;
}

// Convert different data type value
function ph_Conv($v, $t) {
  $retVar = '';
  switch ($t) {
    case 2:
    case 3:
    case 16:
    case 17:
    case 18:
    case 19: // If adSmallInt/adInteger/adTinyInt/adUnsignedTinyInt/adUnsignedSmallInt
      $retVar = (is_null($v)) ? NULL : intval($v);
      break;
    case 4:
    Case 5:
    case 6:
    case 131:
    case 139: // If adSingle/adDouble/adCurrency/adNumeric/adVarNumeric
      $retVar = (is_null($v)) ? NULL : (float) $v;
      break;
    default:
      $retVar = (is_null($v)) ? NULL : $v;
  }
  return $retVar;
}

// Convert string to float
function ph_StrToFloat($v) {
  global $DEFAULT_THOUSANDS_SEP, $DEFAULT_DECIMAL_POINT;
  $v = str_replace(" ", "", $v);
  $v = str_replace(array($DEFAULT_THOUSANDS_SEP, $DEFAULT_DECIMAL_POINT), array("", "."), $v);
  return $v;
}

// Check if boolean value is TRUE
function ph_ConvertToBool($value) {
  return ($value == TRUE || strval($value) == "1" ||
          strtolower(strval($value)) == "y" || strtolower(strval($value)) == "t");
}

// Connection/Query error handler
function ph_ErrorFn($DbType, $ErrorType, $ErrorNo, $ErrorMsg, $Param1, $Param2, $Object) {
  if ($ErrorType == 'CONNECT') {
    $msg = "Failed to connect to $Param2 at $Param1. Error: " . $ErrorMsg;
  } elseif ($ErrorType == 'EXECUTE') {
    if (PH_DEBUG_ENABLED) {
      $msg = "Failed to execute SQL: $Param1. Error: " . $ErrorMsg;
    } else {
      $msg = "Failed to execute SQL. Error: " . $ErrorMsg;
    }
  }
  ph_AddMessage($_SESSION[PH_SESSION_FAILURE_MESSAGE], $msg);
}

// Add message
function ph_AddMessage(&$msg, $msgtoadd, $sep = "<br>") {
  if (strval($msgtoadd) <> "") {
    if (strval($msg) <> "") {
      $msg .= $sep;
    }
    $msg .= $msgtoadd;
  }
}

// Add filter
function ph_AddFilter(&$filter, $newfilter) {
  if (trim($newfilter) == "") {
    return;
  }
  if (trim($filter) <> "") {
    $filter = "(" . $filter . ") AND (" . $newfilter . ")";
  } else {
    $filter = $newfilter;
  }
}

// Add slashes for SQL
function ph_AdjustSql($val) {
  $val = addslashes(trim($val));
  return $val;
}

// Build SELECT SQL based on different sql part
function ph_BuildSelectSql($sSelect, $sWhere, $sGroupBy, $sHaving, $sOrderBy, $sFilter, $sSort) {
  $sDbWhere = $sWhere;
  ph_AddFilter($sDbWhere, $sFilter);
  $sDbOrderBy = $sOrderBy;
  if ($sSort <> "") {
    $sDbOrderBy = $sSort;
  }
  $sSql = $sSelect;
  if ($sDbWhere <> "") {
    $sSql .= " WHERE " . $sDbWhere;
  }
  if ($sGroupBy <> "") {
    $sSql .= " GROUP BY " . $sGroupBy;
  }
  if ($sHaving <> "") {
    $sSql .= " HAVING " . $sHaving;
  }
  if ($sDbOrderBy <> "") {
    $sSql .= " ORDER BY " . $sDbOrderBy;
  }
  return $sSql;
}

// Quote table/field name
function ph_QuotedName($Name) {
  return Ph_DB_QUOTE_START . $Name . Ph_DB_QUOTE_END;
}

// Quote field value
function ph_QuotedValue($Value, $FldType) {
  $retVar = "NULL";
  if (is_null($Value)) {
    $retVar = "NULL";
  } else {
    switch ($FldType) {
      case Ph_DATATYPE_STRING:
      case Ph_DATATYPE_MEMO:
      case Ph_DATATYPE_TIME:
        if (Ph_REMOVE_XSS) {
          $retVar = "'" . ph_AdjustSql(ph_RemoveXSS($Value)) . "'";
        } else {
          $retVar = "'" . ph_AdjustSql($Value) . "'";
        }
        break;
      case Ph_DATATYPE_XML:
        $retVar = "'" . ph_AdjustSql($Value) . "'";
        break;
      case Ph_DATATYPE_BLOB:
        $retVar = "'" . addslashes($Value) . "'";
        break;
      case Ph_DATATYPE_DATE:
        $retVar = "'" . ph_AdjustSql($Value) . "'";
        break;
      case Ph_DATATYPE_GUID:
        $retVar = "'" . $Value . "'";
        break;
      case Ph_DATATYPE_BOOLEAN:
        $retVar = "'" . $Value . "'"; // 'Y'|'N' or 'y'|'n' or '1'|'0' or 't'|'f'
        break;
      default:
        $retVar = $Value;
    }
  }
  return $retVar;
}

// Remove XSS
function ph_RemoveXSS($val) {

  // Remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
  // This prevents some character re-spacing such as <java\0script>
  // Note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs

  $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

  // Straight replacements, the user should never need these since they're normal characters
  // This prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>

  $search = 'abcdefghijklmnopqrstuvwxyz';
  $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $search .= '1234567890!@#$%^&*()';
  $search .= '~`";:?+/={}[]-_|\'\\';
  for ($i = 0; $i < strlen($search); $i++) {

    // ;? matches the ;, which is optional
    // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
    // &#x0040 @ search for the hex values

    $val = preg_replace('/(&#[x|X]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // With a ;
    // &#00064 @ 0{0,7} matches '0' zero to seven times
    $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // With a ;
  }

  // Now the only remaining whitespace attacks are \t, \n, and \r
  $ra = $GLOBALS["PH_XSS_ARRAY"]; // Note: Customize $PH_XSS_ARRAY in phcfg.php
  $found = true; // Keep replacing as long as the previous round replaced something
  while ($found == true) {
    $val_before = $val;
    for ($i = 0; $i < sizeof($ra); $i++) {
      $pattern = '/';
      for ($j = 0; $j < strlen($ra[$i]); $j++) {
        if ($j > 0) {
          $pattern .= '(';
          $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
          $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
          $pattern .= ')?';
        }
        $pattern .= $ra[$i][$j];
      }
      $pattern .= '/i';
      $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // Add in <> to nerf the tag
      $val = preg_replace($pattern, $replacement, $val); // Filter out the hex tags
      if ($val_before == $val) {

        // No replacements were made, so exit the loop
        $found = false;
      }
    }
  }
  return $val;
}

// Executes the query, and returns the row(s) as JSON
function ph_ExecuteJson($SQL, $FirstOnly = TRUE) {
  $retVar = "false";
  $rs = ph_LoadRecordset($SQL);
  if ($rs && !$rs->EOF && $rs->FieldCount() > 0) {
    $res = ($FirstOnly) ? array($rs->fields) : $rs->GetRows();
    $rs->Close();
    $retVar = json_encode($res);
  }
  return $retVar;
}

// Remove CR and LF
function ph_RemoveCrLf($s) {
  if (strlen($s) > 0) {
    $s = str_replace("\n", " ", $s);
    $s = str_replace("\r", " ", $s);
    $s = str_replace("\l", " ", $s);
  }
  return $s;
}

// Get user IP
function ph_CurrentUserIP() {
  return ph_ServerVar("REMOTE_ADDR");
}

function base64_to_jpeg($base64_string, $output_file) {
  $ifp = fopen($output_file, "wb");
  $data = explode(',', $base64_string);
  fwrite($ifp, base64_decode($data[1]));
  fclose($ifp);
  return $output_file;
}

/**
 * Class for TEA encryption/decryption
 */
class cPhTEA {

  function long2str($v, $w) {
    $retVar = '';
    $len = count($v);
    $s = array();
    for ($i = 0; $i < $len; $i++) {
      $s[$i] = pack("V", $v[$i]);
    }
    if ($w) {
      $retVar = substr(join('', $s), 0, $v[$len - 1]);
    } else {
      $retVar = join('', $s);
    }
    return $retVar;
  }

  function str2long($s, $w) {
    $v = unpack("V*", $s . str_repeat("\0", (4 - strlen($s) % 4) & 3));
    $v = array_values($v);
    if ($w) {
      $v[count($v)] = strlen($s);
    }
    return $v;
  }

  // Encrypt
  public function Encrypt($str, $key = PH_RANDOM_KEY) {
    $retVar = "";
    if ($str == "") {
      $retVar = "";
    } else {
      $v = $this->str2long($str, true);
      $k = $this->str2long($key, false);
      $cntk = count($k);
      if ($cntk < 4) {
        for ($i = $cntk; $i < 4; $i++) {
          $k[$i] = 0;
        }
      }
      $n = count($v) - 1;
      $z = $v[$n];
      $y = $v[0];
      $delta = 0x9E3779B9;
      $q = floor(6 + 52 / ($n + 1));
      $sum = 0;
      while (0 < $q--) {
        $sum = $this->int32($sum + $delta);
        $e = $sum >> 2 & 3;
        for ($p = 0; $p < $n; $p++) {
          $y = $v[$p + 1];
          $mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
          $z = $v[$p] = $this->int32($v[$p] + $mx);
        }
        $y = $v[0];
        $mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
        $z = $v[$n] = $this->int32($v[$n] + $mx);
      }
      $retVar = $this->UrlEncode($this->long2str($v, false));
    }
    return $retVar;
  }

  // Decrypt
  public function Decrypt($str, $key = PH_RANDOM_KEY) {
    $retVar = "";
    $str = $this->UrlDecode($str);
    if ($str == "") {
      $retVar = "";
    } else {
      $v = $this->str2long($str, false);
      $k = $this->str2long($key, false);
      $cntk = count($k);
      if ($cntk < 4) {
        for ($i = $cntk; $i < 4; $i++) {
          $k[$i] = 0;
        }
      }
      $n = count($v) - 1;
      $z = $v[$n];
      $y = $v[0];
      $delta = 0x9E3779B9;
      $q = floor(6 + 52 / ($n + 1));
      $sum = $this->int32($q * $delta);
      while ($sum != 0) {
        $e = $sum >> 2 & 3;
        for ($p = $n; $p > 0; $p--) {
          $z = $v[$p - 1];
          $mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
          $y = $v[$p] = $this->int32($v[$p] - $mx);
        }
        $z = $v[$n];
        $mx = $this->int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ $this->int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
        $y = $v[0] = $this->int32($v[0] - $mx);
        $sum = $this->int32($sum - $delta);
      }
      $retVar = $this->long2str($v, true);
    }
    return $retVar;
  }

  function int32($n) {
    while ($n >= 2147483648) {
      $n -= 4294967296;
    }
    while ($n <= -2147483649) {
      $n += 4294967296;
    }
    return (int) $n;
  }

  function UrlEncode($string) {
    $data = base64_encode($string);
    return str_replace(array('+', '/', '='), array('-', '_', '.'), $data);
  }

  function UrlDecode($string) {
    $data = str_replace(array('-', '_', '.'), array('+', '/', '='), $string);
    return base64_decode($data);
  }

}

// Encrypt
function ph_Encrypt($str, $key = PH_RANDOM_KEY) {
  $tea = new cPhTEA;
  return $tea->Encrypt($str, $key);
}

// Decrypt
function ph_Decrypt($str, $key = PH_RANDOM_KEY) {
  $tea = new cPhTEA;
  return $tea->Decrypt($str, $key);
}

// Check sum
function ph_CheckSum($value) {
  $value = str_replace(array('-', ' '), array('', ''), $value);
  $checksum = 0;
  for ($i = (2 - (strlen($value) % 2)); $i <= strlen($value); $i += 2) {
    $checksum += (int) ($value[$i - 1]);
  }
  for ($i = (strlen($value) % 2) + 1; $i < strlen($value); $i += 2) {
    $digit = (int) ($value[$i - 1]) * 2;
    $checksum += ($digit < 10) ? $digit : ($digit - 9);
  }
  return ($checksum % 10 == 0);
}

// Check email
function ph_CheckEmail($value) {
  $retVar = TRUE;
  if (strval($value) == "") {
    $retVar = TRUE;
  } else {
    $retVar = preg_match('/^[\w.%+-]+@[\w.-]+\.[A-Z]{2,6}$/i', trim($value));
  }
  return $retVar;
}

function ph_ConvertToUtf8($str) {
  return ph_Convert(PH_ENCODING, "UTF-8", $str);
}

function ph_ConvertFromUtf8($str) {
  return ph_Convert("UTF-8", ph_ENCODING, $str);
}

function ph_Convert($from, $to, $str) {
  $retVar = $str;
  if (is_string($str) && $from != "" && $to != "" && strtoupper($from) != strtoupper($to)) {
    if (function_exists("iconv")) {
      $retVar = iconv($from, $to, $str);
    } elseif (function_exists("mb_convert_encoding")) {
      $retVar = mb_convert_encoding($str, $to, $from);
    } else {
      $retVar = $str;
    }
  } else {
    $retVar = $str;
  }
  return $retVar;
}

// Convert a value to JSON value
// $type: string/boolean
function ph_VarToJson($val, $type = "") {
  $retVar = $val;
  $type = strtolower($type);
  if (is_null($val)) {
    $retVar = "null";
  } elseif ($type == "boolean" || is_bool($val)) {
    $retVar = (ph_ConvertToBool($val)) ? "true" : "false";
  } elseif ($type == "string" || is_string($val)) {
    $retVar = '"' . ph_JsEncode2($val) . '"';
  }
  return $retVar;
}

// Convert rows (array) to JSON
function ph_ArrayToJson($ar, $offset = 0) {
  $arOut = array();
  $array = FALSE;
  if (count($ar) > 0) {
    $keys = array_keys($ar[0]);
    foreach ($keys as $key) {
      if (is_int($key)) {
        $array = TRUE;
        break;
      }
    }
  }
  foreach ($ar as $row) {
    $arwrk = array();
    foreach ($row as $key => $val) {
      if (($array && is_string($key)) || (!$array && is_int($key))) {
        continue;
      }
      $key = ($array) ? "" : "\"" . ph_JsEncode2($key) . "\":";
      $arwrk[] = $key . ph_VarToJson($val);
    }
    if ($array) { // Array
      $arOut[] = "[" . implode(",", $arwrk) . "]";
    } else { // Object
      $arOut[] = "{" . implode(",", $arwrk) . "}";
    }
  }
  if ($offset > 0) {
    $arOut = array_slice($arOut, $offset);
  }
  return "[" . implode(",", $arOut) . "]";
}

// Encode html
function ph_HtmlEncode($exp) {
  return @htmlspecialchars(strval($exp), ENT_COMPAT | ENT_HTML5, PH_ENCODING);
}

// Convert XML to array
function ph_Xml2Array($contents) {
  if (!$contents) {
    return array();
  }
  if (!function_exists('xml_parser_create')) {
    return FALSE;
  }
  $get_attributes = 1; // Always get attributes. DO NOT CHANGE!
  // Get the XML Parser of PHP
  $parser = xml_parser_create();
  xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); // Always return in utf-8
  xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
  xml_parse_into_struct($parser, trim($contents), $xml_values);
  xml_parser_free($parser);
  if (!$xml_values) {
    return;
  }
  $xml_array = array();
  $parents = array();
  $opened_tags = array();
  $arr = array();
  $current = &$xml_array;
  $repeated_tag_index = array(); // Multiple tags with same name will be turned into an array
  foreach ($xml_values as $data) {
    unset($attributes, $value); // Remove existing values
    // Extract these variables into the foreach scope
    // - tag(string), type(string), level(int), attributes(array)

    extract($data);
    $result = array();
    if (isset($value)) {
      $result['value'] = $value;
    } // Put the value in a assoc array
// Set the attributes
    if (isset($attributes) and $get_attributes) {
      foreach ($attributes as $attr => $val) {
        $result['attr'][$attr] = $val;
      } // Set all the attributes in a array called 'attr'
    }

    // See tag status and do the needed
    if ($type == "open") { // The starting of the tag '<tag>'
      $parent[$level - 1] = &$current;
      if (!is_array($current) || !in_array($tag, array_keys($current))) { // Insert New tag
        if ($tag <> 'ew-language' && @$result['attr']['id'] <> '') { //
          $last_item_index = $result['attr']['id'];
          $current[$tag][$last_item_index] = $result;
          $repeated_tag_index[$tag . '_' . $level] = 1;
          $current = &$current[$tag][$last_item_index];
        } else {
          $current[$tag] = $result;
          $repeated_tag_index[$tag . '_' . $level] = 0;
          $current = &$current[$tag];
        }
      } else { // Another element with the same tag name
        if ($repeated_tag_index[$tag . '_' . $level] > 0) { // If there is a 0th element it is already an array
          if (@$result['attr']['id'] <> '') {
            $last_item_index = $result['attr']['id'];
          } else {
            $last_item_index = $repeated_tag_index[$tag . '_' . $level];
          }
          $current[$tag][$last_item_index] = $result;
          $repeated_tag_index[$tag . '_' . $level] ++;
        } else { // Make the value an array if multiple tags with the same name appear together
          $temp = $current[$tag];
          $current[$tag] = array();
          if (@$temp['attr']['id'] <> '') {
            $current[$tag][$temp['attr']['id']] = $temp;
          } else {
            $current[$tag][] = $temp;
          }
          if (@$result['attr']['id'] <> '') {
            $last_item_index = $result['attr']['id'];
          } else {
            $last_item_index = 1;
          }
          $current[$tag][$last_item_index] = $result;
          $repeated_tag_index[$tag . '_' . $level] = 2;
        }
        $current = &$current[$tag][$last_item_index];
      }
    } elseif ($type == "complete") { // Tags that ends in one line '<tag>'
      if (!isset($current[$tag])) { // New key
        $current[$tag] = array(); // Always use array for "complete" type
        if (@$result['attr']['id'] <> '') {
          $current[$tag][$result['attr']['id']] = $result;
        } else {
          $current[$tag][] = $result;
        }
        $repeated_tag_index[$tag . '_' . $level] = 1;
      } else { // Existing key
        if (@$result['attr']['id'] <> '') {
          $current[$tag][$result['attr']['id']] = $result;
        } else {
          $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
        }
        $repeated_tag_index[$tag . '_' . $level] ++;
      }
    } elseif ($type == 'close') { // End of tag '</tag>'
      $current = &$parent[$level - 1];
    }
  }
  return($xml_array);
}

// Encode value for double-quoted Javascript string
if (!function_exists('ph_JsEncode2')) {

  function ph_JsEncode2($val) {
    $val = strval($val);
    if (PH_IS_DOUBLE_BYTE) {
      $val = ph_ConvertToUtf8($val);
    }
    $val = str_replace("\\", "\\\\", $val);
    $val = str_replace("\"", "\\\"", $val);
    $val = str_replace("\t", "\\t", $val);
    $val = str_replace("\r", "\\r", $val);
    $val = str_replace("\n", "\\n", $val);
    if (PH_IS_DOUBLE_BYTE) {
      $val = ph_ConvertFromUtf8($val);
    }
    return $val;
  }

}

// Encode value to single-quoted Javascript string for HTML attributes
if (!function_exists('ph_JsEncode3')) {

  function ph_JsEncode3($val) {
    $val = strval($val);
    if (PH_IS_DOUBLE_BYTE) {
      $val = ph_ConvertToUtf8($val);
    }
    $val = str_replace("\\", "\\\\", $val);
    $val = str_replace("'", "\\'", $val);
    $val = str_replace("\"", "&quot;", $val);
    if (PH_IS_DOUBLE_BYTE) {
      $val = ph_ConvertFromUtf8($val);
    }
    return $val;
  }

}

// Convert array to JSON for HTML attributes
if (!function_exists('ph_ArrayToJsonAttr')) {

  function ph_ArrayToJsonAttr($ar) {
    $Str = "{";
    foreach ($ar as $key => $val) {
      $Str .= $key . ":'" . ph_JsEncode3($val) . "',";
    }
    if (substr($Str, -1) == ",") {
      $Str = substr($Str, 0, strlen($Str) - 1);
    }
    $Str .= "}";
    return $Str;
  }

}

// Get server variable by name
if (!function_exists('ph_ServerVar')) {

  function ph_ServerVar($Name) {
    $str = $_SERVER[$Name];
    if (empty($str)) {
      $str = $_ENV[$Name];
    }
    return $str;
  }

}

// Execute UPDATE, INSERT, or DELETE statements
if (!function_exists('ph_Execute')) {

  function ph_Execute($SQL, $fn = NULL) {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $conn->raiseErrorFn = 'ph_ErrorFn';
    $rs = $conn->Execute($SQL);
    $conn->raiseErrorFn = '';
    if (is_callable($fn) && $rs) {
      while (!$rs->EOF) {
        $fn($rs->fields);
        $rs->MoveNext();
      }
      $rs->MoveFirst();
    }
    return $rs;
  }

}

// Inserted Id
if (!function_exists('ph_InsertedId')) {

  function ph_InsertedId() {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    return $conn->Insert_ID();
  }

}

// Executes the query, and returns the first column of the first row
if (!function_exists('ph_ExecuteScalar')) {

  function ph_ExecuteScalar($SQL) {
    $res = FALSE;
    $rs = ph_LoadRecordset($SQL);
    if ($rs && !$rs->EOF && $rs->FieldCount() > 0) {
      $res = $rs->fields[0];
      $rs->Close();
    }
    return $res;
  }

}

// Executes the query, and returns the first row
if (!function_exists('ph_ExecuteRow')) {

  function ph_ExecuteRow($SQL) {
    $res = FALSE;
    $rs = ph_LoadRecordset($SQL);
    if ($rs && !$rs->EOF) {
      $res = $rs->fields;
      $rs->Close();
    }
    return $res;
  }

}

// Load recordset
if (!function_exists('ph_LoadRecordset')) {

  function &ph_LoadRecordset($SQL) {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $conn->raiseErrorFn = 'ph_ErrorFn';
    $rs = ph_Execute($SQL);
    $conn->raiseErrorFn = '';
    return $rs;
  }

}

// Get numeric formatting information
function ph_LocaleConv() {
  $info = defined("PH_DEFAULT_LOCALE") ? json_decode(PH_DEFAULT_LOCALE, TRUE) : NULL;
  return ($info) ? $info : localeconv();
}

/* * ****************************** */

if (!function_exists('ph_PrepareGets')) {

  function ph_PrepareGets() {
    foreach ($_GET as $key => $value) {
      if (!is_array($key)) {
        if (!is_array($value)) {
          $_GET[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
        }
      }
    }
  }

}

if (!function_exists('ph_PreparePosts')) {

  function ph_PreparePosts() {
    foreach ($_POST as $key => $value) {
      if (!is_array($key)) {
        if (!is_array($value)) {
          $_POST[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
        }
      }
    }
  }

}

if (!function_exists('ph_PrepareRequests')) {

  function ph_PrepareRequests() {
    foreach ($_REQUEST as $key => $value) {
      if (!is_array($key)) {
        $_REQUEST[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
      }
    }
  }

}

/**
 * Get GET input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Get')) {

  function ph_Get($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_GET, $filter) : $_GET;
      } else {
        $retVar = $_GET;
      }
    } else {
      if (isset($_GET[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_GET, $key, $filter) : $_GET[$key];
        } else {
          $retVar = $_GET[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}
/**
 * Get POST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Post')) {

  function ph_Post($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_POST, $filter) : $_POST;
      } else {
        $retVar = $_POST;
      }
    } else {
      if (isset($_POST[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_POST, $key, $filter) : $_POST[$key];
        } else {
          $retVar = $_POST[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get GET_POST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Get_Post')) {

  function ph_Get_Post($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!isset($GLOBALS['_GET_POST'])) {
      $GLOBALS['_GET_POST'] = array_merge($_GET, $_POST);
    }
    if (!$key) {
      if (function_exists('filter_var_array')) {
        $retVar = $filter ? filter_var_array($GLOBALS['_GET_POST'], $filter) : $GLOBALS['_GET_POST'];
      } else {
        $retVar = $GLOBALS['_GET_POST'];
      }
    } else {
      if (isset($GLOBALS['_GET_POST'][$key])) {
        if (function_exists('filter_var')) {
          $retVar = $filter ? filter_var($GLOBALS['_GET_POST'][$key], $filter) : $GLOBALS['_GET_POST'][$key];
        } else {
          $retVar = $GLOBALS['_GET_POST'][$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get REQUEST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Request')) {

  function ph_Request($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_REQUEST, $filter) : $_REQUEST;
      } else {
        $retVar = $_REQUEST;
      }
    } else {
      if (isset($_REQUEST[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_REQUEST, $key, $filter) : $_REQUEST[$key];
        } else {
          $retVar = $_REQUEST[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get COOKIE input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Cookie')) {

  function ph_Cookie($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_COOKIE, $filter) : $_COOKIE;
      } else {
        $retVar = $_COOKIE;
      }
    } else {
      if (isset($_COOKIE[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_COOKIE, $key, $filter) : $_COOKIE[$key];
        } else {
          $retVar = $_COOKIE[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Set COOKIE input
 *
 * time can be set in seconds
 *
 * @param String $key
 * @param Mixed  $value
 * @param Int    $time
 */
if (!function_exists('ph_SetCookie')) {

  function ph_SetCookie($key, $value, $time = SECONDS_IN_A_HOUR) {
    setcookie($key, $value, time() + $time, "/");
  }

}

/**
 * Delete COOKIE input
 *
 * @param String $key
 */
if (!function_exists('ph_DeleteCookie')) {

  function ph_DeleteCookie($key) {
    setcookie($key, null, time() - SECONDS_IN_A_HOUR, "/");
    unset($_COOKIE[$key]);
  }

}

/**
 * Get a session variable.
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Session')) {

  function ph_Session($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_var_array')) {
        $retVar = $filter ? filter_var_array($_SESSION, $filter) : $_SESSION;
      } else {
        $retVar = $_SESSION;
      }
    } else {
      if (isset($_SESSION[$key])) {
        if (function_exists('filter_var')) {
          $retVar = $filter ? filter_var($_SESSION[$key], $filter) : $_SESSION[$key];
        } else {
          $retVar = $_SESSION[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Set a session variable.
 *
 * @param String $key
 * @param mixed  $value
 */
if (!function_exists('ph_SetSession')) {

  function ph_SetSession($key, $value = '') {
    if (isset($key)) {
      $_SESSION[$key] = $value;
    }
  }

}

/* * ****************************** */

function ph_Clean_String($sString) {
  $sString = str_replace('#', '', $sString);
  $sString = str_replace('&', '', $sString);
  $sString = str_replace(';', '', $sString);
  $sString = str_replace('!', '', $sString);
  $sString = str_replace('"', '', $sString);
  $sString = str_replace('$', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('%', '', $sString);
  $sString = str_replace("'", '', $sString);
  $sString = str_replace('(', '', $sString);
  $sString = str_replace(')', '', $sString);
  $sString = str_replace('*', '', $sString);
  $sString = str_replace('+', '', $sString);
  $sString = str_replace(',', '', $sString);
  $sString = str_replace('-', '', $sString);
  $sString = str_replace('.', '', $sString);
  $sString = str_replace('/', '', $sString);
  $sString = str_replace(':', '', $sString);
  $sString = str_replace('<', '', $sString);
  $sString = str_replace('=', '', $sString);
  $sString = str_replace('>', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('[', '', $sString);
  $sString = str_replace('\\', '', $sString);
  $sString = str_replace(']', '', $sString);
  $sString = str_replace('^', '', $sString);
  $sString = str_replace('_', '', $sString);
  $sString = str_replace('`', '', $sString);
  $sString = str_replace('{', '', $sString);
  $sString = str_replace('|', '', $sString);
  $sString = str_replace('}', '', $sString);
  $sString = str_replace('~', '', $sString);
  $sString = str_replace("select", "", $sString);
  $sString = str_replace("SELECT", "", $sString);
  $sString = str_replace("update", "", $sString);
  $sString = str_replace("UPDATE", "", $sString);
  $sString = str_replace("delete", "", $sString);
  $sString = str_replace("DELETE", "", $sString);
  $sString = str_replace("union", "", $sString);
  $sString = str_replace("UNION", "", $sString);
  $sString = str_replace("from", "", $sString);
  $sString = str_replace("FROM", "", $sString);
  $sString = str_replace("concat", "", $sString);
  $sString = str_replace("CONCAT", "", $sString);
  $sString = str_replace("usrnam", "", $sString);
  $sString = str_replace("passwod", "", $sString);
  $sString = str_replace("cmslog", "", $sString);
  $sString = str_replace("drop", "", $sString);
  $sString = str_replace("DROP", "", $sString);
  $sString = str_replace(";", "", $sString);
  $sString = str_replace("--", "", $sString);
  $sString = str_replace("\0", "", $sString);
  $sString = htmlspecialchars($sString);
  $sString = strip_tags($sString);

  return $sString;
}

function ph_Clean_EMail($sString) {
  $sString = str_replace('#', '', $sString);
  $sString = str_replace('&', '', $sString);
  $sString = str_replace(';', '', $sString);
  $sString = str_replace(' ', '', $sString);
  $sString = str_replace('!', '', $sString);
  $sString = str_replace('"', '', $sString);
  $sString = str_replace('$', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('%', '', $sString);
  $sString = str_replace("'", '', $sString);
  $sString = str_replace('(', '', $sString);
  $sString = str_replace(')', '', $sString);
  $sString = str_replace('*', '', $sString);
  $sString = str_replace('+', '', $sString);
  $sString = str_replace(',', '', $sString);
  $sString = str_replace('-', '', $sString);
  $sString = str_replace('/', '', $sString);
  $sString = str_replace(':', '', $sString);
  $sString = str_replace('<', '', $sString);
  $sString = str_replace('=', '', $sString);
  $sString = str_replace('>', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('[', '', $sString);
  $sString = str_replace('\\', '', $sString);
  $sString = str_replace(']', '', $sString);
  $sString = str_replace('^', '', $sString);
  $sString = str_replace('_', '', $sString);
  $sString = str_replace('`', '', $sString);
  $sString = str_replace('{', '', $sString);
  $sString = str_replace('|', '', $sString);
  $sString = str_replace('}', '', $sString);
  $sString = str_replace('~', '', $sString);
  $sString = str_replace("select", "", $sString);
  $sString = str_replace("SELECT", "", $sString);
  $sString = str_replace("update", "", $sString);
  $sString = str_replace("UPDATE", "", $sString);
  $sString = str_replace("delete", "", $sString);
  $sString = str_replace("DELETE", "", $sString);
  $sString = str_replace("union", "", $sString);
  $sString = str_replace("UNION", "", $sString);
  $sString = str_replace("from", "", $sString);
  $sString = str_replace("FROM", "", $sString);
  $sString = str_replace("concat", "", $sString);
  $sString = str_replace("CONCAT", "", $sString);
  $sString = str_replace("usrnam", "", $sString);
  $sString = str_replace("passwod", "", $sString);
  $sString = str_replace("cmslog", "", $sString);
  $sString = str_replace("drop", "", $sString);
  $sString = str_replace("DROP", "", $sString);
  $sString = str_replace(";", "", $sString);
  $sString = str_replace("--", "", $sString);
  $sString = str_replace("\0", "", $sString);
  $sString = htmlspecialchars($sString);
  $sString = strip_tags($sString);

  return $sString;
}

function ph_Clean_Password($sString) {
  $sString = str_replace('"', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace("'", '', $sString);
  $sString = str_replace('(', '', $sString);
  $sString = str_replace(')', '', $sString);
  $sString = str_replace('<', '', $sString);
  $sString = str_replace('=', '', $sString);
  $sString = str_replace('>', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('[', '', $sString);
  $sString = str_replace('\\', '', $sString);
  $sString = str_replace(']', '', $sString);
  $sString = str_replace('`', '', $sString);
  $sString = str_replace('{', '', $sString);
  $sString = str_replace('|', '', $sString);
  $sString = str_replace('}', '', $sString);
  $sString = str_replace("select", "", $sString);
  $sString = str_replace("SELECT", "", $sString);
  $sString = str_replace("update", "", $sString);
  $sString = str_replace("UPDATE", "", $sString);
  $sString = str_replace("delete", "", $sString);
  $sString = str_replace("DELETE", "", $sString);
  $sString = str_replace("union", "", $sString);
  $sString = str_replace("UNION", "", $sString);
  $sString = str_replace("from", "", $sString);
  $sString = str_replace("FROM", "", $sString);
  $sString = str_replace("concat", "", $sString);
  $sString = str_replace("CONCAT", "", $sString);
  $sString = str_replace("usrnam", "", $sString);
  $sString = str_replace("passwod", "", $sString);
  $sString = str_replace("cmslog", "", $sString);
  $sString = str_replace("drop", "", $sString);
  $sString = str_replace("DROP", "", $sString);
  $sString = str_replace(";", "", $sString);
  $sString = str_replace("--", "", $sString);
  $sString = str_replace("\0", "", $sString);
  $sString = htmlspecialchars($sString);
  $sString = strip_tags($sString);

  return $sString;
}

function ph_UploadFile($srcFilename, $target_dir = 'uploads/', $newFileName = '') {

  $uploadOk = 0;
  if ($newFileName == '') {
    $newFileName = $srcFilename;
  }
  $distFilename = $target_dir . $newFileName . date("ymdHis") . '.' . pathinfo(basename($_FILES[$srcFilename]["name"]), PATHINFO_EXTENSION);
  $imageFileType = pathinfo(basename($_FILES[$srcFilename]["name"]), PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES[$srcFilename]["tmp_name"]);
  if ($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 0;
  } else {
    //echo "File is not an image.";
    $uploadOk = 1;
  }

// Check if file already exists
  if (file_exists($distFilename)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 2;
  }
// Check file size
  if ($_FILES[$srcFilename]["size"] > 200000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 3;
  }
// Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 4;
  }
// Check if $uploadOk is set to 0 by an error
  if ($uploadOk != 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES[$srcFilename]["tmp_name"], $distFilename)) {
      //echo "The file " . basename($_FILES["idImage1"]["name"]) . " has been uploaded.";
    } else {
      //echo "Sorry, there was an error uploading your file.";
      $uploadOk = 2;
    }
  }
  return array("Status" => $uploadOk, "NewFileName" => $distFilename);
}
