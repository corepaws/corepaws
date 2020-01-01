// v1
var $ = jQuery;
var WPTHEME = '/wp-content/themes/CorePaws-v2/';
var DOMAIN = location.protocol + "//" + location.host;

jQuery(document).ready(function ($) {
    // Doc ready functions
    GAtracking();
});


// ===================================================================
// Function with all of the general Google Analytics Tracking
// ===================================================================
function GAtracking() {
    // Custom Google Analytics tracking code
    // ...
}


// ===================================================================
// Function to gather all of the search criteria and submit the page
// ===================================================================
function petSearch() {

    $('#sidebar .controls button').click(function () {
        var search = {};
        var url = '';

        $("input[name='animal']:checked").each(function () {
            if (search['animal'] === undefined) {
                search['animal'] = $(this).val();
            } else {
                search['animal'] += ',' + $(this).val();
            }
        });

        $("input[name='category']:checked").each(function () {
            if (search['category'] === undefined) {
                search['category'] = $(this).val();
            } else {
                search['category'] += ',' + $(this).val();
            }
        });

        //Creates search URL
        $.each(search, function (key, value) {
            if (url.length === 0) {
                url = '?' + key + '=' + value;
            } else {
                url += '&' + key + '=' + value;
            }
        });

        // Use "search" variable to record events if desired

        window.location = DOMAIN + '/adoption/' + url;
    });

}

// ===================================================================
// Function to initialize Featured Pets Carousel
// ===================================================================
function initFeaturedCarousel() {
    $('#featured .carousel').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {breakpoint: 960, settings: {slidesToShow: 3}},
            {breakpoint: 768, settings: {slidesToShow: 2}},
            {breakpoint: 480, settings: {slidesToShow: 1}}
        ]
    });
}


// ===================================================================
// Function to initialize Gallery Carousel
// ===================================================================
function initGalleryCarousel() {
    $('#gallery .carousel').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false
    });
    $('#gallery .thumbnails .thumb').click(function () {
        $('#gallery .carousel').slick('slickGoTo', $(this).attr('data-thumb'));
    });
}


// ===================================================================
// Function for the FAQ show/hide feature
// ===================================================================
function initFAQ() {
    $('.answer').hide();
    $('h3.question').click(function () {
        if ($(this).hasClass('active')) {
            $(this).next('.answer').slideUp('fase', function () {
                $(this).prev('h3.question').removeClass('active');
            });
        } else {
            $(this).next('.answer').slideDown('slow', function () {
                $(this).prev('h3.question').addClass('active');
            });
        }
    });
}

// ===================================================================
// Global Function to determine what page is viewed based on main ID
// ===================================================================
function isPage(a) {

    var array = a.split(',');
    if (array.length === 2) {
        return $("#" + array[0]).length && $("main").attr("data-sub") === array[1];
    } else {
        return $("#" + a).length;
    }

}

// v2
function sizeElements(element) {
    var maxHeight = 0;
    console.log(element);
    $(element).height('auto');
    $(element).each(function () {
        maxHeight = $(this).height() > maxHeight ? $(this).height() : maxHeight;
    });
    $(element).css('height', maxHeight);
}

// basic slider initialization function
function initSlick(slider, args) {
    $(slider).slick(args);
}

// slider with custom pagination thumbnails. defined args, reusable on same-structural elements
function infoSlider(blockID) {
    gallery = $(blockID).find('.gallery');
    thumbs = $(blockID).find('.thumbnails');
    $(gallery).slick({
        dots: true,
        infinite: true,
        arrows: false,
        appendDots: $(thumbs),
        customPaging: function (slider, i) {
            var thumb = $(slider.$slides[i]).data('thumb');
            return '<a><img src="' + thumb + '"></a>';
        },
    })
}

function sizeFooterColumns() {
    $('#footer-center').height($('#footer-left').height())
}

// active video player button on homepage
// muted: show iframe embed and hide thumbnail + play button\
function videoPlayer() {
    $('a.video').click(function () {
        $me = $(this);
        $id = $me.attr('yt-id');
        popVideo($id);
    })
}

// resize iframe after play
function resizeVideo() {
    var $frame = $('iframe');
    var width = $('.video').width();
    $frame.attr('width', width);
    $frame.attr('height', (width * 3 / 5));
}

// mobile menu
function menu() {
    // mobile menu clicks
    $('#burger').on('click', function () {
        $('#menu').toggleClass('open');
        $('#burger').toggleClass('open');
        $('html').toggleClass('scroll-lock');
    });
}

