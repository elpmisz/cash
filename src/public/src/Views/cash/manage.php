<?php
$menu = "Service";
$page = "ServiceCash";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="card shadow">
  <div class="card-header">
    <h4 class="text-center">จัดการระบบ</h4>
  </div>
  <div class="card-body">

    <div class="row justify-content-end mb-2">
      <div class="col-xl-3 mb-2">
        <a href="/cash/authorize" class="btn btn-primary btn-sm btn-block">
          <i class="fas fa-bars pr-2"></i>สิทธิ์
        </a>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-xl-12">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover manage-data">
            <thead>
              <tr>
                <th width="10%">#</th>
                <th width="10%">เลขที่เอกสาร</th>
                <th width="10%">ผู้ใช้บริการ</th>
                <th width="50%">วัตถุประสงค์</th>
                <th width="10%">วันที่</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="row justify-content-center my-3">
  <div class="col-xl-3">
    <a class="btn btn-danger btn-sm btn-block" href="/cash">
      <i class="fas fa-arrow-left pr-2"></i>หน้าหลัก
    </a>
  </div>
</div>

<?php include_once(__DIR__ . "/../layout/footer.php"); ?>