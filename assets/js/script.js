jQuery(document).ready(function ($) {
  $(".top-bar .close button").on("click", function (e) {
    e.preventDefault();
    $(".top-bar").parent().parent().parent().parent().parent().hide();
  });

  const slides = $(".custom-carousel .list-item");
  const interval = 5000;
  let currentIndex = 0;
  var sliderInterval = null;

  const dots = $(".custom-carousel .controls ul li button");
  const play = $(".custom-carousel .play");

  function showSlide(index) {
    slides.hide();
    slides.eq(index).fadeIn();
    dots.parent().removeClass("active");
    dots.eq(index).parent().addClass("active");
  }

  function autoSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  dots.on("click", function () {
    const dotIndex = $(this).data("index");
    showSlide(dotIndex);
    currentIndex = dotIndex;
    clearInterval(sliderInterval);
    sliderInterval = setInterval(autoSlide, interval);
  });

  play.on("click", function () {
    if (!sliderInterval) sliderInterval = setInterval(autoSlide, interval);
  });
});

jQuery(document).ready(function ($) {
  let currentPage = 1;

  $('.woo-archive-grid .woo-read-more a').on('click', function (e) {
    e.preventDefault();

    currentPage++;
    var product_cat = $(".woo-filters #product_cat").val();
    var s = $(".woo-filters #s").val();
    var orderby = $(".woo-filters #orderby").val();
    var categories = [];
    $('.woo-filters .filter-group .dropdown-check-list .category:checked').each(function () {
      categories.push($(this).attr('value'));
    });
    var tags = [];
    $('.woo-filters .filter-group .dropdown-check-list .tag:checked').each(function () {
      tags.push($(this).attr('value'));
    });

    $(".woo-archive-grid .woo-read-more a span").show();

    $.ajax({
      type: 'POST',
      url: '/wp-admin/admin-ajax.php',
      dataType: 'json',
      data: {
        action: 'woo_product_load_more',
        paged: currentPage,
        product_cat: product_cat,
        orderby: orderby,
        categories: categories,
        tags: tags,
        s: s,
      },
      success: function (res) {
        $(".woo-archive-grid .woo-read-more a span").hide();

        $('.woo-archive-grid .woo-archive-grid-wrapper').append(res.render);
        $('.woo-archive-grid .woocommerce-result-count #post_count').text($(".woo-archive-grid .woo-archive-grid-wrapper .woo-item").length);
      }
    });
  });

  $(".woo-filters .search-filter").on("click", "button", function (e) {
    e.preventDefault();
    filterProduct();
  });

  $(".woo-filters .filter-group").on("change", ".woo-orderby", function (e) {
    e.preventDefault();
    filterProduct();
  });

  $(".woo-filters .filter-group .dropdown-check-list input").on("change", function () {
    filterProduct();
  });

  function filterProduct() {
    currentPage = 1;
    var product_cat = $(".woo-filters #product_cat").val();
    var s = $(".woo-filters #s").val();
    var orderby = $(".woo-filters #orderby").val();
    var categories = [];
    $('.woo-filters .filter-group .dropdown-check-list .category:checked').each(function () {
      categories.push($(this).attr('value'));
    });
    var tags = [];
    $('.woo-filters .filter-group .dropdown-check-list .tag:checked').each(function () {
      tags.push($(this).attr('value'));
    });

    $.ajax({
      type: 'POST',
      url: '/wp-admin/admin-ajax.php',
      dataType: 'json',
      data: {
        action: 'woo_search_product',
        paged: currentPage,
        product_cat: product_cat,
        orderby: orderby,
        categories: categories,
        tags: tags,
        s: s,
      },
      success: function (res) {
        $('.woo-archive-grid .woo-archive-grid-wrapper').html(res.render);
        $('.woo-archive-grid .woocommerce-result-count #post_count').text(res.post_count);
        $('.woo-archive-grid .woocommerce-result-count #found_posts').text(res.found_posts);
      }
    });
  }

  $(".woo-filters .woocommerce-ordering").on("change", "select.orderby", function () {
    $(this).closest("form").trigger("submit")
  });

  $(".woo-filters .search-filter").on("keyup", "input", function (e) {
  });

  $(".woo-filters .dropdown-check-list .anchor").on("click", function () {
    $(this).parent().find(".items").slideToggle();
    $(this).parent().toggleClass("visible");
  });

  $("body").on("click", ".woo-sugestao-uso.close .title-wrapper", function () {
    $(this).parent().find(".content").slideDown();
    $(this).parent().removeClass("close");
    $(this).parent().addClass("open");
  });

  $("body").on("click", ".woo-sugestao-uso.open .title-wrapper", function () {
    $(this).parent().find(".content").slideUp();
    $(this).parent().removeClass("open");
    $(this).parent().addClass("close");
  });
});