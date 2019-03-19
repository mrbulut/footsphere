<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 11:01
 */

include "system/Functions.php";
include "system/Controller.php";
include "system/Viewer.php";

$F = new Functions();
$F->start();
$F->createRulesInAAM();// Roller Tanımlanıyor.
$F->ShowErrors();


//$F->createTestPlace();
// BU FONKSİYON TEST ORTAMI YARATIYOR //
