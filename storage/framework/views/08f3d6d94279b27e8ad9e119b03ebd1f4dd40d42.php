<div class="layout-footer">
    <div class="layout-footer-body">
        <small class="copyright">2018 &copy; E-learning Pvt. Ltd.</small>
    </div>
</div>
</div>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/vendor.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/elephant.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/application.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/profile.min.js')); ?>"></script>
     <script src="<?php echo e(asset('js/demo.min.js')); ?>"></script>
   
    <script type="text/javascript">
    $(window).load(function(){

      // For Driver Page
      if ( $('.profilePage').length ) {
        $('.sidenav-item').removeClass("active");
        $('.profilePageNav').addClass("active");
      }
      if ( $('.dashboardPage').length ) {
        $('.sidenav-item').removeClass("active");
        $('.dashboardPageNav').addClass("active");
      }
      if ( $('.accountPage').length ) {
        $('.sidenav-item').removeClass("active");
        $('.accountNav').addClass("active");
      }
      if ( $('.currentOrderPage').length ) {
        $('.sidenav-item').removeClass("active");
        $('.currentNav-a').addClass("active");
        $('.orderNav').addClass("open");
        $('.orderNav ul').css("display","block");
      }
      if ( $('.orderHistoryPage').length ) {
        $('.sidenav-item').removeClass("active");
        $('.historyNav-b').addClass("active");
        $('.orderNav').addClass("open");
        $('.orderNav ul').css("display","block");
      }
      if ( $('.productMgtPage').length ) {
        $('.sidenav-item').removeClass("active");
        $('.productNav').addClass("active");
      }
      
      
    });
            $(window).scroll(function (){
                var window_top = $(window).scrollTop();
                var div_top = $('.tabs-new').position().top;
                console.log(window_top);
                console.log(div_top);
                if (window_top > div_top) {
                    $('.tabs-new').addClass('stick');
                    $('.tabs-new').parents('.layout-content-body').removeClass('layout-content-body').addClass('layout-content-body-dummy');
                } else {
                    $('.tabs-new').parents('.layout-content-body').removeClass('layout-content-body-dummy').addClass('layout-content-body')
                }

                if ( window_top < 74 ) {
                  $('.tabs-new').removeClass('stick');
                }
            });

    </script>
  </body>
</html>