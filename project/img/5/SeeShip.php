<?php
	$con = mysqli_connect("localhost", "root", "","gps");
	mysqli_set_charset($con, "UTF8");

	$ship_id = $_GET["ship_id"];

	$sectionArray = array();
	$shipArray = array();

	$result = mysqli_query($con, "SELECT be.beacon_major, be.beacon_section FROM bangle bn, beacon be where be.beacon_major=bn.request_major and be.ship_id = '$ship_id' and be.ship_id = bn.ship_id");
	$response = array();

	while($row = mysqli_fetch_array($result)){
  		array_push($response, array("<br>bn.bangle_id"=>$row[0], "be.beacon_section"=>$row[1]));
		array_push($sectionArray, $row[1]);
	}

	mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>내부구조도 보기</title>
    <script src="../../js/prefixfree.min.js"></script>
    <script src="../../js/search_ship.js"></script>
    <script src="../../js/search_person.js"></script>
    <script src="../../js/search_ship_map.js"></script>
    <script src="../../js/indoor_ship.js"></script>
    <script src="../../js/person_move.js"></script>
    <script src="../../js/link2.js"></script>
    <link rel="stylesheet" href="../../css/all.min.css">
    <link rel="stylesheet" href="../../css/person111.css">
	<link rel="stylesheet" href="../../css/mobile1.css">
	<style>
		#right {
			text-align: center;
			line-height: 30px;
			font-size: 30px;
			width: 100px;
			height: 30px;
			/* float: right; */
			border: 3px solid #000000;
		}
		.img-cover {
			position: absolute;
            left : 200px;
            background-color: lime;
            /* background-color: rgba(120, 0, 0, 0.4); */
            opacity: 0.3;
		}
		.tb{

		}
		#area {
			position : relative;
            /* margin-left : 800px;  */
			/* width : 60%; */
            /* width : 684px;		 */
            width : 50%;
            margin : 100px auto 0 auto;
            /* margin-top : 100px; */
            text-align : center;
            left : 40px;
            padding-right : 10px;
            /* margin-left : 10px; */
		}
		</style>
</head>
<body>
    <div id="wrap">
        <!-- header영역 -->
        <header id="header">
            <div class="nav">
                <ul>
                    <li class = "home"><a href="../../index.html"><i class="fas fa-home"></i>Home</a></li>
                    <li onclick = "search_ship();"><i class="fas fa-ship"></i>선박 검색</li>
                    <li onclick = "search_person();"><i class="fas fa-user"></i>승객검색</li>
                    <li onclick = "indoor_ship();"><i class="fas fa-eye"></i>내부구조도 보기</li>
					<li onclick = "person_move();"><i class="fas fa-running"></i>승객 동선 검색</li>
					<li><a href="../../php/sos_view.php"><i class="far fa-bell"></i>SOS 신호 보기</a></li>
                </ul>
            </div>
        </header>
        <!-- container영역 -->
        <div id="container">
            <div class="area">
                <h1>승객 위치기반 서비스</h1>
            </div>
            <div id="map">
				<div id="area">
					<img class = "tb" src="ship_1.jpg">
					<script>
                        var section = '<?php echo json_encode($sectionArray);?>';
								var section1 = JSON.parse(section);
								var ship = '<?php echo json_encode($ship_id);?>';
								ship = JSON.parse(ship);
                                var id = [
                                          ["1_단상", "width: 356px; height: 111px; left : 284px; top : 16px;", 1], // uibt
                                          ["1_홀", "width: 356px; height: 523px; left : 285px; top: 131px;", 2],
                                          ["1_포스터구역", "width: 274px; height: 248px; left : 10px; top: 406px;", 3]
                                         ];


                        for(var i =0;i<section1.length;i++) {
                            for(var j=0;j<id.length;j++){
                                if(section1[i]==id[j][0] && section1[i].substr(0,1)== "1" && ship == "5") {
								var str = "<div><a class=\"img-cover\" style=\""+ id[j][1] +"\" href=\"http://x.x.x.x/webstandard/캡스톤/php/bangleinfo.php?ship="+ship+"&beacon_major="+id[j][2]+"\"></a></div>";
								document.write(str);
							}
                            }
                        }
                    </script>

			</div>
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
                <form action="../../php/search_ship.php" method = "get">
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
                <form action="../../php/search_person.php" method = "get">
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
                    <form action="../../php/person_move.php" method = "get">
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
