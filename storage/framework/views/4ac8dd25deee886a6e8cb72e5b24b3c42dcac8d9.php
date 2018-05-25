<?php echo $__env->make('admin/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="grapesComboPage"></div>
<div class="layout-content">
<div class="layout-content-body">
<div class="title-bar">
<h1 class="title-bar-title">
  <span class="d-ib">Question list</span>
</h1>
<p class="title-bar-description">
    <small>Welcome to E-learning</small>
</p>
</div>

<div class="row gutter-xs">
<div class="col-md-9">
  <div class="card">
    <div class="card-header">
      <div class="card-actions">
        <button type="button" class="card-action card-toggler" title="Collapse"></button>
        <button type="button" class="card-action card-reload" title="Reload"></button>
      </div>
      <strong>Please Select Question</strong>
    </div>
    <div class="card-body">
      <div class="card-search">
        <div class="card-search-results">
          <div class="timeline">
            <div class="timeline-item">
              <div class="timeline-segment">
                <div class="timeline-divider"></div>
              </div>
              <div class="timeline-content"></div>
            </div>
            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="timeline-item">
              <div class="timeline-segment">
                <div class="timeline-media bg-primary circle sq-24">
                  <div class="icon icon-check"></div>
                </div>
              </div>
              <div class="timeline-content">
                <div class="timeline-row">
                  <p>
                    <small><?php echo html_entity_decode($question->question);?></small>
                     <span class=""><a href="http://18.219.123.8/editor/edit-normal.php?id=<?php echo $question->id;?>&lavel=<?php echo $question->lavel;?>&type=<?php echo $question->type;?>" class="editQue icon icon-edit"></a>
                    </span>
                     <span ><a href="<?php echo e(url('delete-question')); ?>/<?php echo e($question->id); ?>" class="editQue icon icon-bank"></a></span>
                  </p>
                  <?php $j=0;?>
                    <?php if(count($question['answer'])>0): ?>                 
                        <?php for($i = 0; $i < count($question['answer']); $i++): ?>
                            <?php if($question['answer'][$i]['answer_status']==1): ?>
                                <p>
                                    <b><?php echo ++$j;?></b>
                                    <span class="label-danger label text-white"><?php echo html_entity_decode($question['answer'][$i]['answer']);?></span> 
                                    <span class=""><a href="http://18.219.123.8/editor/edit-ans.php?question_id=<?php echo $question->id;?>&ans_id=<?php echo $question['answer'][$i]['id'];?>" class="editQue icon icon-edit"></a>
                                    </span>
                                </p>
                           <?php else: ?>
                                <p>
                                   <b><?php echo ++$j;?></b>
                                    <span class=""><?php echo html_entity_decode($question['answer'][$i]['answer']);?></span> 
                                    <span class=""><a href="http://18.219.123.8/editor/edit-ans.php?question_id=<?php echo $question->id;?>&ans_id=<?php echo $question['answer'][$i]['id'];?>" class="editQue icon icon-edit"></a>
                                    </span>
                                </p>
                            <?php endif; ?>
                       <?php endfor; ?>
                    <?php endif; ?>
                  <?php if($question->type==2 && (count($question['answer'])<4)): ?>
                  <div class="clearfix">
                    <button class="btn btn-primary" type="button"><a href="http://18.219.123.8/editor/add-answer.php?id=<?php echo $question->id;?>&type=<?php echo $question->type;?>">Add answer</a></button>
                  </div>
                  <?php endif; ?>
                  

                  <?php if($question->type==2 && empty(array_search($question->id,$correct,true))): ?>
                  
                  <div class="clearfix">
                    <button class="btn btn-primary" type="button"><a href="http://18.219.123.8/editor/correct-answer.php?id=<?php echo $question->id;?>&type=<?php echo $question->type;?>">Right Answer</a></button>
                  </div>
                  <?php endif; ?>
                  <?php if($question->type==1 && (count($question['answer'])<1)): ?>
                  <div class="clearfix">
                    <button class="btn btn-primary" type="button"><a href="http://18.219.123.8/editor/add-answer.php?id=<?php echo $question->id;?>&type=<?php echo $question->type;?>">Add answer</a></button>
                  </div>
                 
                  
                   <div class="clearfix">
                    <button class="btn btn-primary" type="button"><a href="http://18.219.123.8/editor/correct-answer.php?id=<?php echo $question->id;?>&type=<?php echo $question->type;?>">Right Answer</a></button>
                  </div>
                  <?php endif; ?>
                  <?php if($question->type==3): ?>
                  <button class="btn btn-primary" type="button"><a href="http://18.219.123.8/editor/add-answer.php?id=<?php echo $question->id;?>&type=<?php echo $question->type;?>">Add answer</a></button>
                  </div>

                  <div class="clearfix">
                    <button class="btn btn-primary" type="button"><a href="http://18.219.123.8/editor/correct-answer.php?id=<?php echo $question->id;?>&type=<?php echo $question->type;?>">Right Answer</a></button>
                  </div>
                  <?php endif; ?>
                  

                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
          </div>
        </div>
      </div>
    </div>
    <?php echo e($questions->render()); ?>


  </div>

</div>


</div>

</div>
</div>
<?php echo $__env->make('admin/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
