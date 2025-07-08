<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

session_start();

require_once 'utils/router.php';

require_once 'data.php';
require_once 'controller/pageController.php';
require_once 'controller/formController.php';

$router = new Router();

// GET ----------------------------
$router->get('/', function () {
    PageController::header();
    PageController::home();
    PageController::footer();
});

$router->get('invite-{id}', function ($id) {
    PageController::header();
    PageController::home($id);
    PageController::footer();
});

$router->get('admin', function () {
    PageController::admin();
});

$router->get('logout', function () {
    PageController::logout();
});

// POST --------------------------
$router->post('confirm', function () {
    FormController::confirm();
});

$router->post('admin', function () {
    PageController::admin();
});

$router->post('admin/save', function () {
    FormController::addGuest();
});

$router->post('saveRequest', function () {
    FormController::addGuestInactive();
});

$router->get('admin/getguests', function () {
    FormController::getGuests();
});

$router->get('admin/getstats', function () {
    FormController::getStats();
});

$router->get('admin/delete/{id}', function ($id) {
    FormController::deleteGuest($id);
});

$router->get('admin/invite/{id}', function ($id) {
    FormController::inviteRequest($id);
});

$router->post('admin/update', function () {
    FormController::updateGuest();
});

// RUN ------------------------------
$router->dispatch($_SERVER['REQUEST_METHOD'], $_GET['r'] ?? '');

register_shutdown_function(function () {
    DBModel::disconnect();
});