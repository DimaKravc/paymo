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

                $res .= '<form class="form" data-id="#popup-frame" data-frame="form" method="post">';
                    $res .= '<div class="payment-frame__content">';
                        $res .= '<div class="payment-frame__content__col">';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="api_key">API KEY:</label>';
                                $res .= '<div class="form__field__inner">';
                                    if (isset($attributes['api_key'])):
                                        $res .= '<input type="text" name="api_key" id="api_key" value="'. esc_attr($attributes['api_key']) .'" autocomplete="off" data-required="true" onkeypress="return /[-\w\d]/.test(event.key)" />';
                                    else:
                                        $res .= '<input type="text" name="api_key" id="api_key" value="'. esc_attr('e5ebc0d4-f90b-409b-874c-c729987001da') .'" autocomplete="off" data-required="true" onkeypress="return /[-\w\d]/.test(event.key)" />';
                                    endif;
                                    $res .= '<p class="error-message" data-js="error-tooltip">Поле не соответсвует шаблону.</p>';
                                $res .= '</div>';
                            $res .= '</div>';
                            $res .= '<div class="form__field">';
                                $res .= '<label for="tx_id">ID Транзакции:</label>';
                                $res .= '<div class="form__field__inner">';
                                    $res .= '<input type="text" name="tx_id" id="tx_id" value="" autocomplete="off" data-required="true" onkeypress="return /[\w\d]/.test(event.key)" />';
                                    $res .= '<p class="error-message" data-js="error-tooltip">Поле не может быть пустым.</p>';
                                $res .= '</div>';
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
                                $res .= '<div class="form__field__inner">';
                                    if (isset($attributes['amount'])):
                                        $res .= '<input type="text" name="amount" id="amount" value="'. esc_attr($attributes['amount']) .'" autocomplete="off" data-required="true" onkeypress="return /[\d]/.test(event.key)" />';
                                    else:
                                        $res .= '<input type="text" name="amount" id="amount" value="'. esc_attr(1000) .'" autocomplete="off" data-required="true" onkeypress="return /[\d]/.test(event.key)" />';
                                    endif;
                                    $res .= '<p class="error-message" data-js="error-tooltip">Поле не может быть пустым.</p>';
                                $res .= '</div>';
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
                        $res .= '</div>';

                        $res .= '<div class="payment-frame__content__col code-snippet--wrap">';
                            $res .= '<div class="code-snippet">';
                                $res .= '<pre data-frame="snippet"></pre>';
                                $res .= '<button class="code-snippet__copy-toggle" data-js="copy-code"><span class="code-snippet__tooltip">Скопировано в буфер обмена</span></button>';
                            $res .= '</div>';
                        $res .= '</div>';
                    $res .= '</div>';
                    $res .= '<div class="payment-frame__controls">';
                        $res .= '<button type="submit" data-frame="control" class="button">Вызвать фрейм</button>';
                    $res .= '</div>';
                $res .= '</form>';

                $res .= '<div class="payment-frame__content payment-frame__inbuilt" data-id="#inbuilt-frame" style="display: none;">';
                    $res .= '<div id="iframe-target" class="payment-frame__inbuilt__area"></div>';
                    $res .= '<div class="preloader--wrap" data-frame="preloader"><svg class="preloader" viewBox="0 0 500 500"><circle cx="250" cy="250" r="100" class="preloader__spinner-track" /><circle cx="250" cy="250" r="100" class="preloader__spinner" ></circle></svg></div>';
                $res .= '</div>';
            $res .= '</div>';
        $res .= '</div>';
        $res .= '<script>jQuery(window).load(function() {Application.widgets.frameInit()});</script>';
        $res .= '<script src="https://paymo.ru/paymentgate/iframe/checkout.js"></script>';

        return $res;
    }
endif;
add_shortcode('payment-frame', 'payment_frame_render');