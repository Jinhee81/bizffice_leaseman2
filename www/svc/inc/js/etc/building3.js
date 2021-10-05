//select option에 빌딩, 그룹 추가하는 것
//이 파일에는 전체물건이 조회조건에 있다., 2021-7-9 자꾸 조회조건에러가 나서 새롭게 만든것...

var buildingoption = '<option value="buildingAll">물건전체</option>';
$('select[name=building]').append(buildingoption);

var groupoption, buildingIdx, groupIdx;

for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
  buildingoption = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
  $('select[name=building]').append(buildingoption);
}
buildingIdx = $('select[name=building]').val();

for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
  groupoption = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
  // console.log(select3option);
  $('select[name=group]').append(groupoption);
  console.log('why is not working???');
}
groupIdx = $('select[name=group]').val();

$('select[name=building]').on('change', function(event){
  buildingIdx = $('select[name=building]').val();
  $('select[name=group]').empty();
  $('select[name=group]').append('<option value="groupAll">그룹전체</option>');
  for(var key2 in groupBuildingArray[buildingIdx]){ //그룹목록출력(상주,비상주)
    groupoption = "<option value='"+key2+"'>"+groupBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(select3option);
    $('select[name=group]').append(groupoption);
  }
  groupIdx = $('select[name=group]').val();
})
