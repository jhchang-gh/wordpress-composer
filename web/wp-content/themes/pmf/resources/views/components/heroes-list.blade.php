@php
  global $post;
  $slides = get_posts([
        'numberposts' => 10,
        'post_type'   => 'biographies'
    ])
@endphp
<!-- Start Component: Heroes List -->
<section class="heroes-list">

  <!-- Container -->
  <div class="container">

    <!-- Form -->
    <form action="{{ admin_url( 'admin-ajax.php' ) }}" method="POST" id="filter">

      <!-- Panel -->
      <div class="heroes-list__panel">

        <!-- Panel > Left -->
        <div class="heroes-list__panel__left">

          <!-- Search -->
          <div class="heroes-list__panel__search">

            <button type="button" class="heroes-list__panel__search__btn">
              <img
                src="{{ get_template_directory_uri() . '/assets/images/icon_search_color.svg' }}"
                alt="{{ _e( 'Search', 'pmf' ) }}"
                title="{{ _e( 'Search', 'pmf' ) }}"
              >
            </button>

            <input
              type="text"
              value=""
              name="search"
              autocomplete="off"
              placeholder="Search"
              class="form-control heroes-list__panel__search__input"
            >
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
              <label for="radio-1">All</label>

              <input type="radio" name="heroes[]" value="pentagon" id="radio-2">
              <label for="radio-2">Pentagon</label>

              <input type="radio" name="heroes[]" value="flight-77" id="radio-3">
              <label for="radio-3">Flight 77</label>

            </div>
            <!-- end radio -->

          </div>
          <!-- End Filter -->

          <!-- Order -->
          <div class="heroes-list__panel__order">

            <!-- dropdown -->
            <div class="dropdown">

              <!-- button -->
              <button type="button" class="heroes-list__panel__order__btn dropdown-button">
                <span>{{ _e( 'Sort ', 'pmf' ) }}</span>
              </button>
              <!-- end button -->

              <!-- list -->
              <ul class="dropdown-window">
                <li>

                    <input type="radio" name="sort[]" value="Youngest" id="sort-1">
                    <label for="sort-1">{{ _e( 'Youngest', 'pmf' ) }}</label>


                </li>
                <li>

                    <input type="radio" name="sort[]" value="Oldest" id="sort-2">
                    <label for="sort-2">{{ _e( 'Oldest', 'pmf' ) }}</label>


                </li>
                <li>

                    <input type="radio" name="sort[]" value="desc" id="sort-3">
                    <label for="sort-3">{{ _e( 'Alphabetically Descending', 'pmf' ) }}</label>


                </li>
                <li>
                  <a href="#">
                    <input type="radio" name="sort[]" value="asc" id="sort-4">
                    <label for="sort-4">{{ _e( 'Alphabetically Ascending', 'pmf' ) }}</label>

                  </a>
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
    </form>
    <!-- End Form -->

    <!-- List -->
    <div class="heroes-list__list">

      @foreach($slides as $post)
        @php setup_postdata($post) @endphp

            @include('partials.heroes-list-item')
      @endforeach
      @php wp_reset_postdata(); @endphp

    </div>
    <!-- End List -->

  </div>
  <!-- End Container -->
</section>
<!-- End Component: Heroes List -->
