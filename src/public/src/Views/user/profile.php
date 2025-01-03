<?php
$menu = "User";
$page = "UserProfile";
include_once(__DIR__ . "/../layout/header.php");

use App\Classes\User;

$USER = new User();

$row = $USER->user_view([$email, $email]);
?>

<div class="row">
  <div class="col-xl-12">
    <div class="card shadow">
      <div class="card-header">
        <h4 class="text-center">รายละเอียด</h4>
      </div>
      <div class="card-body">
        <form action="/user/profile" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">

          <div class="row mb-2" style="display: none;">
            <label class="col-xl-2 offset-xl-2 col-form-label">UUID</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="uuid" value="<?php echo $row['uuid'] ?>" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-2 col-form-label">อีเมล</label>
            <div class="col-xl-4 text-underline">
              <?php echo $row['email'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-2 col-form-label">ชื่อ</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="firstname" value="<?php echo $row['firstname'] ?>" required>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-2 col-form-label">นามสกุล</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="lastname" value="<?php echo $row['lastname'] ?>" required>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-2 col-form-label">ติดต่อ</label>
            <div class="col-xl-4">
              <textarea class="form-control form-control-sm" name="contact" rows="4"><?php echo $row['contact'] ?></textarea>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-2 col-form-label">ผู้จัดการ / ผู้อนุมัติ</label>
            <div class="col-xl-4 text-underline">
              <?php echo $row['manager_name'] ?>
            </div>
          </div>

          <div class="row justify-content-center mb-2">
            <div class="col-xl-3 mb-2">
              <button type="submit" class="btn btn-sm btn-success btn-block">
                <i class="fas fa-check pr-2"></i>ยืนยัน
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<?php include_once(__DIR__ . "/../layout/footer.php"); ?>