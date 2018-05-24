@include('admin/header')

    <div class="questionMgtPage ExplorerListPage">
        <div class="layout-content">
            <div class="layout-content-body">
                <div class="title-bar">

                    <h1 class="title-bar-title">
                      <span class="d-ib">Select Class List</span> /
                       <a class="small" href="{{url('question-mgt')}}">back</a>
                    </h1>
                </div>
                <div class="row gutter-xs">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions">
                                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                                    <button type="button" class="card-action card-reload" title="Reload"></button>

                                </div>
                                <strong>Select Class list</strong>
                                <div class="status"></div>
                                
                            </div>
                            <div class="card-body edit-list1">
                                <table class="table table-striped table-bordered table-wrap" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th>Sr. No.</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody class="count_input">
                                    <?php $i=0;?>
                                    @foreach($educations as $education)
                                        <tr class="list-tr1" id="id_{{$education->id}}">
                                          <td class = "order">{{++$i}}</td>
                                          <td><input id="" type="text" name="education[]" value="{{$education->education}}" class="edu-value" eduction_id="{{$education->id}}"/></td>
                                          <td>
                                           <button class="btn del-list1 btn-danger btn-sm btn-labeled" type="button"  delete_edu_id="{{$education->id}}" onclick="deleteValue('{{$education->id}}')">
                                             <span class="btn-label">
                                                <span class="icon icon-bank icon-lg icon-fw"></span>
                                             </span>
                                             Delete
                                            </button>
                                           </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 ">
                            <button id = "addEducation" class="btn btn-primary" type="button">Save</button>
                              
                              <a href="#" class="btn btn-primary addNewRow">
                                Add new
                              </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@include('admin/footer')
    <script type="text/javascript">
    function deleteValue(val){
        $('#id_'+val).remove();
        if($('.edit-list1 tr').length>1) {
            $('td.order').text(function (i) {
               return (i + 1);
            });
        }
        if($.isNumeric(val)) {
             $.ajax({
                type:'POST',
                url:"{{url('delete-educations')}}",
                data:{
                    "eduId":val
                },
                success:function(data){
                    $('.status').empty();
                  
                    if ( data == "0" ) {
                       $('.status').append("<div style='color:red'>Please try again.</div>");
                    } else {
                        $('.status').append("<div style='color:red'>Deleted sucessfully.</div>");
                    }
                }
            });

        } 
    }
    var tempVal = 0;
    $(document).ready(function() {
        $('.addNewRow').click(function() {
            tempVal = tempVal+1;
            // functionValue = "temp"+tempVal;
            var count =($('.edit-list1 tr').length);
            $(".edit-list1 table tbody").append('<tr class="list-tr1" id="id_temp'+tempVal+'">\
              <td class = "order">'+count+'</td>\
              <td><input id="" type="text" name="education[]" value="" class="edu-value"/></td>\
              <td>\
               <button class="btn del-list1 btn-danger btn-sm btn-labeled" type="button" onclick="deleteValue(\'temp'+tempVal+'\')">\
                 <span class="btn-label">\
                    <span class="icon icon-bank icon-lg icon-fw"></span>\
                 </span>\
                 Delete\
                </button>\
               </td>\
            </tr>');
        });
        // $(".del-list1").on('click',function(){
        //     console.log($(".del-list1").attr("delete_edu_id"));
        //     $(this).parents('.list-tr1').remove();
        //     if($('.edit-list1 tr').length>1) {
        //         $('td.order').text(function (i) {
        //            return (i + 1);
        //         });
        //     }
        //     return false;
        // });
    });
        $('#addEducation').click(function() {
            var i = 0;
            var eduValue = [];
            var eduId = [];
            $('.list-tr1').each(function(i) {
                var educationValue = $(this).find(".edu-value").val();
                var education_id = $(this).find(".edu-value").attr("eduction_id");
                eduValue[i] =  educationValue; 
                eduId[i] =  education_id; 

            });
            $.ajax({
                type:'POST',
                url:"{{url('add-educations')}}",
                data:{
                    "educations":eduValue,
                    "eduId":eduId
                },
                success:function(data){
                    $('.status').empty();

                    if ( data == "0" ) {
                       $('.status').append("<div style='color:red'>Please try again.</div>");
                    } else {
                        $('.status').append("<div style='color:red'>Data updated sucessfully.</div>");
                    }
                }
            });
        });
    </script>
    <div id="BlockUser" tabindex="-1" role="dialog" class="modal fade">
     <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
              <span class="sr-only">Close</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="text-center">
              <span class="text-danger icon icon-times-circle icon-5x"></span>
              <h3 class="text-danger">Danger</h3>
              <h4>Are you want to block this item</h4>
              <div class="m-t-lg">
                <button class="btn btn-danger" data-dismiss="modal" type="button">Continue</button>
                <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
              </div>
            </div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>      
    </div>

    