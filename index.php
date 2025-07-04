<?php
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
    PageController::header();
    PageController::admin();
    PageController::footer();
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

$router->get('admin/getguests', function () {
    FormController::getGuests();
});

$router->get('admin/delete/{id}', function ($id) {
    FormController::deleteGuest($id);
});

$router->post('admin/update', function () {
    FormController::updateGuest();
});

// RUN ------------------------------
$router->dispatch($_SERVER['REQUEST_METHOD'], $_GET['r'] ?? '');


