<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . "/../../../vendor/autoload.php");

use App\Classes\CashAuthorize;
use App\Classes\Validation;

$AUTHORIZE = new CashAuthorize();
$VALIDATION = new Validation();

$param = (isset($params) ? explode('/', $params) : header('location /helpdesk/error'));
$action = (isset($param[0]) ? $param[0] : '');
$param1 = (isset($param[1]) ? $param[1] : '');
$param2 = (isset($param[2]) ? $param[2] : '');

if ($action === "create") {
  try {
    $type_id = (isset($_POST['type_id']) ? $VALIDATION->input($_POST['type_id']) : "");
    $user_id = (isset($_POST['user_id']) ? $VALIDATION->input($_POST['user_id']) : "");

    $authorize_count = $AUTHORIZE->authorize_count([$type_id, $user_id]);
    if (intval($authorize_count) === 0) {
      $AUTHORIZE->authorize_create([$type_id, $user_id]);
      $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/cash/authorize");
    } else {
      $VALIDATION->alert("danger", "ข้อมูลซ้ำในระบบ!", "/cash/authorize");
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "delete") {
  try {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    if (!empty($id)) {
      $result = $AUTHORIZE->authorize_delete([$id]);

      echo json_encode(200);
    } else {
      echo json_encode(400);
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "data") {
  try {
    $result = $AUTHORIZE->authorize_data();

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "money") {
  try {
    $result = $AUTHORIZE->money();

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "money-update") {
  try {
    $data = json_decode(file_get_contents("php://input"), true);
    $money = $data['money'];
    $result = $AUTHORIZE->money_update([$money]);

    echo json_encode(200);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "user-select") {
  try {
    $keyword = (isset($_POST['q']) ? $VALIDATION->input($_POST['q']) : "");
    $result = $AUTHORIZE->user_select($keyword);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}
