<?php session_start();
include $_SERVER['DOCUMENT_ROOT']."/svc/view/conn.php"; ?>
<table class="table mt-5 text-center">
    <!--건물리스트 출력 테이블시작-->
    <tbody>
        <tr>
            <th>순번</th>
            <!-- <th>관리번호</th> 사용자화면에서는 이거 안보여줌-->
            <th>유형</th>
            <th>물건명</th>
            <th>수납방법</th>
            <th>그룹명(관리호수)</th>
            <th>기타상품</th>
            <th>특이사항</th>
            <th class="mobile"></th>
        </tr>
        <?php
    $sql1 = "SELECT
      ordered,
      building.id,
      lease_type,
      bName,
      pay,
      etc
     from
      (select @num :=0)a,
      building left join user on building.user_id = user.id
     where building.user_id = {$_SESSION['id']}
     order by
      ordered"; //세션아이디로 건물정보 호출하는거
    $result1 = mysqli_query($conn, $sql1);
    // echo $sql1;
    // print_r($result);
    while($row1 = mysqli_fetch_array($result1)){
      $escaped1 = array(
        'ordered' => htmlspecialchars($row1['ordered']),
        'id' => htmlspecialchars($row1['id']),//건물아이디
        'lease_type' => htmlspecialchars($row1['lease_type']),
        'bName' => htmlspecialchars($row1['bName']),
        'pay' => htmlspecialchars($row1['pay']),
        'etc' => htmlspecialchars($row1['etc']),
        'user_name' => htmlspecialchars($row1['user_name']),
        'created' => htmlspecialchars($row1['created']),
        'updated' => htmlspecialchars($row1['updated'])
      );
      ?>
        <tr>
            <td><?=$escaped1['ordered']?></td>
            <!-- <td><?=$escaped1['id']?></td> 건물아이디 일부러 숨김처리-->
            <td><?=$escaped1['lease_type']?></td>
            <td>
                <a href="building_edit.php?id=<?=$escaped1['id']?>"><?=$escaped1['bName']?></a>
            </td>
            <td><?=$escaped1['pay']?></td>
            <td>
                <?php
        $sql2 =
          "select * from group_in_building where building_id={$escaped1['id']}";//건물아이디로 전체정보 호출
        $result2 = mysqli_query($conn, $sql2);
        // echo $sql2;
        // print_r($result2);
        while($row2 = mysqli_fetch_array($result2)){?>
                <?php $sql_count="select count(*) from r_g_in_building where group_in_building_id={$row2['id']}";//--row2['id']는 그룹아이디로 그룹정보 호출-->
          $result_count=mysqli_query($conn, $sql_count);
          $row_count=mysqli_fetch_array($result_count);
          ?>
                <a href="b_group_room_edit.php?id=<?=$row2['id']?>" class='badge badge-info'>
                    <?=$row2['gName'],"(",$row_count[0],")"?>
                </a>
                <!--건물내그룹뱃지-->
                <?php } ?>
                <!--상주/비상주수정 모달 호출 버튼-->
                <a class="btn btn-outline-warning btn-sm" href="b_group_room_add.php?id=<?=$escaped1['id']?>">추가하기</a>
            </td>
            <!--상주/비상주 그룹추가 호출 버튼, 건물아이디에 추가해야한다-->
            <td>
                <?php $sql = "select * from good_in_building where building_id = {$escaped1['id']}";
        // echo $sql;
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)){?>
                <a href="b_good_edit.php?id=<?=$row['id']?>" class='badge badge-info'>
                    <?=$row['name']?>
                </a>
                <?php }?>
                <a class="btn btn-outline-warning btn-sm" href="b_good_add.php?id=<?=$escaped1['id']?>">추가하기</a>
            </td>
            <!--기타계약상품추가 모달 호출버튼 -->
            <td>
                <label data-toggle="tooltip" data-placement="top" class="betc" title="<?=$escaped1['etc']?>">
                    <?=mb_substr($escaped1['etc'],0,7)?>
                </label>
            </td>
            <td class="mobile">
                <form class="" action="p_building_delete.php" method="post"
                    onsubmit="if(!confirm('정말 삭제하겠습니까?')){return false;}">
                    <input type="hidden" name="id" value="<?=$escaped1['id']?>">
                    <button type="submit" class="btn btn-default">
                        <i class='far fa-trash-alt'></i>
                    </button>
                </form>
            </td>
        </tr>
        <?php
     } ?>
    </tbody>
</table>
<small class="form-text text-muted">
    . 그룹이란? 관리해야할 방 개수가 여러개일때, 편리하게 관리하도록 그룹으로 설정합니다. 예) 1층그룹 101호~120호, 2층그룹 201호~220호<br>
    . 기타상품이란? 방계약 외에 일회성으로 매출이 발생하는 상품을 말합니다. 예) 노트북대여, 회의실대여 등<br>
    . 방번호(201호, 202호 등)를 생성했다면, '세입자'화면으로 이동하여 각 세입자(또는 임차인)를 등록하세요!<br>
</small>
<!--건물리스트 출력 테이블 끝-->