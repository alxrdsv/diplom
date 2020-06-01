<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/diplom/core/functions.php');
session_start();
$instance->pageInclude();

error_reporting(E_ALL); 
ini_set('display_errors', '1'); 
ini_set('display_startup_errors', '1');
