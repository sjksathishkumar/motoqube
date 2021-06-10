jQuery(function(){

  /*Datatable*/
	jQuery('#datatable_details').DataTable({
    responsive: true,
    "order": [[ 0, "desc" ]],
    dom: 'Blfrtip',
    buttons: ['excel'],
  });

jQuery('.datatable').DataTable({
    responsive: true,
    dom: 'ldfrtip',

});
	/*CK editor*/
	CKEDITOR.replace('add_description');
  CKEDITOR.replace('edit_description');

	/*Select2*/
  jQuery('.select').select2();

  /*Checkbox checked*/
  jQuery('#checkAll').click(function(){
    if(this.checked)
    {
      jQuery('.checkbox').each(function(){
        this.checked = true;
      });   
    }
    else
    {
      jQuery('.checkbox').each(function(){
        this.checked = false;
      });
    } 
  });

});

$('.select2').select2();

/*Clear form resubmission*/
if( window.history.replaceState )
{
	window.history.replaceState( null, null, window.location.href );
}

/*Delete record or records*/
function delete_record(e,table_name,action_name)
{
  var id = e.value;
  $.confirm({
    icon: 'fa fa-warning',
    title: 'Confirm!',
    content: 'Do you want to Delete ?',
    type: 'red',
    buttons: {
        confirm:  {
            btnClass: 'btn-red',
            action: function(){
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Confirm!',
                    content: 'If you Delete, You cant restore this record !',
                    type: 'red',
                    buttons: {
                      Okay: {
                        btnClass: 'btn-red',
                        action: function(){
                            $.ajax({
                              type: 'post',
                              url: 'ajax_submit.php',
                              data: 'action='+action_name+'&ID='+id+'&table_name='+table_name,
                              dataType: "json",
                              success: function (data) {
                                if(data['validation'] == '1'){
                                  $.confirm({
                                    icon: 'fa fa-check',
                                    title: '',
                                    content: data['message'],
                                    type: 'green',
                                    autoClose: 'Okay|1000',
                                    buttons: {
                                      Okay: function () {
                                        window.location.reload();
                                      }
                                    }
                                  });
                                }
                                else{
                                  $.alert(data['message']);
                                }
                              }
                            });
                        }
                      },
                      Cancel: function () { },
                    }
                });
            }
        },
        cancel: function () { },
    }
  });
}

function closealert()
{
  jQuery('.alert').html(),autoClose = true;
}

function notification(position1,color,Content)
{
  NotifContent = $('#preview').find('.alert').html(),autoClose = false;
  type = 'error';
  notifContent = '<div class="alert alert-' + color + ' media fade in"><p>' + Content + '</p></div>';
  method = 3000;
  position = position1;
  container ='';
  style = 'topbar';
  openAnimation = 'animated bounceIn';
  closeAnimation = 'animated bounceOut';

  var n = noty({
    text        : notifContent,
    dismissQueue: false,
    layout      : position,
    closeWith   : ['click'],
    theme       : 'made',
    maxVisible  : 5
  });
}

function HideBorder(id)
{
  jQuery("#"+id).css("border","");
}

function success_alertbox(redirect_page='window.location.href',type){
  if(type=="Update"){type='Updated';}
  else if(type=="Insert"){type='Inserted';}
  $.confirm({
    icon: 'fa fa-check',
    title: '',
    content: 'Successfully '+type+'!',
    type: 'green',
    autoClose: 'Okay|20000',
    buttons: {
      Okay: function () {
        window.location.href=redirect_page;
      }
    }
  }); 
}

function error_alertbox(redirect_page='window.location.href',type){
  $.confirm({
    icon: 'fa fa-times',
    title: '',
    content: type+' Failed!',
    type: 'red',
    autoClose: 'Okay|20000',
    buttons: {
      Okay: function () {
        window.location.href=redirect_page;
      }
    }
  }); 
}

/*Delete record or records*/
function delete_tablerow(e,table_name,action_name,column_name,value)
{
  var value = value;
  $.confirm({
    icon: 'fa fa-warning',
    title: 'Confirm!',
    content: 'Do you want to Delete ?',
    type: 'red',
    buttons: {
        confirm:  {
            btnClass: 'btn-red',
            action: function(){
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Confirm!',
                    content: 'If you Delete, You cant restore this record !',
                    type: 'red',
                    buttons: {
                      Okay: {
                        btnClass: 'btn-red',
                        action: function(){
                            $.ajax({
                              type: 'post',
                              url: 'ajax.php',
                              data: 'action='+action_name+'&value='+value+'&table_name='+table_name+'&column_name='+column_name,
                              dataType: "json",
                              success: function (data) {
                                if(data['validation'] == '1'){
                                  $.confirm({
                                    icon: 'fa fa-check',
                                    title: '',
                                    content: data['message'],
                                    type: 'green',
                                    autoClose: 'Okay|1000',
                                    buttons: {
                                      Okay: function () {
                                        window.location.reload();
                                      }
                                    }
                                  });
                                }
                                else{
                                  $.alert(data['message']);
                                }
                              }
                            });
                        }
                      },
                      Cancel: function () { },
                    }
                });
            }
        },
        cancel: function () { },
    }
  });
}

/*Delete record or records*/
function delete_tablerow_withoutconfirm(e,table_name,action_name,column_name,value,link)
{
  var value = value;
  $.ajax({
    type: 'post',
    url: 'ajax.php',
    data: 'action='+action_name+'&value='+value+'&table_name='+table_name+'&column_name='+column_name,
    dataType: "json",
    success: function (data) {
      if(data['validation'] == '1'){
       window.location.href=link;
      }
      else{
        $.alert(data['message']);
      }
    }
  });                     
}


$(".drag_table").on({
  mousemove: function(e) {
    var mx2 = e.pageX - this.offsetLeft;
    if(mx) this.scrollLeft = this.sx + mx - mx2;

  },
  mousedown: function(e) {
    this.sx = this.scrollLeft;
    mx = e.pageX - this.offsetLeft;
  }
});

$(document).on("mouseup", function(){
  mx = 0;
});
