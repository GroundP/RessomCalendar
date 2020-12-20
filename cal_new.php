<?php
//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('n'); // 0을 포함하지 않는 월
$today = date('j'); // 0을 포함하지 않는 일

//------ $year, $month 값이 없으면 현재 날짜
$year = isset($_GET['year']) ? $_GET['year'] : $thisyear;
$month = isset($_GET['month']) ? $_GET['month'] : $thismonth;
$day = isset($_GET['day']) ? $_GET['day'] : $today;

$resv_name = isset($_POST['name']) ? $_POST['name'] : ""; 
$resv_phone1 = isset($_POST['phone1']) ? $_POST['phone1'] : 0;
$resv_phone2 = isset($_POST['phone2']) ? $_POST['phone2'] : 0;
$resv_phone3 = isset($_POST['phone3']) ? $_POST['phone3'] : 0;
$resv_course = isset($_POST['course']) ? $_POST['course'] : "";
$resv_req = isset($_POST['request']) ? $_POST['request'] : "";
$resv_day = isset($_POST['date']) ? $_POST['date'] : "";
$resv_time = isset($_POST['time']) ? $_POST['time'] : "";

$enable_query = isset($_POST['name']) && isset($_POST['phone2']) && isset($_POST['phone3']) && isset($_POST['course']) && isset($_POST['date']) && isset($_POST['time']); 

echo $resv_day.", ".$resv_time.", ".$resv_name.", ".$resv_phone2.", ".$resv_course.", ".$resv_req."<br>";

if ( $enable_query )
{
  //echo "Enable to query! InsertDB.<br>";
  $aaa = $resv_phone1."-".$resv_phone2."-".$resv_phone3;
	InsertDB($resv_day, $resv_time, $resv_name, $aaa, $resv_course, $resv_req);
}
else
{
	echo "Unable to query!";
}

function InsertDB($resv_day, $resv_time, $resv_name, $resv_phone, $resv_course, $resv_req)
{
	echo "Inside InsertDB => ".$resv_day.", ".$resv_time.", '".$resv_name."', ".$resv_phone.", ".$resv_course.", ".$resv_req."<br>";

	$conn = mysqli_connect('127.0.0.1', 'root', '010203', 'ressom');

	if (!$conn)
	{
		echo "Unable to connect sql DB: ".mysqli_connect_error().PHP_EOL;
		exit;
	}

	$sql = "INSERT INTO reserve123 (resv_day, resv_time, name, phone, course, request) VALUES ( '{$resv_day}', {$resv_time}, '{$resv_name}', '{$resv_phone}', '{$resv_course}', '{$resv_req}')";

	//$sql = "INSERT INTO reserve123 (resv_day, resv_time, name, phone, course, request) VALUES (".$resv_day.",".$resv_time.",".$resv_name.",".$resv_phone.",".$resv_course.",".$resv_req.")";

	$result = mysqli_query($conn, $sql);
	if ( $result )
	{
		echo "Insert Success!";
	}
	else
	{
		echo "Error inserting to DB: ".mysqli_error($conn);
	}
}

function IsReserved($year, $month, $day, $time)
{
	$conn = mysqli_connect('127.0.0.1', 'root', '010203', 'ressom');

	if (!$conn)
	{
		echo "Unable to connect sql DB: ".mysqli_connect_error().PHP_EOL;
		exit;
	}

	$diffDay = "{$year}년{$month}월{$day}일";
	$sql = "SELECT * FROM reserve123 WHERE resv_day = '{$diffDay}' and resv_time = $time";

	$result = mysqli_query($conn, $sql);

	if($result->num_rows > 0)
	{
		//echo $diffDay."는 db에 있다네~";
		return true;
	}
	else
	{
		//echo $diffDay."는 db에 없다네~";
		return false;	
	}
}

function IsPast($year_, $month_, $day_)
{
	if ($year_ < date('Y'))
    	return true;

  if ( $year_ == date('Y') && $month_ < date('n'))
    	return true;

  if( $year_ == date('Y') && $month_ == date('n') && $day_ < date('j') )
		  return true;
  else
		  return false;

}

$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;

if ($month == 1) 
{
    $prev_month = 12;
    $prev_year = $year - 1;
} 
else if ($month == 12)
{
    $next_month = 1;
    $next_year = $year + 1;
}

$preyear = $year - 1;
$nextyear = $year + 1;

$predate = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year));
$nextdate = date("Y-m-d", mktime(0, 0, 0, $month + 1, 1, $year));

