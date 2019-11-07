<?php
header('Content-type: application/json');
if($_SERVER["REQUEST_METHOD"] == "GET"){
  // Include config file
  require_once "../config.php";
  if (isset($_GET['id']) && !empty(trim($_GET["id"]))) { // aca hay que devolver el usuario específico.
    $sql = "SELECT * FROM employees WHERE id = ?";// Prepare a select statement
    if($stmt = mysqli_prepare($link, $sql)){
      mysqli_stmt_bind_param($stmt, "i", $param_id);// Bind variables to the prepared statement as parameters
      $param_id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);// Set parameters
      if(mysqli_stmt_execute($stmt)){// Attempt to execute the prepared statement
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 1){
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          echo json_encode($row);
        } else{
          $resultado['info']="La URL no contiene un parámetro de id válido.";
          echo json_encode($resultado);
        }
      } else{
        $resultado['error']="No se pudo ejecutar $sql." . mysqli_error($link);
        echo json_encode($resultado);
      }
    }
  } else {// Aca hay que devolver el listado de usuarios.
    $employees = array();
    $resultado_json = array();
    $sql = "SELECT * FROM employees";
    $indice = 0;
    if($result = mysqli_query($link, $sql)){
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          $employees["$indice"]["name"] = $row["name"];
          $employees["$indice"]["address"] = $row["address"];
          $employees["$indice"]["salary"] = $row["salary"];
          $employees["$indice"]["monthly_work_hours"] = $row["monthly_work_hours"];
          $indice++;
        }
        // Free result set
        mysqli_free_result($result);
        echo json_encode($employees);
      } else{
        $resultado['info']="No se encontraron registros.";
        echo json_encode($resultado);
      }
    } else{
        $resultado['error']="No se pudo ejecutar $sql." . mysqli_error($link);
        echo json_encode($resultado);
    }
    mysqli_close($link);
  }
}
?>
