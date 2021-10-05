<?php
session_start();
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

if(!isset($_SESSION['is_login'])){
  header('Location: /svc/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>그룹/관리호수 수정</title>
    <?php
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header1_meta.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_header2.php";
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php";

$filtered_id = mysqli_real_escape_string($conn, $_GET['id']);//그룹아이디?
settype($filtered_id, 'integer');
$sql = "
    SELECT
        group_in_building.id as gid,
        group_in_building.created,
        group_in_building.updated,
        gName,
        count,
        building.bName,
        building.id as bid
    FROM group_in_building
    LEFT JOIN building
      ON group_in_building.building_id = building.id
    WHERE group_in_building.id={$filtered_id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

settype($row['bid'], 'integer');
// echo $sql;
// print_r($row);
// print_r($_SESSION);

// error_reporting(E_ALL);
//
// ini_set("display_errors", 1);

$sql2 = "select count(*) from realContract
         where group_in_building_id = {$filtered_id}
        ";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);

?>

    <style media="screen">
    th {
        vertical-align: middle;
    }
    </style>

    <section class="container">
        <div class="jumbotron pt-3 pb-3">
            <h3 class="">>> 그룹 및 관리호수 수정 화면입니다!</h3>
            <hr class="my-4">
            <p class="lead">
                (1) 그룹삭제 - 계약개수가 없으면 삭제되며, 이때 종속된 관리번호 모두 삭제됩니다. (계약개수 0)<br>
                (2) 관리호수삭제 - 계약개수가 없어야 삭제됩니다.
            </p>
            <!-- <hr class="my-4">
    <small>(1) '명칭'은 평상시 부르는 이름으로 적어주세요. 예)도레미고시원, 성공빌딩 (2) '수금방법'은 임대료를 선불로 수납할 경우 선불 선택, 후불로 수납할경우 후불을 선택하세요.</small> -->
        </div>
    </section>
    <section class="container">
        <div class="row justify-content-end pr-3 pb-2">
            <button type="button" class="btn btn-primary btn-sm mr-1" name="editbtn_group">그룹수정</button>
            <button type="button" class="btn btn-danger btn-sm" name="deletebtn_group">그룹삭제</button>
        </div>
        <table class="table table-bordered text-center" name="group">
            <tr>
                <td width="15%" class="">물건명(물건IDX,그룹IDX)</td>
                <td width="10%" class="">그룹명</td>
                <td width="10%" class="">호수개수<br>(숫자)</td>
                <td width="10%" class="">계약개수<br>(숫자)</td>
                <td width="10%" class="">등록일시</td>
                <td width="10%" class="">수정일시</td>
                <!-- <td width="5%" class=""></td> -->
            </tr>
            <tr>
                <td scope="col col-md-8"><input class="form-control text-center" type="text" name="building_name"
                        value="<?=$row['bName'].'('.$row['bid'].','.$filtered_id.')'?>" disabled></td>
                <td scope="col col-md-8"><input class="form-control text-center" type="text" name="gName" required=""
                        value="<?=$row['gName']?>"></td>
                <td scope="col col-md-8"><input class="form-control text-center" type="text" name="roomCount" disabled
                        value="<?=$row['count']?>"></td>
                <td>
                    <input class="form-control text-center" type="text" name="contractCount" disabled
                        value="<?=$row2[0]?>">
                </td>
                <td><?=$row['created']?></td>
                <td><?=$row['updated']?></td>
                <!-- <td>
        <span class="badge badge-danger" name="groupEdit">수정</span>
        <span class="badge badge-danger" name="groupDelete">삭제</span>
      </td> -->
            </tr>
        </table>

        <div class="row justify-content-end pr-3 pb-2">
            <button type="button" class="btn btn-outline-primary btn-sm" name="editbtn_room">저장</button>
            <!-- <button type="button" class="btn btn-outline-danger btn-sm" name="editbtn_room">관리호수 삭제</button> 이건은 없애기로 함, 그냥 하나하나 삭제하기로 함-->
        </div>

        <div class="mainTable">
            <table class="table table-sm table-bordered text-center" name="room">
                <thead>
                    <tr class="">
                        <!-- <th class="fixedHeader table-secondary" rowspan="2" width="5%">
            <input type="checkbox" id="allselect">
          </th> -->
                        <th class="fixedHeader table-secondary" width="5%">순번</th>
                        <th class="fixedHeader table-secondary" width="15%">관리호수</th>
                        <th class="fixedHeader table-secondary" width="10%">관리호수IDX</th>
                        <th class="fixedHeader table-primary" width="7%">현재계약</th>
                        <th class="fixedHeader table-primary" width="7%">대기계약</th>
                        <th class="fixedHeader table-primary" width="7%">종료계약</th>
                        <th class="fixedHeader table-primary" width="8%">중간종료계약</th>
                        <th class="fixedHeader table-primary" width="7%">전체계약</th>
                        <th class="fixedHeader table-secondary" width="20%">관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        $sql7 = "select
                  id as roomid,
                  ordered,
                  rName,
                  (select
                      count(*)
                   from realContract
                   where r_g_in_building_id=roomid and
                         getStatus(startDate, endDate2)='present'
                  ) as present,
                  (select
                      count(*)
                   from realContract
                   where r_g_in_building_id=roomid and
                         getStatus(startDate, endDate2)='waiting'
                  ) as waiting,
                  (select
                      count(*)
                   from realContract
                   where r_g_in_building_id=roomid and
                         getStatus(startDate, endDate2)='the_end'
                  ) as the_end,
                  (select
                      count(*)
                   from realContract
                   where r_g_in_building_id=roomid and
                         getStatus(startDate, endDate2)='middle_end'
                  ) as middle_end,
                  (select
                      count(*)
                   from realContract
                   where r_g_in_building_id=roomid
                  ) as total
                 from r_g_in_building
                 where group_in_building_id = {$filtered_id}
                 order by ordered";
        // echo $sql7;

        $result7 = mysqli_query($conn, $sql7);
        $i = 1;

        while($row7 = mysqli_fetch_array($result7)){
          ?>
                    <tr>
                        <!-- <td><input type="checkbox" class="tbodycheckbox"></td> -->
                        <td name="roomOrder"><?=$i?></td>
                        <td name="roomName">
                            <input type="text" class="form-control form-control-sm text-center"
                                value="<?=$row7['rName']?>" name="roomName">
                        </td>
                        <td name="roomId" class="grey">
                            <?=$row7['roomid']?>
                        </td>
                        <td name="pc">
                            <?php if($row7['present']>0){
                echo $row7['present'];
              } ?>
                        </td>
                        <!--present contract-->
                        <td name="wc">
                            <?php if($row7['waiting']>0){
                echo $row7['waiting'];
              } ?>
                        </td>
                        <!--waiting contract-->
                        <td name="ec">
                            <?php if($row7['the_end']>0){
                echo $row7['the_end'];
              } ?>
                        </td>
                        <!--end contract-->
                        <td name="mec">
                            <?php if($row7['middle_end']>0){
                echo $row7['middle_end'];
              } ?>
                        </td>
                        <!--middle end contract-->
                        <td name="ac">
                            <?=$row7['total']?>
                        </td>
                        <!--all contract-->
                        <td>
                            <span class="badge badge-warning" name="aboveInsert">위 삽입</span>
                            <span class="badge badge-warning" name="belowInsert">아래 삽입</span>
                            <button type="submit" class="btn btn-default" name="roomEditEach">
                                <i class='far fa-edit'></i>
                            </button>
                            <button type="submit" class="btn btn-default pl-0" name="roomDeleteEach">
                                <i class='far fa-trash-alt'></i>
                            </button>
                        </td>
                    </tr>
                    <?php
        $i += 1;
        }
        // print_r($editRooms);
        ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php include "b_group_room_edit_modal.php";?>

    <?php include $_SERVER['DOCUMENT_ROOT']."/svc/view/service_footer.php";?>
    <script src="/svc/inc/js/jquery-3.3.1.min.js"></script>
    <script src="/svc/inc/js/popper.min.js"></script>
    <script src="/svc/inc/js/bootstrap.min.js"></script>
    <script src="/svc/inc/js/etc/form.js?<?=date('YmdHis')?>"></script>

    <script>
    var aa =
        '<tr><td></td><td name="roomName"><input class="form-control form-control-sm text-center" name="roomName"></td><td></td><td></td><td></td><td></td><td></td><td></td><td class="pt-2"><span class="badge badge-danger" name="insertCansel">취소</span></td></tr>';

    $('span[name=aboveInsert]').on('click', function() {
        var currow = $(this).closest('tr');
        currow.before(aa);

        $('span[name=insertCansel]').on('click', function() {
            var currow = $(this).closest('tr');
            currow.remove();
        })
    })

    $('span[name=belowInsert]').on('click', function() {
        var currow = $(this).closest('tr');
        currow.after(aa);

        $('span[name=insertCansel]').on('click', function() {
            var currow = $(this).closest('tr');
            currow.remove();
        })
    })

    $('button[name=editbtn_group]').on('click', function() {
        var groupId = <?=$filtered_id?>;
        var groupName = $('input[name=gName]').val();

        if (groupName.length === 0) {
            alert('그룹명이 빈칸입니다. 빈칸을 채워주세요.');
            return false;
        }

        goCategoryPage(groupId, groupName);

        function goCategoryPage(a, b) {
            var frm = formCreate('group_edit', 'post', 'p_group_edit.php', '');
            frm = formInput(frm, 'groupId', a);
            frm = formInput(frm, 'groupName', b);
            formSubmit(frm);
        }
    })

    $('button[name=editbtn_room]').on('click', function() {
        var groupId = <?=$filtered_id?>;
        var roomArray = [];
        var table = $('table[name=room] tbody');
        var allCnt = table.find('tr').length;
        // console.log(allCnt);

        for (var i = 0; i < allCnt; i++) {
            var roomArrayEle = [];
            var roomName = table.find('tr:eq(' + i + ')').find('td[name=roomName]').children(
                'input[name="roomName"]').val();
            var roomId = table.find('tr:eq(' + i + ')').find('td[name=roomId]').text().trim();
            console.log(roomName);

            if (roomName.length === 0) {
                alert('관리호수가 빈칸입니다. 빈칸을 채워주세요.');
                return false;
            }

            roomArrayEle.push(roomName, roomId);
            roomArray.push(roomArrayEle);
        }

        // console.log(roomArray);
        roomArray = JSON.stringify(roomArray);

        goCategoryPage(groupId, roomArray);

        function goCategoryPage(a, b) {
            var frm = formCreate('group_room_edit', 'post', 'p_room_edit.php', '');
            frm = formInput(frm, 'groupId', a);
            frm = formInput(frm, 'roomArray', b);
            formSubmit(frm);
        }
    })

    $('button[name=roomEditEach]').on('click', function() {
        var currow = $(this).closest('tr');
        var roomId = currow.find('td[name=roomId]').text().trim();
        var roomName = currow.find('td[name=roomName]').children('input[name=roomName]').val();

        console.log(roomId, roomName);

        goCategoryPage(roomId, roomName);

        function goCategoryPage(a, b) {
            var frm = formCreate('each_room_edit', 'post', 'p_eachroom_edit.php', '');
            frm = formInput(frm, 'roomId', a);
            frm = formInput(frm, 'roomName', b);
            formSubmit(frm);
        }

    })

    $('button[name=roomDeleteEach]').on('click', function() {
        var groupId = <?=$filtered_id?>;
        var currow = $(this).closest('tr');
        var roomId = currow.find('td[name=roomId]').text().trim();
        var roomOrder = currow.find('td[name=roomOrder]').text();
        var count = $('input[name=roomCount]').val();
        var contractCount = currow.find('td[name=ac]').text().trim();

        if (Number(contractCount) > 0) {
            alert('계약건수가 존재하여 삭제 불가합니다.');
            return false;
        }

        goCategoryPage(roomId, roomOrder, count, groupId);

        function goCategoryPage(a, b, c, d) {
            var frm = formCreate('each_room_delete', 'post', 'p_eachroom_delete.php', '');
            frm = formInput(frm, 'roomId', a);
            frm = formInput(frm, 'roomOrder', b);
            frm = formInput(frm, 'count', c);
            frm = formInput(frm, 'groupId', d);
            formSubmit(frm);
        }

    })

    $('button[name=deletebtn_group]').on('click', function() {
        var groupId = <?=$filtered_id?>;
        var contractCount = $('input[name=contractCount]').val();

        var a = confirm('관리호수까지 모두 삭제됩니다. 정말 삭제하시겠습니까?');

        if (a === true) {
            if (Number(contractCount) > 0) {
                alert('계약건수가 존재하여 삭제 불가합니다. 계약을 먼저 삭제하거나 관리자에게 수정요청해주세요.');
                return false;
            }

            goCategoryPage(groupId);

            function goCategoryPage(a) {
                var frm = formCreate('group_delete', 'post', 'p_group_delete0.php', '');
                frm = formInput(frm, 'groupId', a);
                formSubmit(frm);
            }
        }


    })
    </script>

    </body>

</html>