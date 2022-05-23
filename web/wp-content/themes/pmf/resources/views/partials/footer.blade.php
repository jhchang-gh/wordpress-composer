<footer class="footer">

  <!-- Container -->
  <div class="grid-container container">



    <!-- Center -->
    <div class="footer__center">

      <!-- Left -->
      <div class="footer__center__left">

        <!-- col -->
        <div class="footer__center__left__col">
          <div class="h5">{{ _e( 'Visitor Information' ) }}</div>
          <div>
            <p>Memorial Hours<br> Closed indefinitely</p>
            <p>1 N Rotary Rd.<br> Arlington, VA 22202</p>
          </div>
        </div>
        <!-- end col -->

        <!-- col -->
        <div class="footer__center__left__col">
          <div class="h5">{{ _e( 'About' ) }}</div>
          {!! wp_nav_menu( [
                'theme_location'  => 'footer_about_menu',
                'menu'            => 'Footer Navigation About',
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => '',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => '',
            ] )
          !!}
        </div>
        <!-- end col -->

        <!-- col -->
        <div class="footer__center__left__col">
          <div class="h5">{{ _e( 'Social Media' ) }}</div>
          {!! wp_nav_menu( [
                'theme_location'  => 'footer_social_menu',
                'menu'            => 'Footer Navigation Social',
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => '',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => '',
            ] )
          !!}
        </div>
        <!-- end col -->



      </div>
      <!-- End Left -->

      <!-- Right -->
      <div class="footer__center__right">
        <img src="{{ get_template_directory_uri() . '/assets/images/footer_logo.svg' }}" alt="">
        <small>© 2021 Pentagon Memorial Fund<br> All Rights Reserved.</small>
      </div>
      <!-- End Right -->

    </div>
    <!-- End Center -->

    <!-- Bottom -->
    <div class="footer__bottom">

      <!-- menu -->
      {!! wp_nav_menu( [
                'theme_location'  => 'main-menu',
                'menu'            => 'Footer Navigation Bottom',
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'footer__bottom__menu',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => '',
            ] )
          !!}

      <!-- end menu -->

      <!-- web -->
      <div class="footer__bottom__web">
        <a href="https://www.blenderbox.com/" target="_blank">
          <img src="{{ get_template_directory_uri() . '/assets/images/footer_logo_web.svg' }}" alt="Blenderbox Logo">
        </a>
      </div>
      <!-- end web -->

    </div>
    <!-- End Bottom -->

  </div>
  <!-- End Container -->

</footer>


