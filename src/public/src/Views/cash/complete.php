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
$files = $CASH->file_view([$uuid]);
?>

<div class="card shadow">
  <h4 class="card-header text-center">เบิกเงินสำรอง</h4>
  <div class="card-body">

    <form action="#" method="POST" class="needs-validation" novalidate>
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

      <?php if (!empty($row['payment'])) : ?>
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
      <?php endif; ?>

      <?php if (!empty($row['receive'])) : ?>
        <hr class="border-dark border-2 my-2">

        <div class="row">
          <div class="col-xl-6">
            <div class="row mb-2">
              <label class="col-xl-2 offset-xl-1 col-form-label">การคืนเงิน</label>
              <div class="col-xl-4 text-center text-underline">
                <?php echo $row['receive_name'] ?>
              </div>
            </div>
          </div>

          <div class="col-xl-6">
            <div class="row mb-2">
              <label class="col-xl-2 col-form-label">จำนวนเงิน</label>
              <div class="col-xl-4 text-center text-underline">
                <?php echo number_format($row['receive'], 2) ?>
              </div>
              <label class="col-xl-2 col-form-label">บาท</label>
            </div>
          </div>

          <div class="col-xl-10">
            <div class="row mb-2">
              <label class="col-xl-2 ml-5 col-form-label">เอกสารแนบ</label>
              <div class="col-xl-6">
                <table class="table-sm file">
                  <?php foreach ($files as $file) : ?>
                    <tr>
                      <td class="text-left">
                        <a href="/src/Publics/files/<?php echo $file['name'] ?>" class="badge badge-primary font-weight-light" target="_blank">ดาวน์โหลด</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (COUNT($remarks) > 0) : ?>
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
                          <td class="text-left"><?php echo str_replace("\n", "<br>", $remark['text']) ?></td>
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
      <?php endif; ?>

      <div class="row justify-content-center">
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