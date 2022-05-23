
<!-- Start Component: Heroes List -->
<section class="heroes-list">

  <!-- Container Fluid -->
  <div class="grid-container container-fluid ">

    <!-- Container -->
    <div class="container grid-container ">

      <!-- Form -->
      <form action="{{ admin_url( 'admin-ajax.php' ) }}" method="POST" id="filter">

        <!-- Panel -->
        <div class="heroes-list__panel">

          <!-- Panel > Left -->
          <div class="heroes-list__panel__left">

            <!-- Search -->
            <div class="heroes-list__panel__search">



              <input
                type="text"
                value=""
                name="search"
                minlength="3"
                autocomplete="off"
                placeholder="Search"
                pattern=".{3,}"
                required
                title="3 characters minimum"
                class="form-control heroes-list__panel__search__input"
              >
              <button type="button" class="heroes-list__panel__search__btn">
                <img
                  src="{{ get_template_directory_uri() . '/assets/images/icon_search_color.svg' }}"
                  alt="{{ _e( 'Search', 'pmf' ) }}"
                  title="{{ _e( 'Search', 'pmf' ) }}"
                  class="icon-search"
                >
                <img
                  src="{{ get_template_directory_uri() . '/assets/images/close.svg' }}"
                  alt="{{ _e( 'Clear Search', 'pmf' ) }}"
                  title="{{ _e( 'Clear Search', 'pmf' ) }}"
                  class="icon-delete"
                  style="display: none"
                >
              </button>
              <div class="notification-tooltip" style="display: none">{{ _e( 'Please enter at least 3 characters', 'pmf' ) }}</div>
            </div>
            <!-- End Search -->

          </div>
          <!-- End Panel > Left -->

          <!-- Panel > Right -->
          <div class="heroes-list__panel__right">

            <!-- Filter -->
            <div class="heroes-list__panel__filter">

              <!-- radio -->
              <div class="form-radio">

                <input type="radio" name="heroes[]" value="all" id="radio-1" checked="checked">
                <label for="radio-1" tabindex="0">All</label>

                <input type="radio" name="heroes[]" value="pentagon" id="radio-2">
                <label for="radio-2" tabindex="0">Pentagon</label>

                <input type="radio" name="heroes[]" value="flight-77" id="radio-3">
                <label for="radio-3" tabindex="0">Flight 77</label>

              </div>
              <!-- end radio -->

            </div>
            <!-- End Filter -->

            <!-- Order -->
            <div class="heroes-list__panel__order">

              <!-- dropdown -->
              <div class="dropdown">

                <!-- button -->
                <button type="button" class="heroes-list__panel__order__btn dropdown-button" tabindex="0">
                  <span>{{ _e( 'Sort ', 'pmf' ) }}</span>
                </button>
                <!-- end button -->

                <!-- list -->
                <ul class="dropdown-window">


                  <li>

                      <input type="radio" name="sort[]" value="asc" id="sort-4" checked="checked">
                      <label for="sort-4" class="active" tabindex="0">{{ _e( 'Alphabetically Ascending', 'pmf' ) }}</label>


                  </li>
                  <li>

                    <input type="radio" name="sort[]" value="desc" id="sort-3">
                    <label for="sort-3" tabindex="0">{{ _e( 'Alphabetically Descending', 'pmf' ) }}</label>


                  </li>
                  <li>

                    <input type="radio" name="sort[]" value="oldest" id="sort-2">
                    <label for="sort-2" tabindex="0">{{ _e( 'Oldest', 'pmf' ) }}</label>


                  </li>
                  <li>

                    <input type="radio" name="sort[]" value="youngest" id="sort-1">
                    <label for="sort-1" tabindex="0">{{ _e( 'Youngest', 'pmf' ) }}</label>


                  </li>
                </ul>
                <!-- end list -->

              </div>
              <!-- end dropdown -->

            </div>
            <!-- End Order -->

          </div>

        </div>
        <!-- End Panel -->
        <input type="hidden" name="type" value="biographies">
        <input type="hidden" name="action" value="taxonomyFilter">
        <input type="hidden" name="page" value="1">

      </form>
      <!-- End Form -->

    </div>
    <!-- End Container -->

    <!-- List -->
    <div class="heroes-list__list">


     @foreach($get_heroes as $hero)
        @include('partials.heroes-list-item-new')

     @endforeach

      {{--@foreach($slides as $post)
        @php setup_postdata($post) @endphp

        @include('partials.heroes-list-item')
      @endforeach
      @php wp_reset_postdata(); @endphp--}}
       <div class="heroes-list__loadmore container grid-container ">
         <button class="heroes-list__loadmore__btn btn" id="loadmore_btn">Load More</button>
         <div class="loader loadmore-loader" style="display: none">
       </div>
    </div>

    <!-- End List -->

  </div>
  <!-- End Container Fluid-->
</section>
<!-- End Component: Heroes List -->

