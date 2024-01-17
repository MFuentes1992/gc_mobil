<?php 
    class SessionManager {
        function initializeSession(string $sessionKey, $object) {
            if(!isset($_SESSION[$sessionKey])) {
                $_SESSION[$sessionKey] = $object;
            }
        }

        function sessionExists(string $sessionKey) {
            if(isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] != null)
                return true;
            else
                return false;
        }
        
        function getSession(string $sessionKey) {
            if(isset($_SESSION[$sessionKey])) {
                return $_SESSION[$sessionKey];
            } else {
                return null;
            }
        }

        function endSession(string $sessionKey) {
            if(isset($_SESSION[$sessionKey]))
                $_SESSION[$sessionKey] = null;
        }

    }
?>