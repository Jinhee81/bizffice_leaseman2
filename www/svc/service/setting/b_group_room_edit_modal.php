<?php
// session_start();
// header('Content-Type: text/html; charset=UTF-8');
?>

 <div class="modal fade" id="roomAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalScrollableTitle">관리번호 추가</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <table class="table table-bordered text-center">
           <tr>
             <td width="30%">물건명</td>
             <td width="70%"><input class="form-control text-center" type="text" name="building_name" value="<?=$row['bName'].'('.$row['bid'].')'?>" disabled></td>
           </tr>
           <tr>
             <td>그룹명</td>
             <td><input class="form-control text-center" type="text" name="gName" value="<?=$row['gName']?>" disabled></td>
           </tr>
           <tr>
             <td>추가개수(숫자)</td>
             <td><input class="form-control text-center" type="number" min="1" max="100" name="mcount" required=""></td>
           </tr>
           <tr>
             <td>시작번호</td>
             <td>
               <div class="form-row">
                 <div class="form-group col-md-4">
                   <input class="form-control text-center" type="text" name="mahead" placeholder="문자입력">
                 </div>
                 <div class="form-group col-md-4">
                   <input class="form-control text-center" type="number" name="msNumber" placeholder="숫자입력">
                 </div>
                 <div class="form-group col-md-4">
                   <input class="form-control text-center" type="text" name="mtail" value="호">
                 </div>
               </div>
               <div class="form-row">
                 <div class="form-group col-md-4">
                   <button class="btn btn-outline-success btn-block" type="button" name="btnroomAdd">생성</button>
                 </div>
                 <div class="form-group col-md-4">
                   <button class="btn btn-outline-success btn-block" type="button" name="mbtnCansel">취소</button>
                 </div>
               </div>
               </td>
           </tr>
         </table>
         <div class="container" id="mbelow_rooms">
         </div><!--생성하기버튼 누르면 여기에 방번호가 쫙 나온다-->
       </div>
       <!-- <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
         <button type="button" class="btn btn-primary">추가하기</button>
       </div> -->
     </div>
   </div>
 </div>
