var div_box = "<div id='load-screen'><div id='loading'></div></div>"
$("body").prepend(div_box);
$('#load-screen').delay(700).fadeOut(600, function () {
    $(this).remove();
});

$(".checkBoxes").change(function(){
    if ($('.checkBoxes:checked').length > 0) {
        $('#deleteBtn').prop('disabled', false);
    }
    else{
        $('#deleteBtn').prop('disabled',true);

    }
});
$("#checkAll").change(function() {
    if(this.checked) {
        $('#deleteBtn').prop('disabled',false);
        $(".checkBoxes").prop('checked',true)
    }
    else if(!this.checked) {
        $('#deleteBtn').prop('disabled',true);
        $(".checkBoxes").prop('checked',false)
    }
});

