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
  <h4 class="card-header text-center">ระบบเบิกสำรองจ่าย</h4>
  <div class="card-body">

    <form action="/cash/approve" method="POST" class="needs-validation" novalidate>
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

      <div class="row mb-2">
        <div class="col-xl-12">
          <div class="row mb-2">
            <div class="col-xl-10 offset-xl-1">
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
        <label class="col-xl-2 ml-5 col-form-label">สถานะ</label>
        <div class="col-xl-8">
          <div class="form-group pl-3 pt-2">
            <label class="form-check-label px-3">
              <input class="form-check-input" type="radio" name="status" value="3" required>
              <span class="text-success">อนุมัติ</span>
            </label>
            <label class="form-check-label px-3">
              <input class="form-check-input" type="radio" name="status" value="7" required>
              <span class="text-danger">ยกเลิก</span>
            </label>
          </div>
        </div>
      </div>
      <div class="row mb-2">
        <label class="col-xl-2 ml-5 col-form-label">เหตุผล</label>
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
  $(document).on("click", "input[name='status']", function() {
    let status = ($(this).val() ? parseInt($(this).val()) : "");
    if (status === 7) {
      $("textarea[name='reason']").prop("required", true);
    } else {
      $("textarea[name='reason']").prop("required", false);
    }
  });
</script>