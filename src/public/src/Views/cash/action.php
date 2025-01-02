<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);
include_once(__DIR__ . "/../../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $param[0] : die(header("Location: /error")));
$param1 = (isset($param[1]) ? $param[1] : "");
$param2 = (isset($param[2]) ? $param[2] : "");

use App\Classes\Cash;
use App\Classes\Validation;
use App\Classes\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

try {
  define("JWT_SECRET", "SECRET-KEY");
  define("JWT_ALGO", "HS512");
  $jwt = (isset($_COOKIE['jwt']) ? $_COOKIE['jwt'] : "");
  if (empty($jwt)) {
    header("Location: /");
    exit();
  }
  $decode = JWT::decode($jwt, new Key(JWT_SECRET, JWT_ALGO));
  $email = (isset($decode->data) ? $decode->data : "");
} catch (Exception $e) {
  $msg = $e->getMessage();
  if ($msg === "Expired token") {
    header("Location: /logout");
    exit;
  }
}

$USER = new User();
$user = $USER->user_view_email([$email, $email]);

$CASH = new Cash();
$VALIDATION = new Validation();

if ($action === "create") {
  try {
    $login_id = (isset($_POST['login_id']) ? $VALIDATION->input($_POST['login_id']) : "");
    $objective = (isset($_POST['objective']) ? $VALIDATION->input($_POST['objective']) : "");
    $request_last = $CASH->request_last();

    $request_count = $CASH->request_count([$login_id, $objective]);
    if (intval($request_count) === 0) {
      $CASH->request_insert([$request_last, $login_id, $objective]);
      $request_id = $CASH->last_insert_id();

      for ($i = 0; $i < COUNT($_POST['item_text']); $i++) {
        $item_text = (isset($_POST['item_text'][$i]) ? $_POST['item_text'][$i] : "");
        $item_amount = (isset($_POST['item_amount'][$i]) ? $_POST['item_amount'][$i] : "");

        $item_count = $CASH->item_count([$request_id, $item_text, $item_amount]);
        if (intval($item_count) === 0) {
          $CASH->item_insert([$request_id, $item_text, $item_amount]);
        }
      }
      $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/cash");
    } else {
      $VALIDATION->alert("danger", "ข้อมูลซ้ำในระบบ!", "/cash");
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "update") {
  try {
    $request_id = (isset($_POST['id']) ? $VALIDATION->input($_POST['id']) : "");
    $uuid = (isset($_POST['uuid']) ? $VALIDATION->input($_POST['uuid']) : "");
    $objective = (isset($_POST['objective']) ? $VALIDATION->input($_POST['objective']) : "");

    for ($i = 0; $i < COUNT($_POST['item__id']); $i++) {
      $item__id = (isset($_POST['item__id'][$i]) ? $_POST['item__id'][$i] : "");
      $item__text = (isset($_POST['item__text'][$i]) ? $_POST['item__text'][$i] : "");
      $item__amount = (isset($_POST['item__amount'][$i]) ? $_POST['item__amount'][$i] : "");

      $CASH->item_update([$item__text, $item__amount, $item__id]);
    }

    if (COUNT($_POST['item_text']) > 0) {
      for ($i = 0; $i < COUNT($_POST['item_text']); $i++) {
        $item_text = (isset($_POST['item_text'][$i]) ? $_POST['item_text'][$i] : "");
        $item_amount = (isset($_POST['item_amount'][$i]) ? $_POST['item_amount'][$i] : "");

        $item_count = $CASH->item_count([$request_id, $item_text, $item_amount]);
        if (intval($item_count) === 0 && !empty($item_text) && !empty($item_amount)) {
          $CASH->item_insert([$request_id, $item_text, $item_amount]);
        }
      }
    }
    $CASH->request_update([$objective, $request_id]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/cash/view/{$uuid}");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "manager") {
  try {
    $request_id = (isset($_POST['id']) ? $VALIDATION->input($_POST['id']) : "");
    $uuid = (isset($_POST['uuid']) ? $VALIDATION->input($_POST['uuid']) : "");
    $status = (isset($_POST['status']) ? $VALIDATION->input($_POST['status']) : "");
    $reason = (isset($_POST['reason']) ? $VALIDATION->input($_POST['reason']) : "");

    $CASH->request_approve([$status, $request_id]);
    $CASH->remark_insert([$request_id, $user_id, $reason, $status]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/cash");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "approver") {
  try {
    $request_id = (isset($_POST['id']) ? $VALIDATION->input($_POST['id']) : "");
    $uuid = (isset($_POST['uuid']) ? $VALIDATION->input($_POST['uuid']) : "");
    $status = (isset($_POST['status']) ? $VALIDATION->input($_POST['status']) : "");
    $reason = (isset($_POST['reason']) ? $VALIDATION->input($_POST['reason']) : "");

    $CASH->request_approve([$status, $request_id]);
    $CASH->remark_insert([$request_id, $user_id, $reason, $status]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/cash");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "pay") {
  try {
    $request_id = (isset($_POST['id']) ? $VALIDATION->input($_POST['id']) : "");
    $uuid = (isset($_POST['uuid']) ? $VALIDATION->input($_POST['uuid']) : "");
    $pay_type = (isset($_POST['pay_type']) ? $VALIDATION->input($_POST['pay_type']) : "");
    $cheque_number = (isset($_POST['cheque_number']) ? $VALIDATION->input($_POST['cheque_number']) : "");
    $payment = (isset($_POST['payment']) ? $VALIDATION->input($_POST['payment']) : "");
    $status = 5;
    $reason = (isset($_POST['reason']) ? $VALIDATION->input($_POST['reason']) : "");

    $CASH->request_pay([$pay_type, $cheque_number, $payment, $status, $request_id]);
    $CASH->remark_insert([$request_id, $user_id, $reason, $status]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/cash");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "receive") {
  try {
    $request_id = (isset($_POST['id']) ? $VALIDATION->input($_POST['id']) : "");
    $uuid = (isset($_POST['uuid']) ? $VALIDATION->input($_POST['uuid']) : "");
    $receive_type = (isset($_POST['receive_type']) ? $VALIDATION->input($_POST['receive_type']) : "");
    $receive = (isset($_POST['receive']) ? $VALIDATION->input($_POST['receive']) : "");
    $status = 6;
    $reason = (isset($_POST['reason']) ? $VALIDATION->input($_POST['reason']) : "");

    if (COUNT($_FILES['file']['name']) > 0) {
      for ($i = 0; $i < COUNT($_FILES['file']['name']); $i++) {
        $file_name = (isset($_FILES['file']['name'][$i]) ? $VALIDATION->input($_FILES['file']['name'][$i]) : "");
        $file_tmp = (isset($_FILES['file']['tmp_name'][$i]) ? $_FILES['file']['tmp_name'][$i] : "");
        $file_random = md5(microtime());
        $file_extension = pathinfo(strtolower($file_name), PATHINFO_EXTENSION);
        $images_extension = ["jpg", "jpeg", "png"];
        $documents_extension = ["pdf", "xls", "xlsx", "doc", "docx", "ppt", "pptx"];
        $file_allow = array_merge($images_extension, $documents_extension);
        $file_rename = "{$file_random}.{$file_extension}";
        $file_path = (__DIR__ . "/../../Publics/files/{$file_rename}");

        if (!empty($file_name) && in_array($file_extension, $file_allow)) {
          if (in_array($file_extension, $documents_extension)) {
            move_uploaded_file($file_tmp, $file_path);
          }

          if (in_array($file_extension, $images_extension)) {
            $VALIDATION->image_upload($file_tmp, $file_path);
          }
          $CASH->file_insert([$request_id, $file_rename]);
        }
      }
    }

    $CASH->request_receive([$receive_type, $receive, $status, $request_id]);
    $CASH->remark_insert([$request_id, $user_id, $reason, $status]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/cash");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "edit") {
  try {
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "item-delete") {
  try {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    if (!empty($id)) {
      $CASH->item_delete([$id]);
      echo json_encode(200);
    } else {
      echo json_encode(500);
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "file-delete") {
  try {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    if (!empty($id)) {
      $CASH->file_delete([$id]);
      echo json_encode(200);
    } else {
      echo json_encode(500);
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "request-data") {
  try {
    $result = $CASH->request_data($user['login_id']);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "manager-data") {
  try {
    $result = $CASH->manager_data();

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "approver-data") {
  try {
    $result = $CASH->approver_data();

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "finance-data") {
  try {
    $result = $CASH->finance_data();

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "manage-data") {
  try {
    $result = $CASH->manage_data();

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}
