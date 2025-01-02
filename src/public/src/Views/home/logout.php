<?php
session_start();
session_unset();
session_destroy();

setcookie(
  "jwt",
  "",
  time() - 3600,
  "/",
  "",
  isset($_SERVER["HTTPS"]),
  true
);

header("Location: /");
exit();
