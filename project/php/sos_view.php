<?php
    $con = mysqli_connect("localhost", "root", "" , "gps");
    mysqli_set_charset($con , "UTF8");

    $sos_idArray = array();
    $bangle_idArray = array();
    $fireArray = array();
    $fallArray = array();
    $leakArray = array();
    $etcArray = array();
    $messageArray = array();
    $response_timeArray = array();
    $checkedArray = array();
    
    $result = mysqli_query($con, "SELECT * from sos");
    $response = array();

    while($row = mysqli_fetch_array($result)){
        array_push($sos_idArray, $row[0]);
        array_push($bangle_idArray, $row[1]);
        array_push($fireArray, $row[2]);
        array_push($fallArray, $row[3]);
        array_push($leakArray, $row[4]);
        array_push($etcArray, $row[5]);
        array_push($messageArray, $row[6]);
        array_push($response_timeArray, $row[7]);
        array_push($checkedArray, $row[8]);
    }
    mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>선박 검색</title>
    <script src="../js/prefixfree.min.js"></script>
    <script src="../js/search_ship.js"></script>
    <script src="../js/search_person.js"></script>
    <script src="../js/search_ship_map.js"></script>
    <script src="../js/indoor_ship.js"></script>
    <script src="../js/person_move.js"></script>
    <script src="../js/link2.js"></script>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/person22.css">
    <link rel="stylesheet" href="../css/mobile1.css">
    <link rel="stylesheet" href="../css/sos.css">
</head>

