$(document).ready(function(){

    // Add Class
    $('.edit').click(function(){
        $(this).addClass('editMode');
    });

    // Save data
    $(".edit").focusout(function(){
        $(this).removeClass("editMode");
        var id = this.id;
        var split_id = id.split("_");
        var stlpec = split_id[0];
        var edit_id = split_id[1];
        var hodnota = $(this).text();

        $.ajax({
            url: '?c=adminedit&a=upravUzivatela',
            type: 'post',
            data: { stlpec:stlpec, hodnota:hodnota, id:edit_id },
            success:function(response){
                if(response == 1){
                    console.log('Save successfully');
                }else{
                    console.log("Not saved.");
                }
            }
        });

    });

});