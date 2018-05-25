<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="questionMgtPage"></div>
<div class="layout-content">
    <div class="layout-content-body">
        <div class="title-bar">

            <h1 class="title-bar-title">
              <span class="d-ib">Select category</span> /
              <a class="small" href="<?php echo e(url('question-mgt')); ?>">Back</a>
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
                                     <a style="float: right;" href="<?php echo e(url('edit-subject')); ?>">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->subject); ?>"><?php echo e($subject->subject); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="width-100 control-label">Topics
                                     <a style="float: right;" href="<?php echo e(url('edit-topic-section')); ?>">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($topic->subject); ?>"><?php echo e($topic->subject); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="" class="width-100 control-label">Section
                                     <a style="float: right;" href="<?php echo e(url('edit-topic-section')); ?>">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                    <?php $__currentLoopData = $topicSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topicSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($topicSection->subject); ?>"><?php echo e($topicSection->subject); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="width-100 control-label">Sub-section
                                     <a style="float: right;" href="<?php echo e(url('edit-topic-sub-section')); ?>">Edit</a>
                                    </label>
                                    <select id="form-control-6" class="form-control">
                                       <?php $__currentLoopData = $topicSubSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topicSubSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($topicSubSection->subject); ?>"><?php echo e($topicSubSection->subject); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" col-sm-8  col-md-12 ">
                                    <a href="<?php echo e('question-type'); ?>" class="btn btn-primary" type="submit">Next</a>
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
<?php echo $__env->make('admin/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

