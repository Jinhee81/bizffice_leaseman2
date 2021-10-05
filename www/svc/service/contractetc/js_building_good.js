// var buildingoption, goodoption, buildingIdx, goodIdx;

var buildingoption = '<option value="buildingAll">물건전체</option>';
$('select[name=building]').append(buildingoption);

var goodoption, buildingIdx, goodIdx;


for(var key in buildingArray){ //건물목록출력(비즈피스장암,비즈피스구로)
  buildingoption = "<option value='"+key+"'>"+buildingArray[key][0]+"</option>";
  $('select[name=building]').append(buildingoption);
}
buildingIdx = $('select[name=building]').val();

for(var key2 in goodBuildingArray[buildingIdx]){ //상품목록출력(빔,회의실)
  goodoption = "<option value='"+key2+"'>"+goodBuildingArray[buildingIdx][key2]+"</option>";
  // console.log(select3option);
  $('select[name=good]').append(goodoption);
}
goodIdx = $('select[name=good]').val();

$('select[name=building]').on('change', function(event){
  buildingIdx = $(this).val();
  $('select[name=good]').empty();
  $('select[name=good]').append('<option value="goodAll">상품전체</option>');
  for(var key2 in goodBuildingArray[buildingIdx]){ //상품목록출력(빔,회의실)
    goodoption = "<option value='"+key2+"'>"+goodBuildingArray[buildingIdx][key2]+"</option>";
    // console.log(select3option);
    $('select[name=good]').append(goodoption);
  }
  goodIdx = $('select[name=good]').val();
})

$('select[name=good]').on('change', function(event){
  goodIdx = $(this).val();
})
