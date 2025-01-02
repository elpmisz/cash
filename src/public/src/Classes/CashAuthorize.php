<?php

namespace App\Classes;

use PDO;

class CashAuthorize
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function hello()
  {
    return "Authorize Class";
  }

  public function authorize_count($data)
  {
    $sql = "SELECT COUNT(*) FROM cash.cash_authorize WHERE status = 1 AND type_id = ? AND login_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function authorize_create($data)
  {
    $sql = "INSERT INTO cash.cash_authorize(`type_id`, `login_id`) VALUES(?,?)";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function authorize_delete($data)
  {
    $sql = "UPDATE cash.cash_authorize SET
    status = 2,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function authorize_check($data)
  {
    $sql = "SELECT COUNT(*) FROM cash.cash_authorize WHERE `type_id` = ? AND login_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function money()
  {
    $sql = "SELECT amount FROM cash.cash_money WHERE id = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return (isset($row['amount']) ? $row['amount'] : "");
  }

  public function money_update($data)
  {
    $sql = "UPDATE cash.cash_money SET
    amount = ?
    WHERE id = 1";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function authorize_data()
  {
    $sql = "SELECT COUNT(*) FROM cash.cash_authorize WHERE status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    $column = ["date", "invoice", "debtor", "item", "so", "brand", "quantity", "coc"];

    $filter_order = (isset($_POST['order']) ? $_POST['order'] : "");
    $order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : "");
    $order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : "");
    $limit_start = (isset($_POST['start']) ? $_POST['start'] : "");
    $limit_length = (isset($_POST['length']) ? $_POST['length'] : "");
    $draw = (isset($_POST['draw']) ? $_POST['draw'] : "");

    $sql = "SELECT a.id,
    (
      CASE
        WHEN a.type_id = 1 THEN 'ผจก. การเงิน'
        WHEN a.type_id = 2 THEN 'การเงิน'
        WHEN a.type_id = 3 THEN 'ผู้อนุมัติคนที่ 1'
        WHEN a.type_id = 4 THEN 'ผู้อนุมัติคนที่ 2'
        WHEN a.type_id = 5 THEN 'ผู้จัดการระบบ'
        ELSE NULL
      END
    ) type_name,
    (
      CASE
        WHEN a.type_id = 1 THEN 'success'
        WHEN a.type_id = 2 THEN 'primary'
        WHEN a.type_id = 3 THEN 'danger'
        WHEN a.type_id = 4 THEN 'warning'
        WHEN a.type_id = 5 THEN 'info'
        ELSE NULL
      END
    ) type_color,
    CONCAT(b.firstname ,' ',b.lastname) fullname
    FROM cash.cash_authorize a
    LEFT JOIN cash.`user` b
    ON a.login_id = b.login
    WHERE a.status = 1 ";

    if (!empty($keyword)) {
      $sql .= " AND (b.firstname LIKE '%{$keyword}%' OR b.lastname LIKE '%{$keyword}%') ";
    }

    if ($filter_order) {
      $sql .= " ORDER BY {$column[$order_column]} {$order_dir} ";
    } else {
      $sql .= " ORDER BY a.`status` ASC, a.type_id ASC ";
    }

    $sql2 = "";
    if ($limit_length) {
      $sql2 .= "LIMIT {$limit_start}, {$limit_length}";
    }

    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $filter = $stmt->rowCount();
    $stmt = $this->dbcon->prepare($sql . $sql2);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($result as $row) {
      $action = "<a href='javascript:void(0)' class='badge badge-danger font-weight-light btn-delete' id='{$row['id']}'>ลบ</a>";
      $type = "<span class='badge badge-{$row['type_color']} font-weight-light'>{$row['type_name']}</span>";
      $data[] = [
        $action,
        $type,
        $row['fullname'],
      ];
    }

    $output = [
      "draw" => $draw,
      "recordsTotal" =>  $total,
      "recordsFiltered" => $filter,
      "data"  => $data
    ];
    return $output;
  }

  public function user_select($keyword)
  {
    $sql = "select a.id `id`,
    concat(b.firstname,' ',b.lastname) `text`
    from cash.login a 
    left join cash.`user` b
    on a.id = b.login 
    where a.status = 1";
    if (!empty($keyword)) {
      $sql .= " and (b.firstname like '%{$keyword}%' OR b.lastname like '%{$keyword}%' OR a.email like '%{$keyword}%') ";
    }
    $sql .= " order by b.firstname asc ";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
