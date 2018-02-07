<?php
if (!function_exists('demo_cards_render')):
    function demo_cards_render($attributes)
    {
        $res = '<ul class="card-list">';
            $res .= '<li class="card-list__item">';
                $res .= '<strong class="card-list__caption">С 3D Secure</strong>';
                $res .= '<div class="card">';
                    $res .= '<div class="card__mps"><span class="card__mps__icon visa animated"></span></div>';
                    $res .= '<div class="card__number">';
                        $res .= '<label for="card_num">Номер карты:</label>';
                        $res .= '<div class="card__number__inner"><input data-js="autoselect" type="text" id="card_num" readonly value="4111 1111 1111 1111"/></div>';
                    $res .= '</div>';
                    $res .= '<div class="card__expire-date">';
                        $res .= '<label for="expire_date">Срок действия:</label>';
                        $res .= '<div class="card__expire-date__inner"><input data-js="autoselect" type="text" id="expire_date" readonly value="12/24"/></div>';
                    $res .= '</div>';
                    $res .= '<div class="card__cvc">';
                        $res .= '<label for="cvc">CVC/CVV: <div class="tooltip"><p class="tooltip__content">Код CVV - это последние 3 цифры номера на обратной стороне Вашей карты.</p></div></label>';
                        $res .= '<div class="card__cvc__inner"><input data-js="autoselect" type="text" id="cvc" readonly value="123"/></div>';
                    $res .= '</div>';
                $res .= '</div>';

                $res .= '<dl class="card-list__msg"><dt>3D Secure:</dt><dd>12345678</dd></dl>';
            $res .= '</li>';
            $res .= '<li class="card-list__item">';
                $res .= '<strong class="card-list__caption">Без 3D Secure</strong>';
                $res .= '<div class="card">';
                    $res .= '<div class="card__mps"><span class="card__mps__icon mc animated"></span></div>';
                    $res .= '<div class="card__number">';
                        $res .= '<label for="card_num">Номер карты:</label>';
                        $res .= '<div class="card__number__inner"><input data-js="autoselect" type="text" id="card_num" readonly value="5555 5555 5555 5599"/></div>';
                    $res .= '</div>';
                    $res .= '<div class="card__expire-date">';
                        $res .= '<label for="expire_date">Срок действия:</label>';
                        $res .= '<div class="card__expire-date__inner"><input data-js="autoselect" type="text" id="expire_date" readonly value="12/24"/></div>';
                    $res .= '</div>';
                    $res .= '<div class="card__cvc">';
                        $res .= '<label for="cvc">CVC/CVV: <div class="tooltip"><p class="tooltip__content">Код CVV - это последние 3 цифры номера на обратной стороне Вашей карты.</p></div></label>';
                        $res .= '<div class="card__cvc__inner"><input data-js="autoselect" type="text" id="cvc" readonly value="123"/></div>';
                    $res .= '</div>';
                $res .= '</div>';
            $res .= '</li>';
        $res .= '</ul>';

        return $res;
    }
endif;
add_shortcode('demo-cards', 'demo_cards_render');