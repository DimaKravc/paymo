<?php
if (!function_exists('payment_frame_render')):
    function payment_frame_render($attributes)
    {
        $res = '<div class="payment-frame--wrap">';
            $res .= '<div class="payment-frame">';
                $res .= '<ul class="payment-frame__tabs">';
                    $res .= '<li class="payment-frame__tabs__item"><a href="#" data-target="#popup-frame" class="active"><span class="i-popup-frame"></span>Всплывающий<br>фрейм</a></li>';
                    $res .= '<li class="payment-frame__tabs__item"><a href="#" data-target="#inbuilt-frame"><span class="i-inbuilt-frame"></span>Встроенный<br>фрейм</a></li>';
                $res .= '</ul>';

                $res .= '<div data-id="#popup-frame">';
                    $res .= '<div class="payment-frame__content">';
                        $res .= '<form class="form payment-frame__content__col" data-frame="form">';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="api_key">API KEY:</label>';
                                if (isset($attributes['api_key'])):
                                    $res .= '<input type="text" name="api_key" id="api_key" value="'. esc_attr($attributes['api_key']) .'" autocomplete="off" />';
                                else:
                                    $res .= '<input type="text" name="api_key" id="api_key" value="'. esc_attr('e5ebc0d4-f90b-409b-874c-c729987001da') .'" autocomplete="off" />';
                                endif;
                            $res .= '</div>';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="tx_id">ID Транзакции:</label>';
                                $res .= '<input type="text" name="tx_id" id="tx_id" value="" autocomplete="off" />';
                            $res .= '</div>';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="description">Описание платежа:</label>';
                                if (isset($attributes['description'])):
                                    $res .= '<input type="text" name="description" id="description" value="'. esc_attr($attributes['description']) .'" autocomplete="off" />';
                                else:
                                    $res .= '<input type="text" name="description" id="description" value="'. esc_attr('Test payment') .'" autocomplete="off" />';
                                endif;
                            $res .= '</div>';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="amount">Сумма:</label>';
                                if (isset($attributes['amount'])):
                                    $res .= '<input type="text" name="amount" id="amount" value="'. esc_attr($attributes['amount']) .'" autocomplete="off" />';
                                else:
                                    $res .= '<input type="text" name="amount" id="amount" value="'. esc_attr(1000) .'" autocomplete="off" />';
                                endif;
                            $res .= '</div>';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="success_redirect">Переход на URL в случае успешного платежа:</label>';
                                if (isset($attributes['success_redirect'])):
                                    $res .= '<input type="text" name="success_redirect" id="success_redirect" value="'. esc_attr($attributes['success_redirect']) .'" autocomplete="off" />';
                                else:
                                    $res .= '<input type="text" name="success_redirect" id="success_redirect" value="'. esc_attr('http://yoursite.ru/success_redirect') .'" autocomplete="off" />';
                                endif;
                            $res .= '</div>';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="fail_redirect">Переход на URL в случае ошибки:</label>';
                                if (isset($attributes['fail_redirect'])):
                                    $res .= '<input type="text" name="fail_redirect" id="fail_redirect" value="'. esc_attr($attributes['fail_redirect']) .'" autocomplete="off" />';
                                else:
                                    $res .= '<input type="text" name="fail_redirect" id="fail_redirect" value="'. esc_attr('http://yoursite.ru/success_redirect') .'" autocomplete="off" />';
                                endif;
                            $res .= '</div>';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="signature">Подпись:</label>';
                                if (isset($attributes['signature'])):
                                    $res .= '<input type="text" name="signature" id="signature" value="'. esc_attr($attributes['signature']) .'" autocomplete="off" />';
                                else:
                                    $res .= '<input type="text" name="signature" id="signature" placeholder="" />';
                                endif;
                            $res .= '</div>';
                        $res .= '</form>';

                        $res .= '<div class="payment-frame__content__col code-snippet--wrap">';
                            $res .= '<div class="code-snippet">';
                                $res .= '<pre data-frame="snippet"></pre>';
                                $res .= '<button class="code-snippet__copy-toggle" data-js="copy-code"><span class="code-snippet__tooltip">Скопировано в буфер обмена</span></button>';
                            $res .= '</div>';
                        $res .= '</div>';
                    $res .= '</div>';
                    $res .= '<div class="payment-frame__controls">';
                        $res .= '<button data-frame="control" class="button">Вызвать фрейм</button>';
                    $res .= '</div>';
                $res .= '</div>';

                $res .= '<div class="payment-frame__content" data-id="#inbuilt-frame" style="margin-bottom: 0">';
                    $res .= '<div id="iframe-target" style="margin: 15px auto 0;"></div>';
                $res .= '</div>';
            $res .= '</div>';
        $res .= '</div>';
        $res .= '<script>jQuery(window).load(function() {Application.widgets.frameInit()});</script>';
        $res .= '<script src="https://paymo.ru/paymentgate/iframe/checkout.js"></script>';

        return $res;
    }
endif;
add_shortcode('payment-frame', 'payment_frame_render');