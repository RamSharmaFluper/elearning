  @include('admin/header')
    <div class="accountPage ExplorerListPage">
        <div class="layout-content">
            <div class="layout-content-body">
                <div class="title-bar">

                    <h1 class="title-bar-title">
                      <span class="d-ib">User List</span>
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
                                <strong>User list</strong>
                            </div>
                            <div class="card-body">
                                <table id="demo-datatables-5" class="table table-striped table-bordered table-wrap dataTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>name</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i=0;?>
                                      @foreach($usersdata as $user)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->contact}}</td>
                                            <td>{{$user->name}}</td>

                                            <td class="text-center">
                                             @if($user->is_block==0)
                                                <a href="{{url('block')}}/{{$user->id}}" class="btn btn-danger btn-sm btn-labeled" type="button">
                                                    <span class="btn-label"><span class="icon icon-bank icon-lg icon-fw"></span></span>Block
                                                </a>
                                            @else
                                                <a href="{{url('unblock')}}/{{$user->id}}" class="btn btn-success btn-sm btn-labeled" type="button">
                                                    <span class="btn-label"><span class="icon icon-check icon-lg icon-fw"></span></span>Un-Block
                                                </a>

                                            @endif
                                            </td>
                                        </tr>
                                      @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
   @include('admin/footer')

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

    <div id="UnBlockUser" tabindex="-1" role="dialog" class="modal fade">
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
              <span class="text-info icon icon-check-circle icon-5x"></span>
              <h3 class="text-info">Info</h3>
              <h4>Are you want to unblock this item</h4>
              <div class="m-t-lg">
                <button class="btn btn-info" data-dismiss="modal" type="button">Continue</button>
                <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
              </div>
            </div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>      
    </div>