function popVideo(id) {
    $tar = $('#videobox');
    $tar.addClass('on');
    $str = '<div class="video-frame"><div class="videowrapper"><iframe width="560" height="315" src="https://www.youtube.com/embed/' + id + '?autoplay=1&controls=0" frameborder="0" allowfullscreen></iframe></div></div>';
    $tar.html($str);
}

function killVideo() {
    $tar = $('#videobox');
    $tar.removeClass('on');
    $tar.html('');
}

jQuery(document).ready(function ($) {
    menu();
    sizeFooterColumns();

    $(window).resize(function () {
        sizeFooterColumns();
    });

    if ($('header #navbar > li.current-menu-ancestor').length > 0) {
        $('header #navbar > li.current-menu-ancestor').addClass('mobile-open').addClass('show-sub');
    }

    // MOBILE MENU SWITCH-A-ROO
    $('header #navbar > li > a').each(function () {
        $(this).on('click', function (e) {
            if ($(window).width() < 980) {
                e.preventDefault();
                $it = $(this).parent();
                console.log('hi');
                if (!$it.hasClass('mobile-open show-sub')) {
                    if ($('#navbar.menu .mobile-open.show-sub').length > 0) {
                        $('#navbar.menu .mobile-open.show-sub').removeClass('mobile-open show-sub');
                    }
                    $it.addClass('mobile-open show-sub');
                } else {
                    $it.removeClass('mobile-open show-sub');
                    $('#navbar.menu > li.current-menu-ancestor').addClass('mobile-open').addClass('show-sub');
                }
            }
        });
    });


    // OFF SITE LINKS
    $('a[href]').not('a[href*="' + DOMAIN + '"]').not('a[href*="mailto"]').each(function () { //
        $(this).attr('target', '_blank');
    });


    // HOME LOAD FUNCTIONS
    if ($('.page.home').length > 0) {
        // sizing function on load and on window resize
        sizeElements('.preview-text');
        $(window).resize(function () {
            sizeElements('.preview-text');
            resizeVideo();
        });
        videoPlayer();

    }

    // YouTube lightbox link action
    if ($('.yt-lb').length > 0) {
        $('.yt-lb').each(function () {
            $me = $(this);
            $id = $me.attr('yt-id');
            $me.on('click', function () {
                popVideo($id);
            });
        });
        $('.video-lightbox').on('click', function () {
            killVideo();
        });
        $('body').keyup(function (event) {
            if (event.which === 27) {
                killVideo();
            }
        });
    }

    // Testimonial Carousel Functionality
    if ($('#testimonial-slides').length > 0) {
        initSlick($('#testimonial-slides'), {
            nextArrow: '<button type="button" class="slick-next"><img src="' + theme + '/img/arrow_r.png"></button>',
            prevArrow: '<button type="button" class="slick-prev"><img src="' + theme + '/img/arrow_l.png"></button>',
            dots: true,
            appendDots: $("#tesimonial-dots"),
            autoplay: true,
            autoplaySpeed: 13000,
        });
    }

    // Hero Carousel Functionality
    if ($('#hero .bg-frame .caro').length > 0) {
        initSlick($('#hero .bg-frame .caro'), {
            autoplay: true,
            arrows: false
        });

    }

    // FAQ Page functionality
    if ($('.page-frequently-asked-questions').length > 0) {
        $('.page-frequently-asked-questions .faq').addClass('armed');
        $('.faq .question').each(function () {
            $i = $(this);
            $j = $i.next();
            $j.hide();

            $i.on('click', function () {
                $me = $(this);
                if (!$me.hasClass('active')) {
                    if ($('.faq .question.active').length > 0) {
                        $('.faq .active').removeClass('active').next().hide();
                    }
                    $me.addClass('active').next().slideDown();

                } else {
                    $me.removeClass('active').next().hide();
                }
            });
        });
    }

    if ($('.page.about').length > 0) {
        $('.info-block').each(function () {
            ID = '#' + $(this).attr('id');
            console.log(ID);
            infoSlider(ID);
        })
    }

    if ($('.row.map-body').length > 0) {
        initMap();
        toggleMapView();
    }

    if ($('.page.donate').length > 0) {
        initSlick($('#testimonial-slides'), {
            nextArrow: '<button type="button" class="slick-next"><img src="images/arrow_r.png"></button>',
            prevArrow: '<button type="button" class="slick-prev"><img src="images/arrow_l.png"></button>',
            dots: true,
            appendDots: $("#tesimonial-dots"),
        });

        // sizing function on load and on window resize
        sizeElements('.preview-text');
        $(window).resize(function () {
            sizeElements('.preview-text');
        })
    }

    if ($('.cloak-more').length > 0) {
        $('.mobile-switch-more').on('click', function () {
            $(this).prev().toggleClass('open');
        });
    }

});
