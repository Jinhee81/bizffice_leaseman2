function fnUpload(){
  var extArray = new Array('hwp', 'xls', 'xlsx', 'doc', 'docx', 'pdf', 'jpg', 'jpeg', 'gif', 'png', 'txt', 'ppt', 'pptx', 'tiff');
  var path = $('#upfile').val();
  console.log(path);

  if(path===""){
    alert('파일을 선택해주세요.');
    return false;
  }

  var pos = path.lastIndexOf(".");
  if(pos < 0){
    alert('확장자가 없는 파일입니다.');
    return false;
  }

  var ext = path.slice(path.lastIndexOf(".")+1).toLowerCase();
  var checkExt = false;
  for (var i = 0; i < extArray.length; i++) {
    if(ext === extArray[i]){
      checkExt = true;
      break;
    }
  }
  // console.log(ext, checkExt);

  if(checkExt === false){
    alert('업로드할수있는 확장자가 아닙니다.');
    return false;
  }

  var f = $('#uploadForm');
  f.submit();

}  //uploadBtn function closing}
