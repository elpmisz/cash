<?php
$Home = (isset($menu) && ($menu === "Home") ? "show" : "");
$HomeIndex = ($page === "HomeIndex" ? 'class="active"' : "");

$ServiceMenu = (isset($menu) && ($menu === "Service") ? "show" : "");
$ServiceCash = ($page === "ServiceCash" ? 'class="active"' : "");

$UserMenu = (isset($menu) && ($menu === "User") ? "show" : "");
$UserProfile = ($page === "UserProfile" ? 'class="active"' : "");
$UserChange = ($page === "UserChange" ? 'class="active"' : "");

$SettingMenu = (isset($menu) && ($menu === "Setting") ? "show" : "");
$SettingSystem = ($page === "SettingSystem" ? 'class="active"' : "");
$SettingUser = ($page === "SettingUser" ? 'class="active"' : "");
?>
<nav id="sidebar">
  <ul class="list-unstyled <?php echo $home ?>">
    <li <?php echo $HomeIndex ?>>
      <a href="/home">หน้าหลัก</a>
    </li>
    <li>
      <a href="#user-menu" data-toggle="collapse" class="dropdown-toggle">ข้อมูลส่วนตัว</a>
      <ul class="collapse list-unstyled <?php echo $UserMenu ?>" id="user-menu">
        <li <?php echo $UserProfile ?>>
          <a href="/user/profile">
            <i class="fa fa-address-book pr-2"></i>
            รายละเอียด
          </a>
        </li>
        <li <?php echo $UserChange ?>>
          <a href="/user/change">
            <i class="fa fa-key pr-2"></i>
            เปลี่ยนรหัสผ่าน
          </a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#service-menu" data-toggle="collapse" class="dropdown-toggle">
        บริการ
      </a>
      <ul class="collapse list-unstyled <?php echo $ServiceMenu ?>" id="service-menu">
        <li <?php echo $ServiceCash ?>>
          <a href="/cash">
            <i class="fa fa-bars pr-2"></i>
            ระบบเบิกสำรองจ่าย
          </a>
        </li>
      </ul>
    </li>
    <?php if (intval($user['level']) === 9) : ?>
      <li>
        <a href="#setting-menu" data-toggle="collapse" class="dropdown-toggle">ตั้งค่า</a>
        <ul class="collapse list-unstyled <?php echo $SettingMenu ?>" id="setting-menu">
          <li <?php echo $SettingSystem ?>>
            <a href="/system">
              <i class="fa fa-gear pr-2"></i>
              ตั้งค่าระบบ
            </a>
          </li>
          <li <?php echo $SettingUser ?>>
            <a href="/user">
              <i class="fa fa-gear pr-2"></i>
              ผู้ใช้งาน
            </a>
          </li>
        </ul>
      </li>
    <?php endif; ?>
  </ul>
</nav>