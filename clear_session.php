<?php
session_start();
if (isset($_SESSION['order'])) {
    unset($_SESSION['order']); // Clear the order from session
}
?>