<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php htmlspecialchars($_SESSION["pageName"]??"Login") ?></title>

<link rel="shortcut icon" href="/projects/xitTask/assets/xit_logo.png" type="image/x-icon">

<!-- font  -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

<!-- icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" integrity="sha512-ApSLB1Pd3/bZN8fWB/RG9YhN/7bd9Hkf3AGaE2mPfebjrxagjuBtx2GcgdqIlJkUzwylBo61r9Xa9NmgBI0swA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- CSS -->
  <link rel="stylesheet" href="/projects/xitTask/css/common.css">



<?php 

  if(isset($_SESSION["pageId"])){
    switch($_SESSION["pageId"]){
      case 1:
        include(__DIR__."/../cssLinks/loginCss.php");
        break;
      case 2:
        include(__DIR__."/../cssLinks/signupCss.php");
        break;
      case 3: case 7:
        include(__DIR__."/../cssLinks/dashboardCss.php");
        break;
      case 4: case 5:
        include(__DIR__."/../cssLinks/adminUserListCss.php");
        break;
      case 6:
        include(__DIR__."/../cssLinks/adminProfileCss.php");
        break;
      
    }
  }


?>




    