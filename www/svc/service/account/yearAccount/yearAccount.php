<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

 ?>
<?php
session_start();
if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>연도별회계조회</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/main/condition.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/contract/building.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/account/flexCost/yearMonth.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/service/account/yearAccount/monthlyValue.php";
?>

    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h2 class="">연도별 회계조회 화면입니다!</h2>
            <p class="lead">
                <!-- (1) 상태(진행 - 현재 계약 진행 중), (대기 - 곧 계약시작임), (종료 - 종료된 계약)로 구분합니다.<br>
      (2) 월이용료를 클릭하면 해당 계약의 상세페이지가 나옵니다.<br>
      (3) 단계는 (clear-계약을 입력하자마자), (청구- 언제돈입금예정인지 설정), 입금(이용료(임대료)가 입금되고있는 상태)로 구분됩니다. -->
            </p>
        </div>
    </section>


    <section class="container">
        <!--조회조건 섹<-->
        <div class="p-3 mb-2 bg-light text-dark border border-info rounded">
            <form name="building">
                <div class="form-group row justify-content-md-center">
                    <div class="col-sm-2 pl-0 pr-1">
                        <select class="form-control form-control-sm selectCall" name="building">
                        </select>
                        <!---->
                    </div>
                    <div class="col-sm-2 pl-0 pr-1">
                        <select class="form-control form-control-sm selectCall" name="year">
                            <option value="<?=$yearArray[0]?>">
                                <?=$yearArray[0].'년'?>
                            </option>
                            <option value="<?=$yearArray[1]?>">
                                <?=$yearArray[1].'년'?>
                            </option>
                            <option value="<?=$yearArray[2]?>" selected>
                                <?=$yearArray[2].'년'?>
                            </option>
                            <option value="<?=$yearArray[3]?>">
                                <?=$yearArray[3].'년'?>
                            </option>
                        </select>
                        <!---->
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!--히든 섹션 시작-->
    <!-- <section class="container">
  <h3>처음 로딩시 데이타</h3>
  <div id="plus_part">
  </div>
  <div id="minus_part">
  </div>
</section> -->

    <!--히든 섹션 시작-->
    <!-- <section class="container">
  <h3>데이타</h3>
  <div id="plus_part2">
  </div>
  <div id="minus_part2">
  </div>
  <div id="basic">
  </div>
</section> -->

    <!--차트 섹션 시작-->
    <section class="container">
        <div class="">
            <canvas id="barChart"></canvas>
        </div>
    </section>
    <!--차트 섹션 끝-->

    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php"; ?>

    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/jquery-ui.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/datepicker-ko.js"></script>
    <script src="/svc/inc/js/mdb.min.js"></script>
    <!--차트만들때 필요함-->

    <script type="text/javascript">
    var buildingArray = <?php echo json_encode($buildingArray); ?>;
    var groupBuildingArray = <?php echo json_encode($groupBuildingArray); ?>;
    var roomArray = <?php echo json_encode($roomArray); ?>;
    // console.log(buildingArray);
    // console.log(groupBuildingArray);
    // console.log(roomArray);
    </script>

    <script src="/svc/inc/js/etc/building2.js?<?=date('YmdHis')?>"></script>
    <script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>

    <!-- <script>
var plusAmountArray = <?php echo json_encode($plusAmountArray); ?>;
var minusAmountArray = <?php echo json_encode($minusAmountArray); ?>;
$('#plus_part').text(plusAmountArray);
$('#minus_part').text(minusAmountArray);
</script> -->

    <script>
    function barChartFn() { //bar function start
        var plusAmountArray = [];
        var minusAmountArray = [];
        var buildingIdx = $('select[name=building]').val();
        var year = $('select[name=year]').val();

        $.ajax({
            url: 'ajax_monthlyValue.php',
            method: 'post',
            data: {
                buildingIdx: buildingIdx,
                year: year
            },
            success: function(data) {
                data = JSON.parse(data);
                for (var i = 0; i < data[0].length; i++) {
                    plusAmountArray.push(data[0][i]);
                }

                for (var i = 0; i < data[1].length; i++) {
                    minusAmountArray.push(data[1][i]);
                }
                $('#plus_part2').html(plusAmountArray.toString());
                $('#minus_part2').html(minusAmountArray.toString());
                // console.log(plusAmountArray);

                var ctxB = document.getElementById("barChart").getContext('2d');
                var myBarChart = new Chart(ctxB, {
                    type: 'bar',
                    data: {
                        labels: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월',
                            '12월'
                        ],
                        datasets: [{
                            label: '매출',
                            data: [plusAmountArray[0], plusAmountArray[1], plusAmountArray[
                                    2], plusAmountArray[3], plusAmountArray[4],
                                plusAmountArray[5], plusAmountArray[6], plusAmountArray[
                                    7], plusAmountArray[8], plusAmountArray[9],
                                plusAmountArray[10], plusAmountArray[11]
                            ],
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }, {
                            label: '매입',
                            data: [minusAmountArray[0], minusAmountArray[1],
                                minusAmountArray[2], minusAmountArray[3],
                                minusAmountArray[4], minusAmountArray[5],
                                minusAmountArray[6], minusAmountArray[7],
                                minusAmountArray[8], minusAmountArray[9],
                                minusAmountArray[10], minusAmountArray[11]
                            ],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255,99,132,1)',
                            borderWidth: 1

                        }],
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        if (parseInt(value) >= 1000) {
                                            return value.toString().replace(
                                                /\B(?=(\d{3})+(?!\d))/g, ",");
                                        } else {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return tooltipItem.yLabel.toString().replace(
                                        /\B(?=(\d{3})+(?!\d))/g, ",");
                                },
                            }
                        }
                    }
                });

                return myBarChart;
            }
        });
    } //bar function end





    $(document).ready(function() {
        barChartFn();
    })


    $('select[name=building]').on('change', function() {
        barChartFn()

    })

    $('select[name=year]').on('change', function() {
        barChartFn()
    })
    </script>


    </body>

</html>