// 1. 총일수 구하기
$max_day = date('t', mktime(0, 0, 0, $month, 1, $year)); // 해당월의 마지막 날짜

// 2. 시작요일 구하기
$start_week = date("w", mktime(0, 0, 0, $month, 1, $year)); // 일요일 0, 토요일 6

// 3. 총 몇 주인지 구하기
$total_week = ceil(($max_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', mktime(0, 0, 0, $month, $max_day, $year));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ressom reservation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <style>
    font.holy {font-family: tahoma;font-size: 15px;color: #FF6C21;}
    font.blue {font-family: tahoma;font-size: 15px;color: #0000FF;}
    font.black {font-family: tahoma;font-size: 15px;color: #000000;}
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<table class="table table-bordered table-responsive">
  <tr align="center" >
    <td colspan="2">
        <a href=<?php echo 'cal_new.php?year='.$prev_year.'&month='.$prev_month; ?>>◀</a>
    </td>
    <td height="50" bgcolor="#FFFFFF" colspan="3">
        <a href=<?php echo 'cal_new.php?year=' . $thisyear . '&month=' . $thismonth; ?>>
        <?php echo "&nbsp;&nbsp;" . $year . '년 ' . $month . '월 ' . "&nbsp;&nbsp;"; ?></a>
    </td>
    <td colspan="2">
        <a href=<?php echo 'cal_new.php?year='.$next_year.'&month='.$next_month; ?>>▶</a>
    </td>
  </tr>
  <tr class="info">
    <th hight="10">일</th>
    <th>월</th>
    <th>화</th>
    <th>수</th>
    <th>목</th>
    <th>금</th>
    <th>토</th>
  </tr>

  <?php
    // 5. 화면에 표시할 화면의 초기값을 1로 설정
    $day=1;
    // 6. 총 주 수에 맞춰서 세로줄 만들기
    for($i=1; $i <= $total_week; $i++){?>
  <tr>
    <?php
    // 7. 총 가로칸 만들기
    for ($j = 0; $j < 7; $j++) {
        // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음

    	$isPast = IsPast($year, $month, $day);
        if ( $isPast )
        {
        	echo '<td height="80" valign="top" bgcolor=#E2E2E2>';
        }
        else
        {
			    echo '<td height="80" valign="top">';
        }

        if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))) {

            if ($j == 0) {
                // 9. $j가 0이면 일요일이므로 빨간색
                $style = "holy";
            } else if ($j == 6) {
                // 10. $j가 0이면 토요일이므로 파란색
                $style = "blue";
            } else {
                // 11. 그외는 평일이므로 검정색
                $style = "black";
            }

            
            // 12. 오늘 날짜면 굵은 글씨
            if ($year == $thisyear && $month == $thismonth && $day == date("j")) 
            {
                // 13. 날짜 출력
                echo '<b><font class='.$style.'>';
                echo $day;
                echo '</font></b>';
            } 
            else 
            {
                echo '<font class='.$style.'>';
                echo $day;
                echo '</font>';
            }

            if(!$isPast)
            {
            	if (IsReserved($year, $month, $day, 11))
            		echo '<del><div align="right"><font class="grey">11:00</font></div></del>';
            	else
            		echo '<a href='.'reserve_process.php?year='.$year.'&month='.$month.'&day='.$day.'&time=11><div align="right">11:00</div></a>';
              
              if (IsReserved($year, $month, $day, 15))
            		echo '<del><div align="right"><font class="grey">15:00</font></div></del>';
            	else
            		echo '<a href='.'reserve_process.php?year='.$year.'&month='.$month.'&day='.$day.'&time=15><div align="right">15:00</div></a>';

              if (IsReserved($year, $month, $day, 19))
            		echo '<del><div align="right"><font class="grey">19:00</font></div></del>';
            	else
            		echo '<a href='.'reserve_process.php?year='.$year.'&month='.$month.'&day='.$day.'&time=91><div align="right">19:00</div></a>';
              
            	//echo '<a href='.'reserve_process.php?year='.$year.'&month='.$month.'&day='.$day.'&time=15><div align="right">15:00</div></a>';
            	//echo '<a href='.'reserve_process.php?year='.$year.'&month='.$month.'&day='.$day.'&time=19><div align="right">19:00</div></a>';
            }
            // 14. 날짜 증가
            $day++;
        }
        echo '</td>';
    }
 ?>
  </tr>
  <?php 
} 
?>
</table>
</div>
</body>
</html>