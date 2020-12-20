<?php
$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];
$time = $_GET['time'];

$date = "{$year}년{$month}월{$day}일";
//date("Y-m-d", strtotime((string)$year."-".(string)$month."-".(string)$day));

$Check = false;
?>
<script type="text/javascript">
    function formCheck()
    {
        //alert("asdsad");
        // var bCheck = confirm("이름: " + document.forms[0].name.value + "\n" + 
        //                      "휴대폰 뒷번호: " + document.forms[0].phone.value + "\n" +
        //                      "선택날짜: " + "<?php echo $year ?>" + "년" + "<?php echo $month ?>" + "월 " + "<?php echo $day ?>" + "일 " + "<?php echo $time ?>" + "시\n" +
        //                     //// + "년 " + "<?php echo $month ?>" + "월 " + "<?php echo $day ?>" +
        //                     "코스: " + document.forms[0].course.value + "\n" +
        //                     "요청사항: " + document.forms[0].request.value);

        var bCheck = confirm("예약ㄱㄱ?");
        // if ( !isset($_POST["name"]) )
        // {
        //     document.write("이름을 입력해");
            
        //     return false;
        // }
        // else
        // {
        //     return false;
        // }


        if ( bCheck )
        {
            //document.getElementById('frm').submit();
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<!DOCTYPE html>
<html>
<head>
    <title>예약하기</title>
</head>
<body>    
<?php 
echo "<i>르쏨 컨설턴트가 승인을 해야 확정 됩니다.(확정 시 문자 발송)</i>";
echo '<br>선택한 날짜는 '.$year.'년 '.$month.'월 '.$day.'일 '.$time.' 시입니다.'; 
?>
<!-- <form method="POST" action="cal_new.php" name="frm" onsubmit = "return confirm('예약하시겠습니까?');"> -->
<form method="POST" action="cal_new.php" name="frm" onsubmit = "return formCheck();">
<p>이름*</p>
<input type="text" name="name" placeholder="name" maxlength="5">
<p>휴대폰 번호(예약자 대표 번호)*</p>
<input type="text" name="phone1" placeholder="010" maxlength="3" size = 2 oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
- <input type="text" name="phone2" placeholder="1234" maxlength="4" size = 3 oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
- <input type="text" name="phone3" placeholder="5678" maxlength="4" size = 3 oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

<p>코스*</p>
<select name="course">
    <option value="">코스 선택</option>
    <option value="branding1">퍼스널브랜딩(1인)</option>
    <option value="makeup1">컬러&메이크업(1인)</option>
    <option value="makeup2">컬러&메이크업(2인)</option>
    <option value="basic2">베이직 컬러진단(2인)</option>
    <option value="basic3">베이직 컬러진단(3인)</option>
    <option value="basic3">베이직 컬러진단(4인 이상)</option>
</select>

<p>요청사항</p>
<p><textarea style="resize: none;" name="request" rows="5" cols="40" placeholder="Insert the requests."></textarea></p>
<p><input type="hidden" name="date" value=<?=$date?>></p>
<p><input type="hidden" name="time" value=<?=$time?>></p>
<p><input type="submit" name="reserve" value="예약">
<input type="submit" name="back" value="뒤로가기"></p>

<br>
<p style="font-size:13px;"><i>더 나은 나로 피어나다, 르쏨</i></p>
<p style="font-size:12px;"><i>2020. Ressom. All Rights Reserved.</i></p>
</form>
</body>
</body>
</html>