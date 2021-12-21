<?php

  ini_set("allow_url_fopen", true);

  // 팝빌 커넥트 Request Body
  $json_string = file_get_contents('php://input');

  // 커넥트 메시지 Json parse
  $connect_message = json_decode($json_string, true);

  // 추가적인 커넥트 메시지 항목은 하단의 [커넥트 이벤트 메시지 구성] 참조
  $connect_message['eventType']; // 이벤트 유형
  $connect_message['eventDT']; // 이벤트 실행일시

  // 커넥트 Request에 대한 응답 메시지 반환
  echo "{'result':'OK'}";
?>