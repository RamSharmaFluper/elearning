  
{{$answer}}
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
                                            <th>Sr. No</th>
                                            <th>Ans</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php $i=0; print($answer);die;?>
                                    @foreach($answer as $value)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{value->id}}</td>

                                            <td class="text-center">
                                            <input type="checkbox" name="correct" value="{{$value->answer_status}}" <?php echo ($value->answer_status==1 ? 'checked' : '');?>>

                                            <input type="checkbox" name="corrext" value="">
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

 