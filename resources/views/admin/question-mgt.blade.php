@include('admin/header')
<div class="questionMgtPage"></div>
<div class="layout-content">
    <div class="layout-content-body">
        <div class="title-bar">

            <h1 class="title-bar-title">
              <span class="d-ib">Question Management</span>
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
                                <div class="col-md-4">
                                    <label for="" class="width-100 control-label">Select Level
                                       <!--  <a style="float: right;" href="{{url('edit-part')}}">Edit</a> -->
                                    </label>
                                    <select id="form-control-6" class="form-control choose_education" >
                                        <option value="">Select Level </option>
                                       
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="width-100 control-label">Year
                                     <a style="float: right;" href="{{url('edit-year')}}">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    @foreach($years as $year)
                                        <option value="{{$year->year}}">{{$year->year}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="width-100 control-label">Exam name
                                     <a style="float: right;" href="{{url('edit-exam')}}">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    @foreach($exams as $exam)
                                        <option value="{{$year->year}}">{{$exam->exam}}</option>
                                    @endforeach
                                       
                                    </select>
                                </div>
                                <!-- <div class="col-md-4">
                                    <label for="" class="width-100 control-label">Visiblity
                                     <a style="float: right;" href="{{url('edit-visiblity')}}">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                        <option value="">only exam</option>
                                        <option value="">only study</option>
                                        <option value="">Both</option>
                                        
                                    </select>
                                </div> -->
                            </div>
                            <div class="form-group">
                                <div class=" col-sm-8  col-md-12 ">
                                    <a href="{{url('question-category')}}" class="btn btn-primary">
                                        Next
                                    </a>
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
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type:'POST',
            url:"{{url('edit-part')}}",
            data:{
               
            },
            success:function(data){
                $('.status').empty();
                if ( data == "0" ) {
                    alert("cvxcklvl");
                    // $('.status').append("<div style='color:red'>Invalid password</div>");
                } else {
                    console.log(data);
                    console.log(data.length);
                    $(".choose_education").empty();
                    for(var i = 0; i < data.length; i++) {
                        $(".choose_education").append('<option value='+data[i].education+'>'+data[i].education+'</option>');
                    }
                   
                }
            }
        });
        // $('.choose_education').mousedown(function(e) {
         

        //     $.ajax({
        //         type:'POST',
        //         url:"{{url('edit-part')}}",
        //         data:{
                   
        //         },
        //         success:function(data){
        //             $('.status').empty();
        //             if ( data == "0" ) {
        //                 alert("cvxcklvl");
        //                 // $('.status').append("<div style='color:red'>Invalid password</div>");
        //             } else {
        //                 console.log(data);
        //                 console.log(data.length);
        //                 $(".choose_education").empty();
        //                 for(var i = 0; i < data.length; i++) {
        //                     $(".choose_education").append('<option value='+data[i].education+'>'+data[i].education+'</option>');
        //                 }
                       
        //             }
        //         }
        //     });
            
            
        // });
        
    });
    </script>


