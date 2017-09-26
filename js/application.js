jQuery(document).ready(function ($) {
    'use strict';

    /**
     *  Application Init
     *  Init Application widgets and components.
     *  @todo Search form.
     */

    Application.init({
        searchForm: function () {
            var $form = $('.site-search');
            var $input = $form.find('[data-js="search-field"]');
            //var $resultBlock = $form.find('[data-js="search-result"]');

            $input.on('focus blur', function () {
                $(this).closest('.site-search')
                    .toggleClass('--focus')
            });

            $form.on('submit', function (e) {
                e.preventDefault();

                var $this = $(this),
                    value = $(this).find('[data-js="search-field"]').val(),
                    $resultBlock = $this.find('[data-js="search-result"]');

                if (value.length >= 3) {
                    $resultBlock.html('');
                    queryPosts($this, {"s": value, "location": window.location.href})
                }

                $(document).mouseup(function (e) {
                    if (!$this.is(e.target) && !$this.has(e.target).length) {
                        $this.removeClass('--searched');
                        $resultBlock.html();
                    }
                })
            });

            var queryPosts = function ($form, str) {
                $.ajax({
                    url: search_ajax['url'] + '?action=search_action&ajax_nonce=' + search_ajax['nonce'],
                    type: 'POST',
                    data: str,
                    beforeSend: function () {
                        $form.addClass('--searching');
                    },
                    success: function (data) {
                        $form.find('[data-js="search-result"]')
                            .html(data)
                            .ajaxify();
                    },
                    error: function (err) {
                        console.warn(err)
                    },
                    complete: function () {
                        $form.removeClass('--searching').addClass('--searched')
                    }
                })
            }
        },
        sidebar: function () {
            var $sidebarToggle = $('[data-js="sidebar-toggle"]'),
                $body = $('body');

            if (!$($sidebarToggle).data('events')) {
                $sidebarToggle.on('click', function () {
                    $body.toggleClass('--sidebar-show')
                })
            }
        },
        sidebarMobile: function () {
            if ($('body').hasClass('admin-bar')) {
                var $sidebar = $('.sidebar'),
                    $offsetHeight = $('#wpadminbar').outerHeight();
                $(window).on('scroll resize', function () {
                    var winCurrentPos = $(this).scrollTop();
                    if (window.innerWidth <= 600) {
                        if (winCurrentPos <= $offsetHeight) {
                            $sidebar.css('top', $offsetHeight - winCurrentPos)
                        } else {
                            $sidebar.css('top', 0)
                        }
                    } else {
                        $sidebar.removeAttr('style')
                    }
                })
            }
        },
        clipBoard: function () {
            var $copyCodeToggle = $('[data-js="copy-code"]'),
                clipboardStorageSelector = '[data-js="clipboard"]',
                $clipboardStorage = $(clipboardStorageSelector);

            if (!$clipboardStorage.length) {
                $('body').append('<textarea class="hidden" data-js="clipboard"></textarea>');
                $clipboardStorage = $(clipboardStorageSelector);
            }

            $copyCodeToggle.on('click', function (e) {
                e.preventDefault();
                var $this = $(this);

                if ($this.hasClass('--copied')) return;

                $copyCodeToggle.removeClass('--copied');
                $clipboardStorage.val(e.target.parentNode.querySelector('pre').textContent);
                $clipboardStorage.select();
                try {
                    document.execCommand("Copy");
                    $(this).addClass('--copied');
                    setTimeout(function () {
                        $this.removeClass('--copied')
                    }, 2000)
                } catch (err) {
                    console.log('Oops, unable to copy');
                }
            })
        },
        anchorNav: function () {
            var topOffset = $('body').hasClass('admin-bar') ? 60 : 15,
                $menuItems = $('.menu a[href^="#"]'),
                $targetItems = $menuItems.map(function (e) {
                    var item = $($(this).attr('href'));
                    if (item.length)
                        return item
                });

            $menuItems.on('click', function (e) {
                e.preventDefault();
                var $targetItem = $($(this).attr('href'));
                if ($targetItem.length) {
                    $('html, body').stop().animate({
                        scrollTop: $targetItem.offset().top - topOffset + 1
                    }, 1000)
                }
            });

            $(window).on('scroll', function (e) {
                var fromTop = $(this).scrollTop() + topOffset,
                    current = $targetItems.map(function () {
                        if ($(this).offset().top < fromTop)
                            return this
                    });
                current = current[current.length - 1];
                var id = current && current.length ? current[0].id : "";
                $menuItems
                    .parent().removeClass('current-menu-item')
                    .end()
                    .filter("[href='#" + id + "']").parent().addClass('current-menu-item')
            });

            $(window).on('load', function (e) {
                var id = this.location.hash;
                if (id) {
                    var $targetItem = $(id);
                    if ($targetItem.length) {
                        $('html, body').animate({
                            scrollTop: $targetItem.offset().top - topOffset + 1
                        }, 1000)
                    }
                }
            })
        },
        backToTop: function () {
            var offset = 3000,
                toggleSelector = '[data-js="scroll-to-top"]',
                $toggle = $(toggleSelector);

            if (!$toggle.length) {
                $('body').append('<a href="#" class="scroll-to-top" data-js="scroll-to-top"></a>');
                $toggle = $(toggleSelector);
            }

            $(window).scroll(function () {
                ( $(this).scrollTop() > offset ) ? $toggle.addClass('--show') : $toggle.removeClass('--show');
            });

            $toggle.on('click', function (event) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: 0
                }, 1000)
            });
        }
    })
});