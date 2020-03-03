<?php
session_start();

require_once 'include/config.php';

if(!isset($_SESSION['done'])){
  header("location: login.php");
}

if($_SESSION['done']==1){
  //$error_msg = 'Anda telah menyelesaikan kuis.';
  header("location: login.php");
}

$query = mysqli_query( $link, "select * from tb_setting;");
$setting = mysqli_fetch_assoc($query);

$username=$_SESSION['username'];
$name=$_SESSION['nama'];
$team=$_SESSION['team'];


$_SESSION['hours'] = 1;
$_SESSION['minutes'] = 0;
$_SESSION['seconds'] = 0;

$hours = $_SESSION['hours'];
$hours = $hours * 1000 * 60 * 60;

$minutes = $_SESSION['minutes'];
$minutes = $minutes * 1000 * 60;

$seconds = $_SESSION['seconds'];
$seconds = $seconds * 1000;

$countDown = time() + $hours + $minutes + $seconds;
$remaining = $countDown - time();

$hours_remaining = floor(($remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
$minutes_remaining = floor(($remaining % (1000 * 60 * 60)) / (1000 * 60));
$seconds_remaining = floor(($remaining % (1000 * 60)) / 1000);

$timeout_remaining = $remaining / 1000;

// header( "refresh:$timeout_remaining;url=wherever.php" );

// echo '<script type="text/javascript">';
// echo 'document.write("Hello World!")';
// echo '</script>';

?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Quiz Application</title>
  <link rel="icon" href="" type="image/png" />

  <meta name="description" content="Quiz Application">
  <meta name="keywords" content="HTML,PHP,MySQL,JavaScript,Quiz,Web,Application">
  <meta name="author" content="Made Indra Wira Pramana">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap-reboot.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap-grid.min.css" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">


  <script src="js/bootstrap.min.js" type="text/javascript"></script>
  <script src="js/jquery.min.js" type="text/javascript"></script>
  <!-- <script src="js/timer.js" type="text/javascript"></script> -->

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
  
  <style type="text/css">
  /*phone layout and less*/
  @media (max-width: 575.98px) {
    .container{
      width: 100%;
    }
  }

  /*tablet layout and less*/
  @media (max-width: 768px) {
    .navbarlist{
      display: none;
    }
  }

  /*tablet layout and up*/
  @media (min-width: 768px) {
    .container{
      width: 50%;
    }
  }
  </style>

</head>
  <body style="font-family: 'Roboto', sans-serif; background-color: #f5f5f5;">

  <!-- <nav class="navbar navbar-default" style="background-color: #ffffff;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Quiz Application</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right navbarlist">
      <li><a href="#"><span class="fa fa-user"></span> <?php echo $_SESSION['nama']; ?></a></li>
    </ul>
  </div>
</nav> -->

<div class="container" style="padding: 5% 0%; margin: 0 auto; ">
  
  <div class="card">
    
    <div class="card-header bg-primary text-white">
      <i class="fa fa-user"></i> <?php echo $name." (".$team.")" ;?>
      <span id="timeleft" style="float:right;" class="d-inline"><i class="fa fa-clock-o"></i> Sisa waktu: <span id="timer" class="d-inline">
      </span>
    </span>
    </div>

    <div id="question_body" class="card-body" style="font-size: 11pt; text-align: justify;">
      <form class="form-horizontal" role="form" method="post" action="result.php">
          
          <!-- Text Setting Division -->
          <!-- Opened -->
          <span id="textsetting-opened" style="font-size: 14pt; text-align: left;">Pengaturan Teks
          <span style="float:right;">
            <button id='left' class='left btn btn-outline-secondary' type='button'><i class="fa fa-align-left"></i></button>
            <button id='center' class='center btn btn-outline-secondary' type='button'><i class="fa fa-align-center"></i></button>
            <button id='right' class='right btn btn-outline-secondary' type='button'><i class="fa fa-align-right"></i></button>
            <button id='justify' class='justify btn btn-outline-secondary' type='button'><i class="fa fa-align-justify"></i></button>
            <button id='decrease' class='decrease btn btn-outline-secondary' type='button'><i class="fa fa-compress"></i></button>
            <button id='increase' class='increase btn btn-outline-secondary' type='button'><i class="fa fa-expand"></i></button>
            <button type='button' id='setting-close' class='setting btn btn-link'><span class="fa fa-angle-double-up"></span></button>
          </span><br><br></span>
          
          <!-- Closed -->  
          <span id="textsetting-closed" style="font-size: 14pt; text-align: left; display: none">
            <span style="float:right;">
              <button type='button' id='setting-open' class='setting btn btn-link'><span class="fa fa-angle-double-down"></span></button>
            </span>
            <br>
          </span>
           

          <?php
          $question_per_page = 1;
          $question_limit = $setting['total_question'];
          
          $row = mysqli_query( $link, "select id_question, question_name, question_image, option1, option2, option3, option4, option5, answer from tb_question ORDER BY RAND() LIMIT $question_limit");
          $rowcount = mysqli_num_rows( $row );
          $remainder = $rowcount/$question_per_page;
          $i = 0;
          $j = 1;
          $k = 1;
          ?>

          <input type="text" id="question_limit" value="<?php echo $question_limit; ?>" readonly hidden>
          <?php while ( $result = mysqli_fetch_assoc($row) ) {
             if ( $i == 0) echo "<div class='cont' id='question_splitter_$j'>";?>
            <div class="form-group" id='question<?php echo $k;?>' style="padding: 1% 5%;">
            <p class='questions' id="qname_<?php echo $j;?>"><?php if($result['question_image'])echo "<center><img src='$result[question_image]' style='max-width: 80%;'></center><br>";?><?php echo $k;?>. <?php echo $result['question_name'];?></p>
            <div class="radio">
<label><input type="radio" class="choice" value="1" id='radio1_<?php echo $result['id_question'];?>' name='<?php echo $result['id_question'];?>'/> <?php echo $result['option1'];?></label>
            </div>
            <div class="radio">
<label><input type="radio" class="choice" value="2" id='radio1_<?php echo $result['id_question'];?>' name='<?php echo $result['id_question'];?>'/> <?php echo $result['option2'];?></label>
            </div>
            <div class="radio">
<label><input type="radio" class="choice" value="3" id='radio1_<?php echo $result['id_question'];?>' name='<?php echo $result['id_question'];?>'/> <?php echo $result['option3'];?></label>
            </div>
            <div class="radio">
<label><input type="radio" class="choice" value="4" id='radio1_<?php echo $result['id_question'];?>' name='<?php echo $result['id_question'];?>'/> <?php echo $result['option4'];?></label>
            </div>
            <div class="radio">
<label><input type="radio" class="choice" value="5" id='radio1_<?php echo $result['id_question'];?>' name='<?php echo $result['id_question'];?>'/> <?php echo $result['option5'];?></label>
            </div>
            <div class="radio">
<input type="radio" checked='checked' style='display:none' value="0" id='radio1_<?php echo $result['id_question'];?>' name='<?php echo $result['id_question'];?>'/>
            </div>
            </div><center>
            <?php
               $i++; 
               if ( ( $remainder < 1 ) || ( $i == $question_per_page && $remainder == 1 ) ) {
                echo "<br><br><button id='".$j."' class='btn btn-outline-primary' type='submit' onClick=\"return confirm('Anda yakin ingin menyelesaikan quiz?');\">Selesai</button>";
                echo "</div>";
               }  elseif ( $rowcount > $question_per_page  ) {
                if ( $j == 1 && $i == $question_per_page ) {
                  echo "<button id='".$j."' class='next btn btn-outline-secondary' type='button'>Selanjutnya</button>";
                  echo "</div>";
                  $i = 0;
                  $j++;           
                } elseif ( $k == $rowcount ) { 
                  echo "<button id='".$j."' class='previous btn btn-outline-secondary' type='button'>Sebelumnya</button>
                        <br><br><button id='".$j."' class='btn btn-outline-primary' type='submit' onClick=\"return confirm('Anda yakin ingin menyelesaikan quiz?');\">Selesai</button>";
                  echo "</div>";
                  $i = 0;
                  $j++;
                } elseif ( $j > 1 && $i == $question_per_page ) {
                  echo "<button id='".$j."' class='previous btn btn-outline-secondary' type='button'>Sebelumnya</button>
                                  <button id='".$j."' class='next btn btn-outline-secondary' type='button' >Selanjutnya</button>";
                  echo "</div>";
                  $i = 0;
                  $j++;
                }
                
               }
                $k++;
               } ?> 

               </center>
        </form>
    </div>
    <div class="card-footer bg-primary text-white">
      <!-- Navigation -->
               <center>
              <table>
                <tr>
                  <?php 
                  $page_button = 1;
                    while($page_button <= $rowcount){
                      echo "<td style='text-align: center;'><button class='jump btn btn-block btn-outline-light' id='button_$page_button' name='$page_button' type='button'>$page_button</button></td>";
                       
                       if($page_button % 10 == 0){
                        echo "</tr>";
                        echo "<tr>";
                       }

                       $page_button++;
                    }
                  ?>
                </tr>
              </table>
            </center>
    </div>
  </div>

<?php

if(isset($_POST[1])){ 
   $keys=array_keys($_POST);
   $order=join(",",$keys);
   
   //$query="select * from questions id IN($order) ORDER BY FIELD(id,$order)";
  // echo $query;exit;
   
   $response=mysqli_query($link, "select id_question,answer from tb_question where id_question IN($order) ORDER BY FIELD(id_question,$order)") or die(mysqli_error($link));
   $right_answer=0;
   $wrong_answer=0;
   $unanswered=0;
   while($result=mysqli_fetch_array($response)){
       if($result['answer']==$_POST[$result['id_question']]){
               $right_answer++;
           }else if($_POST[$result['id_question']]==0){
               $unanswered++;
           }
           else{
               $wrong_answer++;
           }
       
   }
   
   
   echo "right_answer : ". $right_answer."<br>";
   echo "wrong_answer : ". $wrong_answer."<br>";
   echo "unanswered : ". $unanswered."<br>";
}
?>

</div>
<script type="text/javascript">
  // Set the date we're counting down to
var hours = <?php echo $_SESSION['hours']; ?>;
hours = hours * 1000 * 60 * 60;

var minutes = <?php echo $_SESSION['minutes']; ?>;
minutes = minutes * 1000 * 60;

var seconds = <?php echo $_SESSION['seconds']; ?>;
seconds = seconds * 1000;

//setTimeout(function(){ alert("Waktu Habis"); }, hours+minutes+seconds);

setTimeout(function() { $("form").submit(); }, hours+minutes+seconds);

var countDownDate = new Date().getTime()+hours+minutes+seconds;

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays_remaining date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days_remaining, hours_remaining, minutes_remaining and seconds_remaining
    // var days_remaining = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours_remaining = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes_remaining = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds_remaining = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="timer"
    // document.getElementById("timer").innerHTML = days_remaining + " Hari " + hours_remaining + " Jam "
    // + minutes_remaining + " Menit " + seconds_remaining + " Detik ";
    
    document.getElementById("timer").innerHTML = hours_remaining + " Jam "
    + minutes_remaining + " Menit " + seconds_remaining + " Detik ";

    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("timeleft").innerHTML = "<i class='fa fa-clock-o'></i> Waktu Habis";
    }
}, 1000);

