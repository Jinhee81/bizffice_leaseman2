//이거는 계약등록하는 화면에서 필요한 js파일, 헷깔리지 말것 (building.js랑 비슷한데 내용이 더 많음)

var select2option, select3option, select4option, select5option, buildingIdx, groupIdx;
var pay = ["선납", "후납"];

for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
  select2option = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
  $('#select2').append(select2option);
}
buildingIdx = $('#select2').val();

// console.log(buildingArray[buildingIdx][1]);
select5option = "<option value='"+buildingArray[buildingIdx][1]+"'>"+buildingArray[buildingIdx][1]+"</option>";
$('#select5').append(select5option);

for (var i in pay){
  if(pay[i] != buildingArray[buildingIdx][1]){
    select5option = "<option value='"+pay[i]+"'>"+pay[i]+"</option>";
    $('#select5').append(select5option);
  }
}

for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
  select3option = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
  // console.log(select3option);
  $('#select3').append(select3option);
}
groupIdx = $('#select3').val();

for(var key3 in roomArray[groupIdx]){
  select4option = "<option value='"+key3+"'>"+roomArray[groupIdx][key3]+"</option>";
  $('#select4').append(select4option);
}
roomIdx = $('#select4').val();

$('#select2').on('change', function(event){
  buildingIdx = $('#select2').val();
  $('#select3').empty();
  for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
    select3option = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(select3option);
    $('#select3').append(select3option);
  }
  groupIdx = $('#select3').val();

  $('#select4').empty();
  for(var key3 in roomArray[groupIdx]){
    select4option = "<option value='"+key3+"'>"+roomArray[groupIdx][key3]+"</option>";
    $('#select4').append(select4option);
  }

  $('#select5').empty();
  select5option = "<option value='"+buildingArray[buildingIdx][1]+"'>"+buildingArray[buildingIdx][1]+"</option>";
  $('#select5').append(select5option);

  for (var i in pay){
    if(pay[i] != buildingArray[buildingIdx][1]){
      select5option = "<option value='"+pay[i]+"'>"+pay[i]+"</option>";
      $('#select5').append(select5option);
    }
  }
})

$('#select3').on('change', function(event){
  groupIdx = $('#select3').val();
  $('#select4').empty();
  for(var key3 in roomArray[groupIdx]){
    select4option = "<option value='"+key3+"'>"+roomArray[groupIdx][key3]+"</option>";
    $('#select4').append(select4option);
  }
})

// console.log(buildingIdx, groupIdx, roomIdx);
