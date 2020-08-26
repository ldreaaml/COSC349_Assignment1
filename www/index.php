<!DOCTYPE html>
<html>
    <head>
        <title>TimeZone Converter</title>
        <link rel="stylesheet" href ="index.css">
    </head>
    <style>
  .error {color: #FF0000;}
  </style>
    <body>

  
      <?php        
        // UNCOMMENT
        $db_host   = '192.168.2.22';
        $db_name   = 'timezone';
        $db_user   = 'clouduser';
        $db_passwd = 'insecure_db_pw';

        $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

        $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
        
      $q = $pdo->query("SELECT name FROM  times");
      while($row = $q->fetch()){
          echo "<tr><td>".$row["name"];
      }
      
        ?>

        
      <!-- PHP validating input -->
        <?php
        //defining variables
        $time = $ampm = $localTime = $anotherTimeZone = "";
        $timeErr = $timeZone1Err = $timeZone2Err = "";
        $valid_input = false;

        if($_SERVER["REQUEST_METHOD"] == "POST") {
          $valid_input = true;
          if(empty($_POST["time"])){
            $timeErr = "Time is required";
            $valid_input = false;
          }else{
            $time = check_input($_POST["time"]);
            if(!preg_match("/^(?:1[012]|0[0-9]):[0-5][0-9](:[0-5][0-9])?$/", $time)){
              $timeErr = "invalid time";
              $valid_input = false;
            }
          }
          if(empty($_POST["localTime"])){
            $timeZone1Err = "Time Zone is required";
          }
          if(empty($_POST["anotherTimeZone"])){
            $timeZone2Err = "Time Zone is required";
          }
          
          
          
          $ampm = check_input($_POST["ampm"]);
          $localTime = check_input($_POST["localTime"]);
          $anotherTimeZone = check_input($_POST["anotherTimeZone"]);
        }

        function check_input($data){
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }

        function check_time($time){
          $time = trim($time);
          if(preg_match("/^(?:1[012]|0[0-9]):[0-5][0-9]$/", $time) == 1){
            return $time;
          }
        }
        ?>

  
   
        <section></section>
       
        <div id = "container">
           
            <h1 id="header">Time Zone Converter</h1>
           
            <div id = "clock_container">
               
                <form method="post" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                <div class ="clock" id ="clock1">
        <!--      PHP :   FORM HANDLING        -->
                     
                        <p>Time:</p>
                         <input type="text" name="time" class="input" placeholder="00:00" value=<?php echo date("h:i a"); ?>>
                          <span class="error"><?php echo $timeErr;?></span>
                        <div class="rbtn">
                              <input type="radio" name="ampm" <?php if (isset($ampm) && $ampm=="AM") echo "checked";?> value="AM" checked> AM
                              <input type="radio" name="ampm" <?php if (isset($ampm) && $ampm=="PM") echo "checked";?> value="PM"> PM
                        </div>
                   
                </div>
               
               
                <div class ="clock" id="clock2">
                    <p>From:</p>
                    <label for="localTime">
                            <select class="input">
                              <option selected disabled hidden>- choose time zone -</option>
                              <?php foreach($timezone as $tz): ?>
                                      <option value="<?= $tz['name']; ?>"></option>
                              <?php endforeach; ?>
                              
<!--                          

 <?php foreach($timezone as $tz): ?>
                                      <option value="<?= $tz['name']; ?>"></option>
                                    <?php endforeach; ?>

-->
                                           
                                   
                                    
                            </select>           
                    </label>
                    <p>To:</p>
                    <label for="anotherTimeZone">
                            <select class="input">
                             <option selected disabled hidden>- choose time zone -</option>
                             <?php foreach($timezone as $tz): ?>
                                      <option value="<?= $tz['name']; ?>"></option>
                              <?php endforeach; ?>
<!--                          
                                    <?php foreach($timezone as $tz): ?>
                                      <option value="<?= $tz['name']; ?>"><?= $user['name']; ?></option>
                                    <?php endforeach; ?>
                                    -->
                            </select>           
                    </label>
                </div>
               
               
                 <div id="result">
                    <!--<p1>11:50:29 AM in Africa/Addis_Ababa <br>converts to<br>
09:50:29 PM in Africa/Algiers</p1>-->

                <?php
                if($valid_input){
                  echo "time " . $time . " " . $ampm . " in ..." . $localTime;
                  echo "<br>converts to";
                  echo "<br>... in ... " . $anotherTimeZone;
                }
                ?>
                     
               
                </div>
               
                <input type="submit" name="submit" class="btn" value ="Convert Time">
                </form>
            </div>
           
        </div>
    </body>
</html>