</script>

<script>
    // Randomizer & Navigation Script
    $('.cont').hide();

    $('#question_splitter_1').show();   
     
    $(document).on('click','.next',function(){
        last=parseInt($(this).attr('id'));  console.log( last );   
        nex=last+1;
        $('#question_splitter_'+last).hide();        
        $('#question_splitter_'+nex).show();
    });
    
    $(document).on('click','.previous',function(){
        last=parseInt($(this).attr('id'));     
        pre=last-1;
        $('#question_splitter_'+last).hide();
        $('#question_splitter_'+pre).show();  
    });

    $(document).on('click','.jump',function(){
      var z;
      var question_limit = document.getElementById("question_limit").value;
      for (z = 1; z <= question_limit; z++) { 
        if($('question_splitter_'+z+':visible')){
          $('#question_splitter_'+z).hide();
        }
      }

      str = $(this).attr('id');
      split = str.split("_").pop();
      jumpto = parseInt(split);
      
      $('#question_splitter_'+jumpto).show();
  });
    
    $(document).on('click','.choice',function(){
      str = $('.questions:visible').attr('id');
      split = str.split("_").pop();
      number = parseInt(split);
      
      if(!$('#button_'+number).hasClass("btn-warning")){
        $('#button_'+number).removeClass("btn-outline-light");
        $('#button_'+number).addClass("btn-warning");
      }
    });

    // Text Setting Script
    $(document).on('click','.setting',function(){
      $("#textsetting-opened").toggle();
      $("#textsetting-closed").toggle();
    });


    $(document).on('click','.left',function(){
      $(".form-group").css({'text-align':'left'});
      $(".left").removeClass("btn-outline-secondary");
      $(".left").addClass("btn-secondary");

      $(".center").removeClass("btn-secondary");
      $(".center").addClass("btn-outline-secondary");
      $(".right").removeClass("btn-secondary");
      $(".right").addClass("btn-outline-secondary");
      $(".justify").removeClass("btn-secondary");
      $(".justify").addClass("btn-outline-secondary");
    });

    $(document).on('click','.center',function(){
      $(".form-group").css({'text-align':'center'});
      $(".center").removeClass("btn-outline-secondary");
      $(".center").addClass("btn-secondary");

      $(".left").removeClass("btn-secondary");
      $(".left").addClass("btn-outline-secondary");
      $(".right").removeClass("btn-secondary");
      $(".right").addClass("btn-outline-secondary");
      $(".justify").removeClass("btn-secondary");
      $(".justify").addClass("btn-outline-secondary");
    });

    $(document).on('click','.right',function(){
      $(".form-group").css({'text-align':'right'});
      $(".right").removeClass("btn-outline-secondary");
      $(".right").addClass("btn-secondary");

      $(".left").removeClass("btn-secondary");
      $(".left").addClass("btn-outline-secondary");
      $(".center").removeClass("btn-secondary");
      $(".center").addClass("btn-outline-secondary");
      $(".justify").removeClass("btn-secondary");
      $(".justify").addClass("btn-outline-secondary");
    });

    $(document).on('click','.justify',function(){
      $(".form-group").css({'text-align':'justify'});
      $(".justify").removeClass("btn-outline-secondary");
      $(".justify").addClass("btn-secondary");

      $(".left").removeClass("btn-secondary");
      $(".left").addClass("btn-outline-secondary");
      $(".center").removeClass("btn-secondary");
      $(".center").addClass("btn-outline-secondary");
      $(".right").removeClass("btn-secondary");
      $(".right").addClass("btn-outline-secondary");
    });

    $(document).on('click','.decrease',function(){
      var fontSize = parseInt($("#question_body").css("font-size"));
      fontSize = fontSize - 1 + "px";
      $("#question_body").css({'font-size':fontSize});
    });

    $(document).on('click','.increase',function(){
      var fontSize = parseInt($("#question_body").css("font-size"));
      fontSize = fontSize + 1 + "px";
      $("#question_body").css({'font-size':fontSize});
    });
  </script>

</body>
</html>

