@include('admin/header')
<div class="questionMgtPage"></div>
<div class="layout-content">
    <div class="layout-content-body">
        <div class="title-bar">

            <h1 class="title-bar-title">
              <span class="d-ib">Select quetion type</span> /
              <a class="small" href="{{url('question-category')}}">Back</a>
            </h1>
            <p class="title-bar-description">
                <small>Welcome to E-learning</small>
            </p>
        </div>

        <d iv class="row gutter-xs">
            <div class="col-md-10 card panel-body " id="">
                <div class="col-sm-12 col-md-12">
                    <div class="form">
                        <form class="form form-horizontal">
                            <div class="form-group text-center">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="http://18.219.123.8/editor/index.php" class="btn btn-primary" type="button">Add normal question</a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="http://18.219.123.8/editor/compriensive.php" class="btn btn-primary" type="button">Add compriensive question</a>                                   
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{url('question-list')}}" class="btn btn-primary" type="button">View question list</a>
                                    </div>
                                     <div class="col-md-3">
                                        <a href="#" class="btn btn-primary" type="button">Visibility</a>
                                    </div>
                                </div
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('admin/footer')

