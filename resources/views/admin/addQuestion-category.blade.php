@include('admin/header')
<div class="questionMgtPage"></div>
<div class="layout-content">
    <div class="layout-content-body">
        <div class="title-bar">

            <h1 class="title-bar-title">
              <span class="d-ib">Select category</span> /
              <a class="small" href="{{url('question-mgt')}}">Back</a>
            </h1>
            <p class="title-bar-description">
                <small>Welcome to E-learning</small>
            </p>
        </div>

        <div class="row gutter-xs">
            <div class="col-md-8 card panel-body  " id="">
                <div class="col-sm-12 col-md-12">
                    <div class="demo-form-wrapper">
                        <form class="form form-horizontal">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="" class="width-100 control-label">Subjects
                                     <a style="float: right;" href="{{url('edit-subject')}}">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->subject}}">{{$subject->subject}}</option>
                                    @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="width-100 control-label">Topics
                                     <a style="float: right;" href="{{url('edit-topic-section')}}">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    @foreach($topics as $topic)
                                        <option value="{{$topic->subject}}">{{$topic->subject}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="" class="width-100 control-label">Section
                                     <a style="float: right;" href="{{url('edit-topic-section')}}">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    @foreach($topicSections as $topicSection)
                                        <option value="{{$topicSection->subject}}">{{$topicSection->subject}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="width-100 control-label">Sub-section
                                     <a style="float: right;" href="{{url('edit-topic-sub-section')}}">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                       @foreach($topicSubSections as $topicSubSection)
                                        <option value="{{$topicSubSection->subject}}">{{$topicSubSection->subject}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" col-sm-8  col-md-12 ">
                                    <a href="{{'question-type'}}" class="btn btn-primary" type="submit">Next</a>
                                </div>
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

