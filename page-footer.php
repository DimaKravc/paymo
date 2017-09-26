<?php
/**
 * Displays contact data section.
 *
 * @package PAYMO
 * @version 1.0
 */

?>
<?php
$email = get_userdata(1)->user_email;
$phone = get_userdata(1)->phone;
$clear_phone = str_replace(array('(', ')', ' ', '-'), '', $phone);
?>
<footer class="site-footer">
    <div class="how-to-contact">
        <div class="how-to-contact__caption">Как с нами связаться</div>
        <div class="how-to-contact__text">
            Если у вас есть вопросы и вы не нашли на них ответы в документации,
            пишите на <a
                href="mailto:<?php echo $email ?>"><?php echo $email; ?></a>
            или звоните нам по номеру
            <a class="how-to-contact__phone"
               href="tel:<?php echo $clear_phone ?>"><?php echo $phone ?></a>.
        </div>
    </div>
</footer>