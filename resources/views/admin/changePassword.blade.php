@include('admin/header')
<div class="profilePage"></div>
<div class="layout-content">
<div class="layout-content-body">
<div class="title-bar">
<h1 class="title-bar-title">
<span class="d-ib">Change Password </span>
</h1>
<p class="title-bar-description">
<small>Welcome to Perfec10</small>
</p>
</div>
<div class="row gutter-xs">
<div class="col-md-8 card panel-body  " id="">
<div class="col-sm-12 col-md-12">
<div class="demo-form-wrapper">
<form class="form form-horizontal" method="post" action="">
<div class="form-group">
<div class="col-md-8">
<label for="" class=" control-label @if ($errors->has('oldPassword')) has-error @endif">Old Password</label>
<input id="" class="form-control" type="password" name="oldPassword">
@if ($errors->has('oldPassword')) <p style="color:red">{{ $errors->first('oldPassword') }}</p> @endif
<p style="color:red">{{session()->get('confermPassword')}}</p>
</div>
</div>

<div class="form-group">
<div class="col-md-8">
<label for="" class=" control-label @if ($errors->has('password')) has-error @endif">New Password</label>
<input id="" class="form-control" type="password" name="password">
@if ($errors->has('password')) <p style="color:red">{{ $errors->first('password') }}</p> @endif
<p style="color:red">{{session()->get('same')}}</p>
</div>
</div>
<div class="form-group">
<div class="col-md-8">
<label for="" class=" control-label @if ($errors->has('confirmPassword')) has-error @endif">Confirm Password</label>
<input id="" class="form-control" type="password" name="confirmPassword">

@if ($errors->has('confirmPassword')) <p style="color:red">{{ $errors->first('confirmPassword') }}</p> @endif
</div>
</div>
<div class="form-group">
<div class=" col-sm-8  col-md-8 ">
<button class="btn btn-primary btn-block " type="submit">Submit</button>

</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

@include('admin/footer')