<?php
        $conn = mysqli_connect("localhost", "root", "","info1");
        mysqli_set_charset($conn, "UTF8");
        $result = mysqli_query($conn,"SELECT * FROM info1");

        $title = array();
        $id = array();
        $x = array();
        $y = array();
        $outport = array();
        $inport = array();
    
        while($row = mysqli_fetch_array($result)){
            array_push($title, $row[0]);
            array_push($id, $row[1]);
            array_push($x, $row[2]);
            array_push($y, $row[3]);
            array_push($outport, $row[4]);
            array_push($inport, $row[5]);
        }                              
?>
<body>
<div id="map">
 <script src = '//dapi.kakao.com/v2/maps/sdk.js?appkey=31f6c924f8cacbc895955daba5fbccd7'></script>
 <script>
        var mapContainer = document.getElementById('map'), // 지도를 표시할 div  
        mapOption = { 
        center: new daum.maps.LatLng(36.3504119, 127.38454750000005), // 지도의 중심좌표
        level: 13 // 지도의 확대 레벨
        };

        var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

        // 마커 이미지의 이미지 주소입니다
        var seeimageSrc = 'http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/marker_red.png';
        var imageSrc = 'http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png'; 

        var title = '<?php echo json_encode($title);?>';
        var title1 = JSON.parse(title);
        var id = '<?php echo json_encode($id);?>';
        var id1 = JSON.parse(id);
        var x = '<?php echo json_encode($x);?>';
        var x1 = JSON.parse(x);
        var y = '<?php echo json_encode($y);?>';
        var y1 = JSON.parse(y);
        var outport = '<?php echo json_encode($outport);?>';
        var outport1 = JSON.parse(outport);
        var inport = '<?php echo json_encode($inport);?>';
        var inport1 = JSON.parse(inport);
    
        for(var i = 0; i < title1.length; i++){
            var imageSize = new daum.maps.Size(10, 20); 
    
            var markerPosition  = new daum.maps.LatLng(x1[i], y1[i]);
            // 마커 이미지를 생성합니다    
            var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize); 
             // 마커를 생성합니다
            var marker = new daum.maps.Marker({
                map: map, // 마커를 표시할 지도
                position: markerPosition, // 마커를 표시할 위치
                title : title1[i], // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
                id : id1[i],
                image : markerImage // 마커 이미지 
            });
            
            var infowindow = new daum.maps.InfoWindow({
                content: '<div><p>배이름 : ' + title1[i] + '</p><p>출항지 : ' + outport1[i] +'</p><p>입항지 : ' + inport1[i]  // 인포윈도우에 표시할 내용
            });

             daum.maps.event.addListener(marker, 'click', makeOverListener(map, marker, infowindow));
             daum.maps.event.addListener(marker, 'rightclick', makeOutListener(infowindow));
        }     
                              
        // 인포윈도우를 표시하는 클로저를 만드는 함수입니다 
        function makeOverListener(map, marker, infowindow) {
            return function() {
                infowindow.open(map, marker);
            };
        }

        // 인포윈도우를 닫는 클로저를 만드는 함수입니다 
        function makeOutListener(infowindow) {
            return function() {
                infowindow.close();
            };
        }
</script>
</div>
</body>          
              

