<?php
  function checkUserIsLogged($conn)
  {
    // Check if all session variables are set
    if (!isset($_SESSION["id"], $_SESSION["loginString"]))
      return false;
    
    $idUser = $_SESSION["id"];
    $loginString = $_SESSION["loginString"];
    $passwordHash = "";
      
    $SQL = "
      SELECT password 
      FROM tduser
      WHERE iduser = ?
      LIMIT 1
    ";
    
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param('i', $idUser);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1)
    {
      $stmt->bind_result($passwordHash);
      $stmt->fetch();
      
      $loginStringCheck = hash('sha512', $passwordHash . $_SERVER['HTTP_USER_AGENT']);
      
      if (hash_equals($loginStringCheck, $loginString))
        return true;
    }
    
    return false;
  }

  function checkUserIsLoggedOrDie($conn)
  {
    if (!checkUserIsLogged($conn))
    {
      $conn->close();
      return false;
    }
    return true;
  }

?>