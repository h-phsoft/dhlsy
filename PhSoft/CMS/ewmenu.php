<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(12, "mi_cpy_news", $Language->MenuPhrase("12", "MenuText"), "cpy_newslist.php", -1, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}cpy_news'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(5, "mi_cpy_page", $Language->MenuPhrase("5", "MenuText"), "cpy_pagelist.php", -1, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}cpy_page'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_cpy_block", $Language->MenuPhrase("1", "MenuText"), "cpy_blocklist.php", -1, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}cpy_block'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(13, "mi_cpy_slider_mst", $Language->MenuPhrase("13", "MenuText"), "cpy_slider_mstlist.php", -1, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}cpy_slider_mst'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_cpy_menu", $Language->MenuPhrase("4", "MenuText"), "cpy_menulist.php", -1, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}cpy_menu'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(37, "mci_Management", $Language->MenuPhrase("37", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(19, "mi_cpy_menu_mode", $Language->MenuPhrase("19", "MenuText"), "cpy_menu_modelist.php", 37, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}cpy_menu_mode'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(20, "mi_cpy_menu_type", $Language->MenuPhrase("20", "MenuText"), "cpy_menu_typelist.php", 37, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}cpy_menu_type'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_phs_metta", $Language->MenuPhrase("7", "MenuText"), "phs_mettalist.php", 37, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}phs_metta'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10, "mi_phs_setting", $Language->MenuPhrase("10", "MenuText"), "phs_settinglist.php", 37, "", IsLoggedIn() || AllowListMenu('{EB80027D-BFC8-4F25-85BB-6B03A26BA4A8}phs_setting'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
