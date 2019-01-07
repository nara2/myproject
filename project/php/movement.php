<?php
	$con = mysqli_connect("localhost", "root", "","gps");
	mysqli_set_charset($con, "UTF8");

	$bangle_id = $_GET["bangle_id"];
	$ship_id = $_GET["ship_id"];
	$case = $_GET["case"];

	$timeArray = array();
	$idArray = array();
	$nameArray = array();
	$sectionArray = array();
	$shipIdArray = array();
	$caseArray = array();

	$result = mysqli_query($con, "SELECT mv.time, mv.bangle_id, us.user_name, be.beacon_section, be.ship_id FROM beacon be, movement mv, user us where mv.request_major = be.beacon_major and be.ship_id = '$ship_id' and us.bangle_id= '$bangle_id' and mv.bangle_id = '$bangle_id' order by 1;");
	$response = array();

	while($row = mysqli_fetch_array($result)){
		array_push($response, array("<br>mv.time"=>$row[0], "mv.bangle_id"=>$row[1], "us.user_name"=>$row[2], "be.beacon_section"=>$row[3], "be.ship_id"=>$row[4]));
		array_push($timeArray, $row[0]);
		array_push($idArray, $row[1]);
		array_push($nameArray, $row[2]);
		array_push($sectionArray, $row[3]);
		array_push($shipIdArray, $row[4]);
  }
	mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>승객 동선 검색</title>
    <script src="../js/prefixfree.min.js"></script>
    <script src="../js/search_ship.js"></script>
    <script src="../js/search_person.js"></script>
    <script src="../js/search_ship_map.js"></script>
    <script src="../js/indoor_ship.js"></script>
    <script src="../js/person_move.js"></script>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/movement_person1.css">
    <link rel="stylesheet" href="../css/mobile1.css">
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
                var time = '<?php echo json_encode($timeArray);?>';
                var time1 = JSON.parse(time);
                var id = '<?php echo json_encode($idArray);?>';
                var id1 = JSON.parse(id);
                var name = '<?php echo json_encode($nameArray);?>';
                var name1 = JSON.parse(name);
                var section = '<?php echo json_encode($sectionArray);?>';
                var section1 = JSON.parse(section);
                var shipId = '<?php echo json_encode($shipIdArray);?>';
                var shipId1 = JSON.parse(shipId);
                var casetype = '<?php echo json_encode($case);?>';
                casetype = JSON.parse(casetype);

                var na = "<?=$bangle_id?>";
                var str = "<div class = 'See_view'>"
                str += "<h1 class = 'use_name'>" + na + "'s movement</h1>"
                str += "<table><tr><th>TIME</th><th>BANGLE_ID</th><th>NAME</th><th>SECTION</th><th>SHIP_ID</th></tr>"

                for(var i = 0;i<id1.length;i++ ){
                    str += "<tr>"
                    str += "<td>" + time1[i] + "</td> <td>" + id1[i] + "</td> <td>" + name1[i] + "</td> <td>" +section1[i] +"</td> <td>"+ shipId1[i] +"</td> </tr>"

                }

                str +="</table></div>"

                document.write(str);
                if(casetype==1){
                    document.write("<a class = 'back' style=\"display: block\" href=\"http://x.x.x.x/webstandard/캡스톤/php/search_person.php?name="+name1[0] +"\">뒤로가기</a>");
                }
                else{
                    document.write("<a class = 'back' style=\"display: block\" href=\"http://x.x.x.x/webstandard/캡스톤/php/person_move.php?name="+name1[0] +"\">뒤로가기</a>");
                }
                // str +="</table></div>"

                // document.write(str);
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
                <p class = "copy">Powered by 4학년 2반</a></p>
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
                    <form action="indoor_ship.php" method = "get">
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
