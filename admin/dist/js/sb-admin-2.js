/*!
 * Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
           // $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png", ".mp4", ".3gp", ".mov"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                $.alert({
                    icon: 'fa fa-warning',
                    title: 'Info!',
                    content: "Invalid File format ! Please select Image file.",
                    type: 'blue'
                } );
                oInput.value = "";
                return false;
            }
        }
    }
}
    //Allaudhin-10-12-18
    //Custom Choose file function
    $(document).on('click', '.browse', function(){
        var file = $(this).parent().parent().parent().find('.file');
        file.trigger('click');
    });
    
    $(document).on('change', '.file', function(){
        //26-1-1019
        //ValidateSingleInput() for check upload file format(jpeg,jpg,png,bmp,gif)        
        ValidateSingleInput(this);  
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });

        // var file = document.querySelector(".file");
        // if ( /\.(jpe?g|png|gif)$/i.test(file.files[0].name) === false ) {
        //     $.alert({
        //         icon: 'fa fa-warning',
        //         title: 'Info!',
        //         content: "Invalid File format ! Please select Image file.",
        //         type: 'blue'
        //     } );
        // }else{
        //     $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        // }

        
// Image preview script
// 1-Feb-2019
$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Choose Image"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
//Image preview script ends

//Video preview script Starts

// $(document).on('click', '#close-preview', function(){ 
//     $('.video-preview').popover('hide');
//     // Hover befor close the preview
//     $('.video-preview').hover(
//         function () {
//            $('.video-preview').popover('show');
//         }, 
//          function () {
//            $('.video-preview').popover('hide');
//         }
//     );    
// });


$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.video-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.video-preview-clear').click(function(){
        $('.video-preview').attr("data-content","").popover('hide');
        $('.video-preview-filename').val("");
        $('.video-preview-clear').hide();
        $('.video-preview-input input:file').val("");
        $(".video-preview-input-title").text("Choose Video"); 
    }); 
    // Create the preview video
    $(".video-preview-input input:file").change(function (){     
        var img = $('<iframe/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".video-preview-input-title").text("Change");
            $(".video-preview-clear").show();
            $(".video-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            //$(".video-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
//Video preview script ends



