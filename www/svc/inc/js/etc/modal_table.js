var table = $("table[name=tableAmount]");

// 테이블 헤더에 있는 checkbox 클릭시
$("#allselect2").change(function(){
  if($(this).is(":checked")){
    $(".tbodycheckbox2").prop('checked',true);
    $(".tbodycheckbox2").parent().parent().addClass("selected");
    // console.log('맨위체크박스 체크함');
  } else {
    $(".tbodycheckbox2").prop('checked',false);
    $(".tbodycheckbox2").parent().parent().removeClass("selected");
    // console.log('맨위체크박스 체크취소');
  }
})

$(document).on('change', '.tbodycheckbox2', function(){
  var allCnt = $(".tbodycheckbox2").length;
  var checkedCnt = $(".tbodycheckbox2").filter(":checked").length;

  // console.log(allCnt, checkedCnt);

  if($(this).is(":checked")){
    $(this).prop('checked',true);
    $(this).parent().parent().addClass("selected");
    checkedCnt = $(".tbodycheckbox2").filter(":checked").length;

    if(allCnt==checkedCnt ){
      $("#allselect2").prop("checked", true);
    } else {
      $("#allselect2").prop("checked", false);
    }
  } else {
    $(this).prop('checked',false);
    $(this).parent().parent().removeClass("selected");
    checkedCnt = $(".tbodycheckbox2").filter(":checked").length;

    if(allCnt==checkedCnt ){
      $("#allselect2").prop("checked", true);
    } else {
      $("#allselect2").prop("checked", false);
    }
  }
})