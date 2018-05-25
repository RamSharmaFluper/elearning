<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-learning</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="manifest" href="manifest.json">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#2c3e50">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700">
    <link rel="stylesheet" href="css/vendor.min.css">
    <link rel="stylesheet" href="css/elephant.min.css">
    <link rel="stylesheet" href="css/application.min.css">
    <link rel="stylesheet" href="css/login-2.min.css">
  </head>
  <body>
    <div class="login">
      <div class="login-body">
        <a class="login-brand" href="#">
          <img class="img-responsive" src="img/logo-blk.png" alt="logo">
        </a>
        <div class="login-form ">
          <form data-toggle="" method="POST" action="">
            <div class="form-group <?php if($errors->has('email')): ?> has-error <?php endif; ?>">
              <label for="email">Email</label>
              <input  class="form-control" type="text" name="email" >
            </div>
            <?php if($errors->has('email')): ?> <p style="color:red"><?php echo e($errors->first('email')); ?></p> <?php endif; ?>
            <div class="form-group <?php if($errors->has('password')): ?> has-error <?php endif; ?>">
              <label for="password">Password</label>
              <input id="password" class="form-control" type="password" name="password" >
            </div>
             <?php if($errors->has('password')): ?> <p style="color:red"><?php echo e($errors->first('password')); ?></p> <?php endif; ?>
            <div class="form-group">
              <label class="custom-control custom-control-primary custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked="checked" name="remb">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-label">Keep me signed in</span>
              </label>
              <span aria-hidden="true"> · </span>
            </div>
            <input type="submit" name="submit" value="" class="btn btn-primary btn-block">
           
          </form>
        </div>
      </div>
      
    </div>
     <script src="<?php echo e(asset('js/vendor.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/elephant.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/application.min.js')); ?>"></script>
   
  </body>
</html>