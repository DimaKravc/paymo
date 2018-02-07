jQuery(document).ready(function ($) {
    'use strict';

    /**
     *  Application Init
     *  Init Application widgets and components.
     *  @todo Search form.
     */

    Application.init({
        searchForm: function () {
            var $form = $('[data-js="site-search"]');

            $form.on('input', 'input[type="text"]', function () {
                var $field = $(this);
                var keyword = $field.val();

                if (keyword) {
                    $.post(paymo_ajax_data.url, {
                        action: 'preview_search',
                        nonce_code: paymo_ajax_data.nonce,
                        keyword: keyword
                    }, function (response) {
                        console.log(response)
                    })
                }
            })
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
        },
        frameInit: function () {
            var module = {};

            function generateTransactionId() {
                function s4() {
                    return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1)
                }

                return s4() + s4()
            }

            module.data = {
                api_key: null,
                tx_id: null,
                description: null,
                amount: null,
                signature: null,
                success_redirect: null,
                fail_redirect: null
            };

            module.updateData = function () {
                var formData = module.$form.serializeArray();

                formData.map(function (currentValue, index, array) {
                    module.data[currentValue.name] = currentValue.value
                });
            };

            module.getCodeSnippet = function () {
                var template = '&lt;script src="https://paymo.ru/paymentgate/\n' +
                    'iframe/checkout.js"&gt;&lt;/script&gt;\n' +
                    '&lt;script&gt;\n' +
                    '    PaymoFrame.set({\n' +
                    '        parent_id: "iframe_parent",\n' +
                    '        api_key: "<span style="color: #00acc1;"><strong>' + module.data.api_key + '</strong></span>",\n' +
                    '        tx_id: "<span style="color: #00acc1;"><strong>' + module.data.tx_id + '</strong></span>",\n' +
                    '        description: "<span style="color: #00acc1;"><strong>' + module.data.description + '</strong></span>",\n' +
                    '        amount: <span style="color: #00acc1;"><strong>' + module.data.amount + '</strong></span>,\n' +
                    '        signature: "<span style="color: #00acc1;"><strong>' + module.data.signature + '</strong></span>",\n' +
                    '        success_redirect: "<span style="color: #00acc1;"><strong>' + module.data.success_redirect + '</strong></span>",\n' +
                    '        fail_redirect: "<span style="color: #00acc1;"><strong>' + module.data.fail_redirect + '</strong></span>",\n' +
                    '        rebill: {},\n' +
                    '        extra: {},\n' +
                    '        version: "2.0.0"\n' +
                    '    })\n' +
                    '&lt;/script&gt;\n' +
                    '\n' +
                    '&lt;div id="iframe_parent"&gt;\n' +
                    '&lt;/div&gt;';

                return template;
            };

            module.init = function () {
                module.$form = $('[data-frame="form"]');
                module.$snippet = $('[data-frame="snippet"]');
                module.$control = $('[data-frame="control"]');

                module.$form.find('input[name="tx_id"]').val(generateTransactionId());

                module.updateData();
                module.$snippet.html(module.getCodeSnippet());

                var $inputs = module.$form.find('input');
                $inputs.on('keyup', function () {
                    module.updateData();
                    module.$snippet.html(module.getCodeSnippet());
                });

                module.$control.on('click', function (e) {
                    e.preventDefault();

                    PaymoFrame && PaymoFrame.open({
                        api_key: module.data.api_key,
                        tx_id: module.data.tx_id,
                        description: module.data.description,
                        amount: module.data.amount * 100,
                        signature: module.data.signature,
                        success_redirect: module.data.success_redirect,
                        fail_redirect: module.data.fail_redirect,
                        rebill: {},
                        extra: {},
                        version: "2.0.0"
                    });
                });

                var $tabs = $('[data-target]');

                $tabs.on('change.tabs', function (event) {
                   if (event.target.dataset.target === '#inbuilt-frame') {
                       PaymoFrame && PaymoFrame.set({
                           parent_id: "iframe-target",
                           api_key: module.data.api_key,
                           tx_id: module.data.tx_id,
                           description: module.data.description,
                           amount: module.data.amount * 100,
                           signature: module.data.signature,
                           success_redirect: module.data.success_redirect,
                           fail_redirect: module.data.fail_redirect,
                           rebill: {},
                           extra: {},
                           version: "2.0.0"
                       });
                   }
                });
            };

            return module.init
        },
        autoSelect: function () {
            var $els = $('[data-js="autoselect"]');

            $els.focus(function () {
                $(this).select();
            });
        },
        tabsInit: function () {
            var $tabs = $('[data-target]');
            var $entries = $('[data-id]');
            var tabEvent = new Event('change.tabs');

            $entries.each(function (index, item) {
                if (!$('[data-target="' + this.dataset.id + '"]').hasClass('active')) {
                    $(item).hide();
                }
            });

            $tabs.on('click', function (event) {
                event.preventDefault();
                var $this = $(this);

                if (!$this.hasClass('active')) {
                    $this.trigger('change.tabs');

                    // Tab classes update
                    $tabs.removeClass('active');

                    $this.addClass('active');
                    // Entry update
                    $entries.hide();
                    $('[data-id="' + this.dataset.target + '"]').show(0);
                }
            });
        }
    })
});