<body>
    <div id="wrap">
        <!-- header영역 -->
        <header id="header">
            <div class="nav">
                <ul>
                    <li class = "home"><a href="../index.html"><i class="fas fa-home"></i>Home</a></li>
                    <li onclick = "search_ship();"><i class="fas fa-ship"></i>선박 검색</li>
                    <li onclick = "search_person();"><i class="fas fa-user"></i>승객검색</li>
                    <li onclick = "indoor_ship();"><i class="fas fa-eye"></i>내부구조도 보기</li>
                    <li onclick = "person_move();"><i class="fas fa-running"></i>승객 동선 검색</li>
                    <li><a href="sos_view.php"><i class="far fa-bell"></i>SOS 신호 보기</a></li>
                </ul>
            </div>
        </header>
        <!-- container영역 -->
        <div id="container">
            <div class="area">
                <h1>승객 위치기반 서비스</h1>
            </div>
            <div id="map">
            <script>
                var sos_id = '<?php echo json_encode($sos_idArray);?>';
                var sos_id1 = JSON.parse(sos_id);
                var bangle_id = '<?php echo json_encode($bangle_idArray);?>';
                var bangle_id1 = JSON.parse(bangle_id);
                var fire = '<?php echo json_encode($fireArray);?>';
                var fire1 = JSON.parse(fire);
                var fall = '<?php echo json_encode($fallArray);?>';
                var fall1 = JSON.parse(fall);
                var leak = '<?php echo json_encode($leakArray);?>';
                var leak1 = JSON.parse(leak);
                var etc = '<?php echo json_encode($etcArray);?>';
                var etc1 = JSON.parse(etc);
                var message = '<?php echo json_encode($messageArray);?>';
                var message1 = JSON.parse(message);
                var response_time = '<?php echo json_encode($response_timeArray);?>';
                var response_time1 = JSON.parse(response_time);
                var checked = '<?php echo json_encode($checkedArray);?>';
                var checked1 = JSON.parse(checked);

                var str = "<div class = 'sos_view'>"
                str += "<h1 class = 'sos_name'>SOS 's information</h1>"
                str += "<table><tr><th class = 't1'>번호</th><th class = 't2'>팔찌번호</th><th class = 't3'>화재</th><th class = 't4'>실족</th><th class = 't5'>누수</th><th class = 't6'>기타</th><th class = 't7'>내용</th><th class = 't8'>시간</th><th class = 't9'>체크 여부</th><th class = 't10'>수신확인</th></tr>"
                var j =1;
                console.log(sos_id1);
                for(var i = 0;i<sos_id1.length;i++){
                    
                    if(fire1[i] == "1"){
                        fire1[i] = "화재";
                        // fire1[i] = document.write("<i class="fas fa-fire"></i>");
                    }
                    if(fall1[i] == "1"){
                        fall1[i] = "추락사";
                    }
                    if(leak1[i] == "1"){
                        leak1[i] = "누수";
                    }
                    if(etc1[i] == "1"){
                        etc1[i] = "기타";
                    }
                    if(fire1[i] == "0"){
                        fire1[i] = "";
                    }
                    if(fall1[i] == "0"){
                        fall1[i] = "";
                    }
                    if(leak1[i] == "0"){
                        leak1[i] = "";
                    }
                    if(etc1[i] == "0"){
                        etc1[i] = "";
                    }
                    if(checked1[i] == "0"){
                        checked1[i] = "미확인";

                    }
                    if(checked1[i] == "1"){
                        checked1[i] = "확인완료";
                        str += "<tr>"
                        str += "<td>" + sos_id1[i] + "</td> <td>" + bangle_id1[i] + "</td> <td>" + fire1[i] + "</td> <td>" +fall1[i] +"</td> <td>" +leak1[i]+ "</td> <td>" +etc1[i]+"</td> <td>" +message1[i]+"</td> <td>" +response_time1[i]+"</td> <td>" +checked1[i]+"</td><td></td>"
                        str += "</tr>"
                        // j++;
                    }else  {
                        str += "<tr>"
                        str += "<td>" + sos_id1[i] + "</td> <td>" + bangle_id1[i] + "</td> <td>" + fire1[i] + "</td> <td>" +fall1[i] +"</td> <td>" +leak1[i]+ "</td> <td>" +etc1[i]+"</td> <td>" +message1[i]+"</td> <td>" +response_time1[i]+"</td> <td>" +checked1[i]+"</td><td><a href ='http://202.31.147.236/webstandard/캡스톤/php/update.php?check="+sos_id1[i]+"'>체크</a></td>"
                        str += "</tr>"
                    
                        // j++;
                    }
                    
                    // str += "<tr>"
                    // str += "<td>" + sos_id1[i] + "</td> <td>" + bangle_id1[i] + "</td> <td>" + fire1[i] + "</td> <td>" +fall1[i] +"</td> <td>" +leak1[i]+ "</td> <td>" +etc1[i]+"</td> <td>" +message1[i]+"</td> <td>" +response_time1[i]+"</td> <td>" +checked1[i]+"</td><td><a href ='http://202.31.147.236/webstandard/캡스톤/php/update.php?check="+j+"'>체크</a></td>"
                    // str += "</tr>"
                
                    // j++;
                }
                str +="</table>"
                str +="</div>"
                document.write(str);
             </script>

            </div>
        </div>
        <!-- footer영역 -->
        <div id="footer">
            <div class="area">
                <p class = "tle"><strong>Follow Us</strong></p>
                <dl>
                    <dt class = "sd">Sns Link</dt>
                    <dd><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></dd>
                    <dd><a href="https://twitter.com/?lang=ko"><i class="fab fa-twitter-square"></i></a></dd>
                    <dd><a href="https://www.google.co.kr/?hl=ko"><i class="fab fa-google-plus-g"></i></a></dd>
                    <dd><a href="https://www.instagram.com/?hl=ko"><i class="fab fa-instagram"></i></a></dd>
                </dl>
                <p class = "copy">Powered by 4힉년 2반</a></p>
                <p class = "logout"><a href="logout.php">로그아웃</a></p>
                <p class = "up"><a href="#header"><i class="far fa-hand-point-up"></i>위로<i class="far fa-hand-point-up"></i></a></p>
            </div>
        </div>

        <!-- 선박검색 -->
        <div id="search_ship">
            <div class="nav">
                <h1>선박 검색</h1>
                <form action="search_ship.php" method = "get">
                    <p>
                        <label for="ship">선박 목록 : </label>
                        <select name="ship" id="ship">
                            <option value="성민호">성민호</option>
                            <option value="구택호">구택호</option>
                            <option value="치원호">치원호</option>
                            <option value="훈하호">훈하호</option>
                            <option value="우리호">우리호</option>
                            <option value="민국호">민국호</option>
                            <option value="대한호">대한호</option>
                            <option value="부산호">부산호</option>
                            <option value="제주호">제주호</option>
                            <option value="마라도호">마라도호</option>
                            <option value="민석호">민석호</option>
                            <option value="홍로호">홍로호</option>
                            <option value="석찬호">석찬호</option>
                            <option value="연식호">연식호</option>
                            <option value="bit호">bit호</option>
                            <option value="상준호">상준호</option>
                            <option value="이호">이호</option>
                            <option value="지훈호">지훈호</option>
                            <option value="꼬동호">꼬동호</option>
                            <option value="너무힘들호">너무힘들호</option>
                            <option value="수상해호">수상해호</option>
                            <option value="인생호">인생호</option>
                            <option value="헤이호">헤이호</option>
                            <option value="로컬호">로컬호</option>
                            <option value="수상호">수상호</option>
                            <option value="이상해호">이상해호</option>
                            <option value="정다운호">정다운호</option>
                            <option value="건희호">건희호</option>
                            <option value="즐거운호">즐거운호</option>
                            <option value="정다운2호">정다운2호</option>
                            <option value="정다운3호">정다운3호</option>
                            <option value="정다운4호">정다운4호</option>
                            <option value="즐거운2호">즐거운2호</option>
                            <option value="즐거운3호">즐거운3호</option>
                            <option value="태극기호">태극기호</option>
                            <option value="태극기1호">태극기1호</option>
                            <option value="태극기2호">태극기2호</option>
                            <option value="태극기3호">태극기3호</option>
                            <option value="태극기4호">태극기4호</option>
                            <option value="태극기5호">태극기5호</option>
                            <option value="태극기6호">태극기6호</option>
                            <option value="해커톤호">해커톤호</option>
                            <option value="해커톤1호">해커톤1호</option>
                            <option value="해커톤2호">해커톤2호</option>
                            <option value="해커톤3호">해커톤3호</option>
                            <option value="해커톤4호">해커톤4호</option>
                            <option value="해커톤5호">해커톤5호</option>
                            <option value="해커톤6호">해커톤6호</option>
                            <option value="해커톤7호">해커톤7호</option>
                            <option value="해커톤8호">해커톤8호</option>
                            <option value="헤이호">헤이호</option>
                            <option value="헤이1호">헤이1호</option>
                            <option value="헤이2호">헤이2호</option>
                            <option value="헤이3호">헤이3호</option>
                            <option value="헤이4호">헤이4호</option>
                        </select>
                    </p>
                    <div class ="button_menu">
                        <button class = "ok" type = "submit">검색</button>
                        <button class = "del">취소</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 승객검색 -->
        <div id="search_person">
            <div class="nav">
                <h1>승객 검색</h1>
                <form action="search_person.php" method = "get">
                    <p>
                        <label for="name">찾고싶은 승객 이름 : </label>
                        <input type="text" id = "name" name = name value ="">
                    </p>
                    <div class ="button_menu">
                        <button class = "ok" type = "submit">검색</button>
                        <button class = "del">취소</button>
                    </div>
                </form>
            </div>
        </div>
         <!-- 내부 구조도 보기 -->
         <div id="indoor_ship">
                <div class="nav">
                    <h1>내부구조도 보기</h1>
                    <form  action="" method = "get" id="choose_ship">
                        <p>
                            <label for="ship_id">선박 목록 : </label>
                            <select name="ship_id" id="ship_id">
                                <option value="1">성민호</option>
                                <option value="2">구택호</option>
                            </select>
                        </p>
                        <div class ="button_menu">
                            <button class = "ok" type = "submit" id = "ts">검색</button>
                            <button class = "del">취소</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 승객 동선 검색 -->
            <div id="person_move">
                <div class="nav">
                    <h1>승객 동선 검색</h1>
                    <form action="person_move.php" method = "get">
                        <p>
                            <label for="name">승객 이름 : </label>
                            <input type="text" id = "name" name = name value ="">
                        </p>
                        <div class ="button_menu">
                            <button class = "ok" type = "submit">검색</button>
                            <button class = "del">취소</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</body>
</html>

