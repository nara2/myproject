<?php
	$con = mysqli_connect("localhost", "root", "","gps");
	mysqli_set_charset($con, "utf8");

    $bangle_id = $_GET["bangle_id"];
    $user_name = $_GET["name"];

    $shipArray = array();
	$floorArray = array();
	$widthArray = array();
	$heightArray = array();

	$result = mysqli_query($con, "SELECT be.ship_id, be.beacon_floor, be.center_width, be.center_height FROM beacon be WHERE be.ship_id IN
	(SELECT ba.ship_id from bangle ba where ba.bangle_id = '$bangle_id') and be.beacon_major IN
		(SELECT ba.request_major from bangle ba where ba.bangle_id = '$bangle_id');");
	$response = array();

	while($row = mysqli_fetch_array($result)){
          array_push($response, array("ship_id"=>$row[0], "beacon_floor"=>$row[1], "center_width"=>$row[2], "center_height"=>$row[3]));
          array_push($shipArray, $row[0]);
          array_push($floorArray, $row[1]);
          array_push($widthArray, $row[2]);
          array_push($heightArray, $row[3]);
    }

	mysqli_close($con);
?>

<style>


	#back {
        display: block;
		text-align: center;
		line-height: 30px;
		font-size: 30px;
		width: 100px;
		height: 30px;
		border: 3px solid #000000;
        text-decoration: none;
		color: black;
        margin-top : 10px;
        margin-left : 1px;
        padding :10px;
    }

	#ar {
        position : relative;
        /* width : 20%; */
        /* min-width : 20%; */
        max-width : 65%;
        /* width : 400px; */
        margin : 100px auto 0 auto;
        /* padding-left : 100px; */
        /* padding-right : 100px; */
        text-align : center;
        left : 50px;
        /* margin-left : 800px;   */
        /* left:  */
		/* margin-top : 100px;  */
	}
</style>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>승객 검색</title>
    <script src="../js/prefixfree.min.js"></script>
    <script src="../js/search_ship.js"></script>
    <script src="../js/search_person.js"></script>
    <script src="../js/search_ship_map.js"></script>
    <script src="../js/indoor_ship.js"></script>
    <script src="../js/person_move.js"></script>
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/person19.css">
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
				var ship = '<?php echo json_encode($shipArray);?>';
				var ship1 = JSON.parse(ship);
				var floor = '<?php echo json_encode($floorArray);?>';
				var floor1 = JSON.parse(floor);
				var width = '<?php echo json_encode($widthArray);?>';
				var width1 = JSON.parse(width);
				var height = '<?php echo json_encode($heightArray);?>';
				var height1 = JSON.parse(height);
				var user_name = '<?php echo json_encode($user_name);?>';
				var name = JSON.parse(user_name);
				var bangle_id = '<?php echo json_encode($bangle_id);?>';
				var id1 = JSON.parse(bangle_id);

                // document.write("<title>결과</title>");

				document.write("<div id = 'ar'>");
				document.write("<img src=\"http://x.x.x.x/webstandard/캡스톤/img/"+ ship1[0] +"/ship_"+ floor1[0] +".jpg\">");
				document.write("<div style=\"position: absolute; top:"+ (height1[0] - 30)+"; left: "+(width1[0] -46) +";\"><a href=\"http://x.x.x.x/webstandard/캡스톤/php/movement.php?bangle_id="+ id1 +"&ship_id="+ship1[0]+"&case="+1+"\"><img src=\"http://x.x.x.x/webstandard/캡스톤/img/marker.png\"></a></div>");
				document.write("<a id=\"back\" href=\"http://x.x.x.x/webstandard/캡스톤/php/search_person.php?name="+name +"\">뒤로가기</a>");
                document.write("</div>");

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
