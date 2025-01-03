<?php
$menu = "Service";
$page = "ServiceCash";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="card shadow">
  <h4 class="card-header text-center">ระบบเบิกสำรองจ่าย</h4>
  <div class="card-body">

    <form action="/cash/create" method="POST" class="needs-validation" novalidate>
      <div class="row">
        <div class="col-xl-12">
          <div class="row mb-2" style="display: none;">
            <label class="col-xl-2 offset-xl-1 col-form-label">LoginID</label>
            <div class="col-xl-4">
              <input type="number" class="form-control form-control-sm" name="login_id" value="<?php echo $user['login_id'] ?>" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-1 col-form-label">ผู้ใช้บริการ</label>
            <div class="col-xl-4 text-underline">
              <?php echo $user['fullname'] ?>
            </div>
          </div>
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
                    <tr class="tr-input">
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success increase-input">+</button>
                        <button type="button" class="btn btn-sm btn-danger decrease-input">-</button>
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm" name="item_text[]" required>
                        <div class="invalid-feedback">
                          กรุณา กรอกข้อมูล!
                        </div>
                      </td>
                      <td>
                        <input type="number" class="form-control form-control-sm text-right item-amount" name="item_amount[]" step="0.01" required>
                        <div class="invalid-feedback">
                          กรุณา กรอกข้อมูล!
                        </div>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2" class="text-right">
                        <h5>ยอดรวม:</h5>
                      </td>
                      <td>
                        <h5 class="text-right" id="total-amount"></h5>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-2 offset-xl-1 col-form-label">วัตถุประสงค์</label>
            <div class="col-xl-6">
              <textarea class="form-control form-control-sm" rows="5" name="objective" required></textarea>
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
  $(".decrease-input").hide();
  $(document).on("click", ".increase-input", function() {
    let row = $(".tr-input:last");
    let clone = row.clone();
    clone.find("input").val("");
    clone.find(".increase-input").hide();
    clone.find(".decrease-input").show();
    row.after(clone);
    updateTotal();
  });

  $(document).on("click", ".decrease-input", function() {
    if ($(".tr-input").length > 1) {
      $(this).closest("tr").remove();
      updateTotal();
    }
  });

  $(document).on("blur", ".item-amount", function() {
    updateTotal();
  });

  function updateTotal() {
    let total = 0;
    $(".item-amount").each(function() {
      total += parseFloat($(this).val()) || 0;
    });
    $("#total-amount").text(formatNumber(total.toFixed(2)));
  }

  function formatNumber(num) {
    const parts = num.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join('.');
  }
</script>