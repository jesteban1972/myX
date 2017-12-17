<?php

include 'core.inc';
include 'DB.inc';
include 'praxis.inc';

session_start();
$_SESSION['userID'] = 1;

$amount = Praxis::getPracticaAmount();
var_dump($amount);

