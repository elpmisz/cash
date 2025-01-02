<?php
$menu = "Service";
$page = "ServiceCash";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="card shadow">
  <h4 class="card-header text-center">สิทธิ์ใช้งาน</h4>
  <div class="card-body">

    <form action="/cash/authorize/create" method="POST" class="needs-validation" novalidate>
      <div class="row">
        <div class="col-xl-12">
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-1 col-form-label">ประเภท</label>
            <div class="col-xl-8">
              <div class="form-group pl-3 pt-2">
                <label class="form-check-label px-3">
                  <input class="form-check-input" type="radio" name="type_id" value="1" required>
                  <span class="text-success">ผจก. การเงิน</span>
                </label>
                <label class="form-check-label px-3">
                  <input class="form-check-input" type="radio" name="type_id" value="2" required>
                  <span class="text-primary">การเงิน</span>
                </label>
                <label class="form-check-label px-3">
                  <input class="form-check-input" type="radio" name="type_id" value="3" required>
                  <span class="text-danger">ผู้อนุมัติคนที่ 1</span>
                </label>
                <label class="form-check-label px-3">
                  <input class="form-check-input" type="radio" name="type_id" value="4" required>
                  <span class="text-warning">ผู้อนุมัติคนที่ 2</span>
                </label>
                <label class="form-check-label px-3">
                  <input class="form-check-input" type="radio" name="type_id" value="5" required>
                  <span class="text-info">ผู้จัดการระบบ</span>
                </label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-1 col-form-label">รายชื่อ</label>
            <div class="col-xl-4">
              <select class="form-control form-control-sm user-select" name="user_id" required></select>
              <div class="invalid-feedback">
                กรุณา กรอกข้อมูล!
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-sm-6 col-xl-3 mb-2">
          <button type="submit" class="btn btn-success btn-sm btn-block">
            <i class="fas fa-check pr-2"></i>ยืนยัน
          </button>
        </div>
        <div class="col-sm-6 col-xl-3 mb-2">
          <a class="btn btn-danger btn-sm btn-block" href="/cash/authorize">
            <i class="fas fa-arrow-left pr-2"></i>สิทธิ์ใช้งาน
          </a>
        </div>
      </div>

    </form>

  </div>
</div>

<?php include_once(__DIR__ . "/../layout/footer.php"); ?>
<script>
  $(".user-select").select2({
    placeholder: "-- เลือก --",
    allowClear: true,
    width: "100%",
    ajax: {
      url: "/cash/authorize/user-select",
      method: "POST",
      dataType: "json",
      delay: 100,
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
</script>