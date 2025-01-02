<?php
$menu = "Service";
$page = "ServiceCash";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="card shadow">
  <h4 class="card-header text-center">สิทธิ์ใช้งาน</h4>
  <div class="card-body">

    <div class="row justify-content-end my-3">
      <div class="col-xl-3 mb-2">
        <input type="number" class="form-control form-control-sm text-center money">
      </div>
      <div class="col-xl-3 mb-2">
        <a href="/cash/authorize/export" target="_blank" class="btn btn-success btn-sm btn-block">
          <i class="fas fa-file-download pr-2"></i>นำข้อมูลออก
        </a>
      </div>
      <div class="col-xl-3 mb-2">
        <a href="/cash/authorize/create" class="btn btn-danger btn-sm btn-block">
          <i class="fa fa-plus pr-2"></i>เพิ่ม
        </a>
      </div>
    </div>

    <div class="row my-3">
      <div class="col-sm-12">
        <div class="table-responsive">
          <table class="table table-bordered table-hover data">
            <thead>
              <tr>
                <th width="5%">#</th>
                <th width="20%">ประเภท</th>
                <th>ชื่อ</th>
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
    <a class="btn btn-danger btn-sm btn-block" href="/cash/manage">
      <i class="fas fa-arrow-left pr-2"></i>จัดการระบบ
    </a>
  </div>
</div>

<?php include_once(__DIR__ . "/../layout/footer.php"); ?>
<script>
  filter_datatable();

  axios.post("/cash/authorize/money")
    .then((res) => {
      let result = res.data;
      if (result) {
        $(".money").val(result);
      }
    }).catch((error) => {
      console.log(error);
    });

  $(document).on("blur", ".money", function() {
    let money = $(this).val();
    if (money) {
      axios.post("/cash/authorize/money-update", {
          money: money
        })
        .then((res) => {
          let result = res.data;
          if (parseInt(result) === 200) {
            Swal.fire(
              "ดำเนินการเรียบร้อย!",
              "",
              "success"
            ).then(function() {
              location.reload();
            })
          }
        }).catch((error) => {
          console.log(error);
        });
    }
  });


  $(document).on("click", ".btn-delete", function(e) {
    let id = $(this).prop('id');
    e.preventDefault();
    Swal.fire({
      title: 'ต้องการที่จะลบ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ปิด',
    }).then((result) => {
      if (result.value) {
        axios.post("/cash/authorize/delete", {
            id: id
          })
          .then((res) => {
            let result = res.data;
            if (parseInt(result) === 200) {
              Swal.fire(
                "ดำเนินการเรียบร้อย!",
                "",
                "success"
              ).then(function() {
                location.reload();
              })
            } else {
              Swal.fire(
                "ระบบมีปัญหา\nกรุณาลองอีกครั้ง!",
                "",
                "error"
              ).then(function() {
                location.reload();
              })
            }
          }).catch((error) => {
            console.log(error);
          });
      } else {
        return false;
      }
    })
  });

  function filter_datatable() {
    $(".data").DataTable({
      serverSide: true,
      searching: false,
      order: [],
      ajax: {
        url: "/cash/authorize/data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 1],
        className: "text-center",
      }, {
        targets: [2],
        className: "text-left",
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