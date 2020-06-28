<div id="dialog" title="Your new avatar">
  <p>Image:<br/>
    <?php
      if(base64_encode ($_SESSION['name'].$_SESSION['id']."savedForLaterHAHA")){
        echo "<img src=".base64_encode ($_SESSION['name'].$_SESSION['id']."savedForLaterHAHA")." />";
      }
      else{
        echo "error what did you think it going to happen?";
      }
    ?>
  </div>
