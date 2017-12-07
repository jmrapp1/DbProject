<?php
/**
 * User: jonrapp
 * Date: 12/3/17
 */
require_once("DatabaseService.php");

final class SessionService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new SessionService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function createSession($loginId) {
        $_SESSION['loggedInUser'] = $loginId;
    }

    function destroySession() {
        unset($_SESSION['loggedInUser']);
    }

    function isSessionSet() {
        return isset($_SESSION['loggedInUser']);
    }

    function getLoginId() {
        if ($this->isSessionSet()) {
            return $_SESSION['loggedInUser'];
        }
        return -1;
    }

    function setDb($db)
    {
        $this->db = $db;
    }

}

