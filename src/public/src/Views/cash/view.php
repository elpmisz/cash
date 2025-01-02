<?php
$menu = "Service";
$page = "ServiceCash";
include_once(__DIR__ . "/../layout/header.php");

use App\Classes\Cash;

$CASH = new Cash();

$param = (isset($params) ? explode("/", $params) : "");
$uuid = (!empty($param[0]) ? $param[0] : "");

$row = $CASH->request_view([$uuid]);
$items = $CASH->item_view([$uuid]);
?>

<div class="card shadow">
  <h4 class="card-header text-center">ระบบเบิกสำรองจ่าย</h4>
  <div class="card-body">

    <form action="/cash/update" method="POST" class="needs-validation" novalidate>
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
                    <?php foreach ($items as $item) : ?>
                      <tr>
                        <td class="text-center">
                          <a href="javascript:void(0)" class="badge badge-danger font-weight-light item-delete" id="<?php echo $item['id'] ?>">ลบ</a>
                          <input type="hidden" class="form-control form-control-sm" name="item__id[]" value="<?php echo $item['id'] ?>" readonly>
                        </td>
                        <td>
                          <input type="text" class="form-control form-control-sm" name="item__text[]" value="<?php echo $item['text'] ?>" required>
                        </td>
                        <td class="text-right">
                          <input type="number" class="form-control form-control-sm text-right item-amount" name="item__amount[]" value="<?php echo $item['amount'] ?>" step="0.01" required>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <tr class="tr-input">
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success increase-input">+</button>
                        <button type="button" class="btn btn-sm btn-danger decrease-input">-</button>
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm" name="item_text[]">
                        <div class="invalid-feedback">
                          REQUIRED!
                        </div>
                      </td>
                      <td>
                        <input type="number" class="form-control form-control-sm text-right item-amount" name="item_amount[]" step="0.01">
                        <div class="invalid-feedback">
                          REQUIRED!
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
            <div class="col-xl-8">
              <textarea class="form-control form-control-sm" rows="5" name="objective" required><?php echo $row['objective'] ?></textarea>
              <div class="invalid-feedback">
                REQUIRED!
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
  $(document).on("blur", "input[name='item_text']", function() {
    let text = ($(this).val() ? $(this).val() : "");
    if (text) {
      $("input[name='item_amount']").prop("required", true);
    } else {
      $("input[name='item_amount']").prop("required", false);
    }
  });

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

  $(document).on("click", ".item-delete", function(e) {
    let id = ($(this).prop("id") ? $(this).prop("id") : "");
    e.preventDefault();
    Swal.fire({
      title: "CONFIRM?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "OK",
      cancelButtonText: "CLOSE",
    }).then((result) => {
      if (result.value) {
        axios.post("/cash/item-delete", {
          id: id,
        }).then((res) => {
          let result = res.data;
          if (result === 200) {
            Swal.fire({
              title: "ดำเนินการเรียบร้อย!",
              icon: "success"
            }).then((result) => {
              if (result.value) {
                location.reload();
              } else {
                return false;
              }
            })
          } else {
            location.reload()
          }
        }).catch((error) => {
          console.log(error);
        });
      } else {
        return false;
      }
    })
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