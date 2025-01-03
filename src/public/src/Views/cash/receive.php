<?php
$menu = "Service";
$page = "ServiceCash";
include_once(__DIR__ . "/../layout/header.php");

use App\Classes\Cash;
use App\Classes\CashAuthorize;

$CASH = new Cash();
$AUTHORIZE = new CashAuthorize();

$param = (isset($params) ? explode("/", $params) : "");
$uuid = (!empty($param[0]) ? $param[0] : "");

$row = $CASH->request_view([$uuid]);
$items = $CASH->item_view([$uuid]);
$remarks = $CASH->remark_view([$uuid]);
?>

<div class="card shadow">
  <h4 class="card-header text-center">เบิกเงินสำรอง</h4>
  <div class="card-body">

    <form action="/cash/receive" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
      <div class="row">
        <div class="col-xl-10" style="display: none;">
          <div class=" row mb-2">
            <label class="col-xl-2 offset-xl-1 col-form-label">ID</label>
            <div class="col-xl-2">
              <input type="text" class="form-control form-control-sm" name="id" value="<?php echo $row['id'] ?>" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-1 col-form-label">UUID</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="uuid" value="<?php echo $row['uuid'] ?>" readonly>
            </div>
          </div>
        </div>

        <div class="col-xl-6">
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">ผู้ใช้บริการ</label>
            <div class="col-xl-6 text-underline">
              <?php echo $row['username'] ?>
            </div>
          </div>
        </div>

        <div class="col-xl-6">
          <div class="row mb-2">
            <label class="col-xl-3 col-form-label">เลขที่เอกสาร</label>
            <div class="col-xl-6 text-underline">
              <?php echo $row['ticket'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 col-form-label">วันที่</label>
            <div class="col-xl-6 text-underline">
              <?php echo $row['created'] ?>
            </div>
          </div>
        </div>

        <div class="col-xl-12">
          <div class="row mb-2">
            <div class="col-xl-10 offset-xl-1">
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="70%">รายการ</th>
                      <th width="20%">ยอดเงิน</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($items as $key => $item) : $key++; ?>
                      <tr>
                        <td class="text-center"><?php echo $key ?></td>
                        <td class="text-left"><?php echo $item['text'] ?></td>
                        <td class="text-right"><?php echo number_format($item['amount'], 2) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2" class="text-right">
                        <h5>ยอดรวม:</h5>
                      </td>
                      <td>
                        <h5 class="text-right" id="total-amount"><?php echo number_format($row['total'], 2) ?></h5>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-10">
          <div class="row mb-2">
            <label class="col-xl-2 ml-5 col-form-label">วัตถุประสงค์</label>
            <div class="col-xl-8 text-underline">
              <?php echo str_replace("\n", "<br>", $row['objective']) ?>
            </div>
          </div>
        </div>
      </div>

      <hr class="border-dark border-2 my-2">

      <div class="row">
        <div class="col-xl-6">
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">การจ่ายเงิน</label>
            <div class="col-xl-6 text-center text-underline">
              <?php echo $row['pay_name'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">จำนวนเงิน</label>
            <div class="col-xl-6 text-center text-underline">
              <?php echo number_format($row['payment'], 2) ?>
            </div>
            <label class="col-xl-2 col-form-label">บาท</label>
          </div>
        </div>

        <div class="col-xl-6">
          <div class="row mb-2">
            <label class="col-xl-4 col-form-label">เลขที่เช็ค (Cheque)</label>
            <div class="col-xl-6 text-underline">
              <?php echo $row['cheque'] ?>
            </div>
          </div>
        </div>
      </div>

      <hr class="border-dark border-2 my-2">

      <div class="row mb-2">
        <div class="col-xl-12">
          <div class="row mb-2">
            <div class="col-xl-10 ml-5">
              <h6>การดำเนินการ</h6>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="10%">สถานะ</th>
                      <th width="20%">ผู้ดำเนินการ</th>
                      <th width="50%">รายละเอียด</th>
                      <th width="10%">วันที่</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($remarks as $key => $remark) : $key++; ?>
                      <tr>
                        <td class="text-center"><?php echo $key ?></td>
                        <td class="text-center">
                          <?php echo "<span class='badge badge-{$remark['status_color']} font-weight-light'>{$remark['status_name']}</span>" ?>
                        </td>
                        <td class="text-left"><?php echo $remark['username'] ?></td>
                        <td class="text-left"><?php echo $remark['text'] ?></td>
                        <td class="text-left"><?php echo $remark['created'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-2">
        <label class="col-xl-2 ml-5 col-form-label">การคืนเงิน</label>
        <div class="col-xl-8">
          <div class="form-group pl-3 pt-2">
            <label class="form-check-label px-3">
              <input class="form-check-input" type="radio" name="receive_type" value="1" required>
              <span class="text-success">เหลือคืน</span>
            </label>
            <label class="form-check-label px-3">
              <input class="form-check-input" type="radio" name="receive_type" value="2" required>
              <span class="text-primary">ไม่เหลือคืน</span>
            </label>
            <label class="form-check-label px-3">
              <input class="form-check-input" type="radio" name="receive_type" value="3" required>
              <span class="text-danger">ใช้เกิน</span>
            </label>
          </div>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-xl-2 ml-5 col-form-label">จำนวนเงิน</label>
        <div class="col-xl-2">
          <input type="number" class="form-control form-control-sm text-right" name="receive" step="0.01" required>
          <div class="invalid-feedback">
            กรุณา กรอกข้อมูล!
          </div>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-xl-2 ml-5">เอกสารแนบ</label>
        <div class="col-xl-6">
          <table class="table-sm file">
            <tbody>
              <tr>
                <td>
                  <a href="javascript:void(0)" class="btn btn-success btn-sm file-increase">+</a>
                  <a href="javascript:void(0)" class="btn btn-danger btn-sm file-decrease">-</a>
                </td>
                <td>
                  <input type="file" class="form-control file-import" name="file[]" required>
                  <div class="invalid-feedback">
                    กรุณา กรอกข้อมูล!
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row mb-2">
        <span class="col-xl-6 offset-xl-2 text-danger">เฉพาะเอกสาร WORD, EXCEL, PDF หรือไฟล์รูป JPG, PNG เท่านั้น</span>
      </div>
      <div class="row mb-2">
        <label class="col-xl-2 ml-5 col-form-label">รายละเอียดเพิ่มเติม</label>
        <div class="col-sm-8">
          <textarea class="form-control" name="reason" rows="4"></textarea>
          <div class="invalid-feedback">
            กรุณา กรอกข้อมูล!
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
          <a class="btn btn-danger btn-sm btn-block" href="/cash">
            <i class="fas fa-arrow-left pr-2"></i>หน้าหลัก
          </a>
        </div>
      </div>

    </form>

  </div>
</div>

<?php include_once(__DIR__ . "/../layout/footer.php"); ?>
<script>
  $(".file-decrease").hide();
  $(document).on("click", ".file-increase", function() {
    let row = $(".file").find("tbody").find("tr:last");
    let clone = row.clone();
    clone.find("input, select").val("");
    clone.find(".file-increase").hide();
    clone.find(".file-decrease").show();
    clone.find(".file-decrease").click(function() {
      $(this).closest("tr").remove();
    });
    row.after(clone);
    clone.show();
    $(document).on("change", ".file-import", function() {
      let fileSize = $(this)[0].files[0].size / 1024 / 1024;
      let fileExtention = $(this).val().split(".").pop().toLowerCase();
      let fileAllow = ["jpg", "jpeg", "png", "pdf", "xls", "xlsx", "doc", "docx", "ppt", "pptx"];
      fileSize = fileSize.toFixed(2);
      if (fileSize > 10) {
        Swal.fire({
          icon: "error",
          title: "ไฟล์แนบ ขนาดไม่เกิน 10MB. เท่านั้น!!",
          text: "ขนาดไฟล์ที่คุณเลือก: " + fileSize + " MB",
        })
        $(this).val("");
      }

      if ($.inArray(fileExtention, fileAllow) == -1) {
        Swal.fire({
          icon: "error",
          title: "พบข้อผิดพลาด!!",
          text: "เฉพาะไฟล์ JPG JPEG PNG หรือ PDF Excel Word PowerPoint เท่านั้น!!",
        })
        $(this).val("");
      }
    });
  });

  $(document).on("change", ".file-import", function() {
    let fileSize = $(this)[0].files[0].size / 1024 / 1024;
    let fileExtention = $(this).val().split(".").pop().toLowerCase();
    let fileAllow = ["jpg", "jpeg", "png", "pdf", "xls", "xlsx", "doc", "docx", "ppt", "pptx"];
    fileSize = fileSize.toFixed(2);
    if (fileSize > 10) {
      Swal.fire({
        icon: "error",
        title: "ไฟล์แนบ ขนาดไม่เกิน 10MB. เท่านั้น!!",
        text: "ขนาดไฟล์ที่คุณเลือก: " + fileSize + " MB",
      })
      $(this).val("");
    }

    if ($.inArray(fileExtention, fileAllow) == -1) {
      Swal.fire({
        icon: "error",
        title: "พบข้อผิดพลาด!!",
        text: "เฉพาะไฟล์ JPG JPEG PNG หรือ PDF Excel Word PowerPoint เท่านั้น!!",
      })
      $(this).val("");
    }
  });
</script>