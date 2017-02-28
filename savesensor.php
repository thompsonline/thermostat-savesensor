<?php
  $location = isset($_GET['loc']) ? $_GET['loc'] : "";
  $temp = isset($_GET['temp']) ? $_GET['temp'] : "";
  $humid = isset($_GET['humid']) ? $_GET['humid'] : "";
  $module = isset($_GET['mod']) ? $_GET['mod'] : "";

  if (!empty($location) && !empty($temp) && !empty($module)) {
    $db = new mysqli("localhost","sensor","<password>", "Thermostat");
    if ($db->connect_errno) {
      echo "Unable to connect to database";
    } else {
      if ($stmt = $db->prepare("insert into SensorData(moduleID, location, temperature, humidity) values (?,?,?,?)")) {
        if ($stmt->bind_param("isdd", $module, $location, $temp, $humid)) {
          if (!$stmt->execute()) {
            error_log("savesensor. Unable to save. $stmt->error");
          }
        } else {
          error_log("savesensor. Unable to bind. $stmt->error");
        }
        $stmt->close();
      }
      $db->close();
    }
  } else {
    error_log("savesensor. Invalid parameter: ".print_r($_GET, true));
  }
?>
