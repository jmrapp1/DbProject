<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/SessionService.php');

SessionService::Instance()->destroySession();
header("Location: ../../index.php");