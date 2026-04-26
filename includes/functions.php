<?php
// includes/functions.php

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function get_slug($string) {
    return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $string));
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}
