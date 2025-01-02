<?php
require_once(__DIR__ . "/vendor/autoload.php");

$ROUTER = new AltoRouter();

##################### SERVICE #####################
##################### CASH-AUTHORIZE #####################
$ROUTER->map("GET", "/cash/authorize", function () {
  require(__DIR__ . "/src/Views/cash-authorize/index.php");
});
$ROUTER->map("GET", "/cash/authorize/create", function () {
  require(__DIR__ . "/src/Views/cash-authorize/create.php");
});
$ROUTER->map("POST", "/cash/authorize/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/cash-authorize/action.php");
});

##################### CASH #####################
$ROUTER->map("GET", "/cash", function () {
  require(__DIR__ . "/src/Views/cash/index.php");
});
$ROUTER->map("GET", "/cash/create", function () {
  require(__DIR__ . "/src/Views/cash/create.php");
});
$ROUTER->map("GET", "/cash/manage", function () {
  require(__DIR__ . "/src/Views/cash/manage.php");
});
$ROUTER->map("GET", "/cash/view/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/cash/view.php");
});
$ROUTER->map("POST", "/cash/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/cash/action.php");
});

##################### SYETEM #####################
$ROUTER->map("GET", "/system", function () {
  require(__DIR__ . "/src/Views/system/index.php");
});
$ROUTER->map("POST", "/system/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/system/action.php");
});

##################### USER #####################
$ROUTER->map("GET", "/user", function () {
  require(__DIR__ . "/src/Views/user/index.php");
});
$ROUTER->map("GET", "/user/create", function () {
  require(__DIR__ . "/src/Views/user/create.php");
});
$ROUTER->map("GET", "/user/profile", function () {
  require(__DIR__ . "/src/Views/user/profile.php");
});
$ROUTER->map("GET", "/user/change", function () {
  require(__DIR__ . "/src/Views/user/change.php");
});
$ROUTER->map("GET", "/user/edit/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/user/edit.php");
});
$ROUTER->map("POST", "/user/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/user/action.php");
});

##################### AUTH #####################
$ROUTER->map("GET", "/", function () {
  require(__DIR__ . "/src/Views/home/login.php");
});
$ROUTER->map("GET", "/logout", function () {
  require(__DIR__ . "/src/Views/home/logout.php");
});
$ROUTER->map("GET", "/home", function () {
  require(__DIR__ . "/src/Views/home/index.php");
});
$ROUTER->map("GET", "/info", function () {
  require(__DIR__ . "/src/Views/home/info.php");
});
$ROUTER->map("GET", "/error", function () {
  require(__DIR__ . "/src/Views/home/error.php");
});
$ROUTER->map("POST", "/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/home/action.php");
});
$ROUTER->map("GET", "/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/home/action.php");
});


$MATCH = $ROUTER->match();

if (is_array($MATCH) && is_callable($MATCH["target"])) {
  call_user_func_array($MATCH["target"], $MATCH["params"]);
} else {
  header("HTTP/1.1 404 Not Found");
  require_once(__DIR__ . "/src/Views/home/error.php");
}
