@include('admin/header')

    <div class="questionMgtPage ExplorerListPage">
        <div class="layout-content">
            <div class="layout-content-body">
                <div class="title-bar">

                    <h1 class="title-bar-title">
                      <span class="d-ib">Edit visiblity</span> /
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
                                <strong>Edit visiblity</strong>
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
                                    <tbody>
                                        <tr class="list-tr1">
                                          <td>1</td>
                                          <td><input id="" type="text" name="" value="category 1"/></td>
                                          <td>
                                           <button class="del-list1 btn btn-danger btn-sm btn-labeled" type="button">
                                             <span class="btn-label">
                                                <span class="icon icon-bank icon-lg icon-fw"></span>
                                             </span>
                                             Delete
                                            </button>
                                           </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 ">
                              <a href="#" class="btn btn-primary">
                                Save
                              </a>
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
    $(document).ready(function() {
        $('.addNewRow').click(function() {
              $(".edit-list1 table tbody").append('<tr class="list-tr1">\
                                          <td>1</td>\
                                          <td><input id="" type="text" name="" value="category 1"/></td>\
                                          <td>\
                                           <button class="btn del-list1 btn-danger btn-sm btn-labeled" type="button">\
                                             <span class="btn-label">\
                                                <span class="icon icon-bank icon-lg icon-fw"></span>\
                                             </span>\
                                             Delete\
                                            </button>\
                                           </td>\
                                        </tr>');
              $(".del-list1").on('click',function(){
                  $(this).parents('.list-tr1').remove();
                });
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

    