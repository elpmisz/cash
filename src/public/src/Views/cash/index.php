<?php
$menu = "Service";
$page = "ServiceCash";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="row">
  <div class="col-xl-12">
    <div class="card shadow">
      <div class="card-header">
        <h4 class="text-center">ระบบเบิกสำรองจ่าย</h4>
      </div>
      <div class="card-body">

        <div class="row justify-content-end mb-2">
          <div class="col-xl-3 mb-2">
            <a href="/cash/manage" class="btn btn-primary btn-sm btn-block">
              <i class="fas fa-bars pr-2"></i>จัดการระบบ
            </a>
          </div>
          <div class="col-xl-3 mb-2">
            <a href="/cash/create" class="btn btn-success btn-sm btn-block">
              <i class="fas fa-plus pr-2"></i>เพิ่ม
            </a>
          </div>
        </div>

        <div class="row my-3">
          <div class="col-sm-12">
            <div class="card shadow">
              <div class="card-header">
                <h4 class="text-center">รอการเงินดำเนินการ</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover finance-data">
                    <thead>
                      <tr>
                        <th width="10%">#</th>
                        <th width="10%">เลขที่เอกสาร</th>
                        <th width="10%">ผู้ใช้บริการ</th>
                        <th width="40%">วัตถุประสงค์</th>
                        <th width="10%">ยอดรวม</th>
                        <th width="10%">วันที่</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row my-3">
          <div class="col-sm-12">
            <div class="card shadow">
              <div class="card-header">
                <h4 class="text-center">รอผู้จัดการการเงินดำเนินการ</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover manager-finance-data">
                    <thead>
                      <tr>
                        <th width="10%">#</th>
                        <th width="10%">เลขที่เอกสาร</th>
                        <th width="10%">ผู้ใช้บริการ</th>
                        <th width="40%">วัตถุประสงค์</th>
                        <th width="10%">ยอดรวม</th>
                        <th width="10%">วันที่</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row my-3">
          <div class="col-sm-12">
            <div class="card shadow">
              <div class="card-header">
                <h4 class="text-center">รายการรออนุมัติดำเนินการ</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover approve-data">
                    <thead>
                      <tr>
                        <th width="10%">#</th>
                        <th width="10%">เลขที่เอกสาร</th>
                        <th width="10%">ผู้ใช้บริการ</th>
                        <th width="40%">วัตถุประสงค์</th>
                        <th width="10%">ยอดรวม</th>
                        <th width="10%">วันที่</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row my-3">
          <div class="col-sm-12">
            <div class="card shadow">
              <div class="card-header">
                <h4 class="text-center">รายการรอผู้จัดการดำเนินการ</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover manager-data">
                    <thead>
                      <tr>
                        <th width="10%">#</th>
                        <th width="10%">เลขที่เอกสาร</th>
                        <th width="10%">ผู้ใช้บริการ</th>
                        <th width="40%">วัตถุประสงค์</th>
                        <th width="10%">ยอดรวม</th>
                        <th width="10%">วันที่</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row my-3">
          <div class="col-sm-12">
            <div class="card shadow">
              <div class="card-header">
                <h4 class="text-center">รายการขอใช้บริการ</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover request-data">
                    <thead>
                      <tr>
                        <th width="10%">#</th>
                        <th width="10%">เลขที่เอกสาร</th>
                        <th width="10%">ผู้ใช้บริการ</th>
                        <th width="40%">วัตถุประสงค์</th>
                        <th width="10%">ยอดรวม</th>
                        <th width="10%">วันที่</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<?php include_once(__DIR__ . "/../layout/footer.php"); ?>
<script>
  filter_datatable();

  function filter_datatable() {
    $(".request-data").DataTable({
      serverSide: true,
      searching: false,
      order: [],
      ajax: {
        url: "/cash/request-data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 1],
        className: "text-center",
      }, {
        targets: [2, 3, 5],
        className: "text-left",
      }, {
        targets: [4],
        className: "text-right",
      }],
      "oLanguage": {
        "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
        "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
        "sInfoFiltered": "",
        "sSearch": "ค้นหา :",
        "oPaginate": {
          "sFirst": "หน้าแรก",
          "sLast": "หน้าสุดท้าย",
          "sNext": "ถัดไป",
          "sPrevious": "ก่อนหน้า"
        }
      },
    });

    $(".manager-data").DataTable({
      serverSide: true,
      searching: false,
      order: [],
      ajax: {
        url: "/cash/manager-data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 1],
        className: "text-center",
      }, {
        targets: [2, 3, 5],
        className: "text-left",
      }, {
        targets: [4],
        className: "text-right",
      }],
      "oLanguage": {
        "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
        "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
        "sInfoFiltered": "",
        "sSearch": "ค้นหา :",
        "oPaginate": {
          "sFirst": "หน้าแรก",
          "sLast": "หน้าสุดท้าย",
          "sNext": "ถัดไป",
          "sPrevious": "ก่อนหน้า"
        }
      },
    });

    $(".approve-data").DataTable({
      serverSide: true,
      searching: false,
      order: [],
      ajax: {
        url: "/cash/approve-data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 1],
        className: "text-center",
      }, {
        targets: [2, 3, 5],
        className: "text-left",
      }, {
        targets: [4],
        className: "text-right",
      }],
      "oLanguage": {
        "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
        "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
        "sInfoFiltered": "",
        "sSearch": "ค้นหา :",
        "oPaginate": {
          "sFirst": "หน้าแรก",
          "sLast": "หน้าสุดท้าย",
          "sNext": "ถัดไป",
          "sPrevious": "ก่อนหน้า"
        }
      },
    });

    $(".manager-finance-data").DataTable({
      serverSide: true,
      searching: false,
      order: [],
      ajax: {
        url: "/cash/manager-finance-data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 1],
        className: "text-center",
      }, {
        targets: [2, 3, 5],
        className: "text-left",
      }, {
        targets: [4],
        className: "text-right",
      }],
      "oLanguage": {
        "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
        "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
        "sInfoFiltered": "",
        "sSearch": "ค้นหา :",
        "oPaginate": {
          "sFirst": "หน้าแรก",
          "sLast": "หน้าสุดท้าย",
          "sNext": "ถัดไป",
          "sPrevious": "ก่อนหน้า"
        }
      },
    });

    $(".finance-data").DataTable({
      serverSide: true,
      searching: false,
      order: [],
      ajax: {
        url: "/cash/finance-data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 1],
        className: "text-center",
      }, {
        targets: [2, 3, 5],
        className: "text-left",
      }, {
        targets: [4],
        className: "text-right",
      }],
      "oLanguage": {
        "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
        "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
        "sInfoFiltered": "",
        "sSearch": "ค้นหา :",
        "oPaginate": {
          "sFirst": "หน้าแรก",
          "sLast": "หน้าสุดท้าย",
          "sNext": "ถัดไป",
          "sPrevious": "ก่อนหน้า"
        }
      },
    });
  };
</script>