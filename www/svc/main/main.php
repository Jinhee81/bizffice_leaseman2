<?php
session_start();

if(!isset($_SESSION['is_login'])){
  echo "<meta http-equiv='refresh' content='0; url=/svc/login.php'>";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>리스맨홈</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
?>

    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        리스맨은 '크롬브라우저'에서 최적으로 작동합니다. 크롬브라우저에서 실행해주세요 ^__^ <a href="https://www.google.com/intl/ko/chrome/"
            class="alert-link" target="_blank">다운로드 바로가기</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include "condition.php";
include "m_customer.php";
// include "m_schedule.php"; 이건 변경되서 빼기로함
include "m_building.php";
?>
    <!-- <section class="container">
  <div class="row">
    <div class="col bg-light text-dark border border-info rounded">
      <h5>건물현황</h5>
    </div>
    <div class="col bg-light text-dark border border-info rounded">
      <h5>보낸문자리스</h5>
    </div>
  </div>
</section> -->

    <section class="container">
        <div class="card-deck mt-3">
            <div class="card">
                <!-- <img src="" class="card-img-top" alt="..."> -->
                <div class="card-header">
                    <a href="../service/customer/customer.php">
                        <h4 class="my-0 font-weight-normal">입주자</h4>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table text-center table-bordered">
                        <tr class="table-primary">
                            <td>물건명</td>
                            <td>입주자</td>
                            <td>거래처</td>
                            <td>기타</td>
                            <td>문의</td>
                        </tr>
                        <?php
          for ($i=0; $i < count($customerRows); $i++) {?>
                        <tr>
                            <td><?=$customerRows[$i][0]?></td>
                            <td><?=$customerRows[$i][1]?></td>
                            <td><?=$customerRows[$i][2]?></td>
                            <td><?=$customerRows[$i][3]?></td>
                            <td><?=$customerRows[$i][4]?></td>
                        </tr>
                        <?php }
           ?>
                    </table>
                </div>
            </div>
            <div class="card">
                <!-- <img src="" class="card-img-top" alt="..."> -->
                <div class="card-header">
                    <a href="../service/contract/contract.php">
                        <h4 class="my-0 font-weight-normal">임대계약</h4>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table text-center table-bordered">
                        <tr class="table-primary">
                            <td>물건명</td>
                            <td>그룹명</td>
                            <td class="pink">공실</td>
                            <td>입실</td>
                            <td>전체</td>
                        </tr>
                        <?php
          for ($i=0; $i < count($buildingRow); $i++) {
            for ($j=0; $j < count($buildingRow[$i][2]); $j++) {?>
                        <tr>
                            <td><?=$buildingRow[$i][1]?></td>
                            <td><?=$buildingRow[$i][2][$j][1]?></td>
                            <td class="pink empty">
                                <p class="mb-0" data-toggle="modal" data-target=".bd-example-modal-sm" name="공실"><u
                                        class="roomlist"><?=$buildingRow[$i][2][$j][5]?></u></p>
                                <input type="hidden" name="list" value="<?=$buildingRow[$i][2][$j][7]?>">
                            </td>
                            <td class="charged">
                                <p class="mb-0" data-toggle="modal" data-target=".bd-example-modal-sm" name="만실"><u
                                        class="roomlist"><?=$buildingRow[$i][2][$j][4]?></u></p>
                                <input type="hidden" name="list" value="<?=$buildingRow[$i][2][$j][6]?>">
                            </td>
                            <td><?=$buildingRow[$i][2][$j][3]?></td>
                        </tr>
                        <?php }
          }
           ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="" style="height:20px;">

        </div>
        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modaldiv"></span>내역(<span id="modalcount"></span>건)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="modalList" class="text-center"></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="card-deck">
    <div class="card">
      <div class="card-header">
          <h4 class="my-0 font-weight-normal">납부예정</h4>
        </div>
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
          <h4 class="my-0 font-weight-normal">납부완료</h4>
        </div>
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div> -->
    </section>

    <section class="container">
        <div class="card">
            <div class="card-header">
                <!-- <a href="../service/schedule/schedule.php"> -->
                <h4 class="my-0 font-weight-normal">일정보기</h4>
                <!-- </a> -->
            </div>
            <div class="card-body">
                <div id="calendar">

                </div>
            </div>
        </div>
    </section>

    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/moment.min.js"></script>
    <script src="/svc/inc/js/fullcalendar.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'month, agendaWeek'
                // right:'month,agendaWeek'//주별일정은 일단 빼기로함
            },
            // titleFormat: {
            //   month: "yyyy년 mmmm",
            //   week: "[yyyy] mmm dd일 {[yyyy] mmm dd일}",
            //   day: "yyyy년 mmm d일 dddd"
            // }, //이게 잘 안되서 주석처리함
            monthNames: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월",
                "12월"
            ],
            dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
            dayNamesShort: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
            buttonText: {
                today: "오늘",
                month: "월별",
                week: "주별",
                day: "일별",
                list: "목록"
            },
            minTime: "09:00:00",
            maxTime: "18:00:00",
            events: '/svc/service/schedule/load.php',
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
                var title = prompt('이벤트를 입력하세요.');
                if (title) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                    $.ajax({
                        url: '/svc/service/schedule/insert.php',
                        type: 'POST',
                        data: {
                            title: title,
                            start: start,
                            end: end
                        },
                        success: function() {
                            calendar.fullCalendar('refetchEvents');
                            alert('추가했습니다.');
                        }
                    })
                }
            },
            editable: true,
            eventResize: function(event) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: "/svc/service/schedule/update.php",
                    type: "POST",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        id: id
                    },
                    success: function() {
                        calendar.fullCalendar('refetchEvents');
                        alert('이벤트가 수정되었습니다.');
                    }
                })
            },

            eventDrop: function(event) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: "/svc/service/schedule/update.php",
                    type: "POST",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        id: id
                    },
                    success: function() {
                        calendar.fullCalendar('refetchEvents');
                        alert('이벤트가 수정되었습니다.');
                    }
                })
            },

            eventClick: function(event) {
                if (confirm("정말 삭제하겠습니까?")) {
                    var id = event.id;
                    $.ajax({
                        url: "/svc/service/schedule/delete.php",
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function() {
                            calendar.fullCalendar('refetchEvents');
                            alert('삭제하였습니다.');
                        }
                    });
                }
            }

        });
    })

    $('.roomlist').on('click', function() {
        var div = $(this).parent().attr('name');
        var count = $(this).text();
        var list = $(this).parent().siblings('input[name=list]').val();
        // console.log(div, list);
        $('#modaldiv').text(div);
        $('#modalcount').text(count);
        $('#modalList').text(list);
    })
    </script>
    </body>

</html>