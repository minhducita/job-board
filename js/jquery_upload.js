$(document).ready(function() {
    var abc = 4;
    append_image_delete();
    function displayAddMoreButton(){
        var count_input = $(".iupload").length;
        if(count_input < 3){
            $("#add_more").css("display","inline");
        }
    }
//To add new input file field dynamically, on click of "Add More Files" button below function will be executed
    $('#add_more').click(function() {
        var count_input = $(".iupload").length;
        console.log(count_input);
        if(count_input <= 2){
            $(".add_more").before($("<div/>", {id: 'filediv',class:'iupload'}).fadeIn('slow').append(
                $("<input/>", {name: 'file[]', type: 'file', id: 'file',class:'file'})

            ));
        }
        if(count_input == 0){
            $(".iupload").addClass("div_upload1");
        }
        if(count_input == 1){
            $(".iupload").removeClass("div_upload1");
            $(".iupload").addClass("div_upload2");
        }
        if(count_input == 2){
            $(".iupload").removeClass("div_upload2");
            $("#add_more").css("display","none");
        }
    });

//following function will executes on change event of file input to select different file
    $('body').on('change', '#file', function(){
        if (this.files && this.files[0]) {
            var fileInput = this.files[0];
            byteSize  = fileInput.size;
            var fileSize = ( byteSize / (1024));
            if(fileSize > 2048) {//2 megabyte
                $(this).parent().remove();
                alert("Your file is grater than 2 Megabyte, please pick another file (less than 2 Megabyte)");
                displayAddMoreButton();
                return;
            }
            abc += 1; //increementing global variable by 1
            var z = abc - 1;
            var x = $(this).parent().find('#previewimg' + z).remove();
            $(this).before("<div id='abcd"+ abc +"' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");

            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);

            $(this).hide();
            $("#abcd"+ abc).append($("<img/>", {id: 'img', src: $url_img_delete, alt: 'delete'}).click(function() {
                $(this).parent().parent().remove();
                displayAddMoreButton();

                if(count_input == 1){
                    $(".iupload").removeClass("div_upload2");
                    $(".iupload").addClass("div_upload1");
                }
                else if(count_input == 2){
                    $(".iupload").removeClass("div_upload2");
                    $(".iupload").addClass("div_upload2");
                }
                else if(count_input == 3){
                    $(".iupload").removeClass("div_upload2");
                }
            }));
        }
    });

//To preview image
    function imageIsLoaded(e) {
        $('#previewimg' + abc).attr('src', e.target.result);
    };
    $('#upload').click(function(e) {
        var name = $(":file").val();
        if (!name)
        {
            alert("First Image Must Be Selected");
            e.preventDefault();
        }
    });
    function append_image_delete(){
        $(".abcd").each(function(){
            $(this).append($("<img/>",{id: 'img', src: $url_img_delete, alt: 'delete'}).click(function() {
                $(this).parent().parent().remove();
                $("input[name='delete_img']").val($("input[name='delete_img']").val()+","+$(this).parent().attr("del"));
                displayAddMoreButton();

            }));
        });
    }
});
