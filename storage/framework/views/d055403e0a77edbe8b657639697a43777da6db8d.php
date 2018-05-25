<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="profilePage"></div>
<div class="layout-content">
    <div class="layout-content-body">
        <div class="title-bar">

            <h1 class="title-bar-title">
              <span class="d-ib">Edit Profile </span>

            </h1>
            <p class="title-bar-description">
                <small>Welcome to Petchat</small>
            </p>
        </div>

        <div class="row gutter-xs">


            <div class="col-md-8 card panel-body  " id="">
                <div class="col-sm-12 col-md-12">

                    <div class="demo-form-wrapper">
                        <form class="form form-horizontal" method="post" enctype="multipart/form-data">
                             <div class="form-group">
                                <div class="col-md-8">
                                    <label for="email-2" class=" control-label">Name</label>

                                    <input id="" class="form-control" type="text" name="name" value="<?php echo e($admin->name); ?>">
                                    
                                </div>
                            
                                <div class="col-md-8">
                                    <label for="email-2" class=" control-label">Email</label>

                                    <input id="" class="form-control" type="text" name="email"  value="<?php echo e($admin->email); ?>" disabled="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8">
                                    <label for="email-2" class=" control-label">Phone</label>

                                   <input id="" class="form-control" type="text" name="phone"  value="<?php echo e($admin->contact); ?>" >
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-md-8">
                                    <label for="email-2" class=" control-label">Add profile pic</label>

                                    <input id="" class="form-control" type="file" name="image">
                                </div>
                                <p  style="color:red"><?php echo e(session()->get('image')); ?></p>


                            </div>
                   
                            <div class="form-group">
                                <div class="col-md-8">
                                    <label for="email-2" class=" control-label">Location</label>

                                    <input id="" class="form-control" type="text" name="location"  value="<?php echo e($admin->location); ?>" >
                                </div>

                            </div>
                           
                             <div class="form-group">
                                <div class="col-md-8">
                                    <label for="address" class=" control-label">Address</label>

                                    <input id="" class="form-control" type="text" name="address"  value="<?php echo e($admin->address); ?>" >
                                </div>
                            </div>


                            <div class="form-group">
                                <div class=" col-sm-8  col-md-8 ">
                                    <button class="btn btn-primary " type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php echo $__env->make('admin/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

