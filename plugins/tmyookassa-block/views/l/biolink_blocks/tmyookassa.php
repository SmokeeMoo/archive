<?php defined('ALTUMCODE') || die() ?>
<?php
    $data->link->design = new \StdClass();
    $data->link->design->link_class .= ' animate__animated animate__' . $data->link->settings->animation_runs . ' animate__' . $data->link->settings->animation . ' animate__delay-2s';
    $data->link->design->link_style =
    'background: ' . $data->link->settings->background_color . ';'
    . 'color: ' . $data->link->settings->text_color . ';'
    . 'border-width: ' . ($data->link->settings->border_width ?? '1') . 'px;'
    . 'border-color: ' . ($data->link->settings->border_color ?? 'transparent') . ';'
    . 'border-style: ' . ($data->link->settings->border_style ?? 'solid') . ';'
    . 'box-shadow: ' . ($data->link->settings->border_shadow_offset_x ?? '0') . 'px ' . ($data->link->settings->border_shadow_offset_y ?? '0') . 'px ' . ($data->link->settings->border_shadow_blur ?? '20') . 'px ' . ($data->link->settings->border_shadow_spread ?? '0') . 'px ' . ($data->link->settings->border_shadow_color ?? '#00000010') . ';'
    . 'text-align: ' . ($data->link->settings->text_alignment ?? 'center') . ';';
?>
<style>
    .notification {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: green;
    color: white;
    padding: 5px 14px;
    z-index: 9999;
    border-radius: 3px;
    }
    
    .checkout-modal__overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.9);
    }
</style>

<div id="<?= 'biolink_block_id_' . $data->link->biolink_block_id ?>" data-biolink-block-id="<?= $data->link->biolink_block_id ?>" class="col-12 my-2">
    <?php if ($data->link->settings->name != '') { ?><a id="open-payment-button" data-track-biolink-block-id="<?= $data->link->biolink_block_id ?>" rel="<?= $data->user->plan_settings->dofollow_is_enabled ? 'dofollow' : 'nofollow' ?>" class="btn btn-block btn-primary link-btn link-hover-animation <?= 'link-btn-' . $data->link->settings->border_radius ?> <?= $data->link->design->link_class ?>" style="<?= $data->link->design->link_style ?>" data-text-color data-border-width data-border-radius data-border-style data-border-color data-border-shadow data-animation data-background-color data-text-alignment>
        <div class="link-btn-image-wrapper <?= 'link-btn-' . $data->link->settings->border_radius ?>" <?= $data->link->settings->image ? null : 'style="display: none;"' ?>>
            <img src="<?= $data->link->settings->image ? \Altum\Uploads::get_full_url('block_thumbnail_images') . $data->link->settings->image : null ?>" class="link-btn-image" loading="lazy" />
        </div>
        
        <span data-icon>
            <?php if($data->link->settings->icon): ?>
            <i class="<?= $data->link->settings->icon ?> mr-1"></i>
            <?php endif ?>
        </span>
        
        <span data-name><?= $data->link->settings->name ?></span>
    </a><?php } ?>
    
    
    
    
    
    <script src="https://yookassa.ru/checkout-widget/v1/checkout-widget.js"></script>
    <?php
        use YooKassa\Client;
        
        $client = new Client();
        $client->setAuth($data->link->settings->shopid_block, $data->link->settings->secretkey_block);
        
        $paymentData = array(
        'amount' => array(
        'value' => $data->link->settings->amount_block,
        'currency' => $data->link->settings->currency_block,
        ),
        'confirmation' => array(
        'type' => 'embedded',
        'locale'=> 'ru_RU'
        ),
        'capture' => true,
        'description' => $data->link->settings->paymentdescription_block
        );
        try {
            $payment = $client->createPayment($paymentData);
            $confirmation_token = $payment->confirmation->confirmation_token;
        } catch (Exception $e) { }
        
    ?>
    
    
    
    <!--<script>
        function fetchConfirmationToken() {
        var shopid = <?php echo json_encode($data->link->settings->shopid_block); ?>;
        var secretkey = <?php echo json_encode($data->link->settings->secretkey_block); ?>;
        var amount = <?php echo json_encode($data->link->settings->amount_block); ?>;
        var currency = <?php echo json_encode($data->link->settings->currency_block); ?>;
        var description = <?php echo json_encode($data->link->settings->paymentdescription_block); ?>;
        
        var data = new URLSearchParams();
        data.append('shopid', shopid);
        data.append('secretkey', secretkey);
        data.append('amount', amount);
        data.append('currency', currency);
        data.append('description', description);
        
        fetch('/source/php/yookassa.php', {
        method: 'POST',
        body: data,
        })
        .then(response => response.json())
        .then(data => {
        if (data.confirmation_token) {
        var confirmation_tokent = data.confirmation_token;
        console.log("confirmation_token:", confirmation_token);
        // Дальнейшая обработка переменной
        } else {
        console.log("Ошибка: confirmation_token не получен.");
        }
        })
        .catch(error => {
        console.error("Произошла ошибка при запросе к серверу:", error);
        });
        }
        
        // Вызываем функцию для отправки запроса
        fetchConfirmationToken();
    </script>-->
    
    <div id="payment-form"></div>
    <script>
        function openPaymentForm() {
            //Инициализация виджета.
            const checkout = new window.YooMoneyCheckoutWidget({
                //confirmation_token: confirmation_tokent, //Токен, который перед проведением оплаты нужно получить из API ЮKassa
                confirmation_token: '<?php echo $confirmation_token; ?>', //Токен, который перед проведением оплаты нужно получить из API ЮKassa
                customization: {
                    //Настройка способа отображения
                    modal: true,
                    colors: {
                        //Цвет акцентных элементов: кнопка Заплатить, выбранные переключатели, опции и текстовые поля
                        control_primary: '#00BF96', //Значение цвета в HEX
                        
                        //Цвет платежной формы и ее элементов
                        background: '#F2F3F5' //Значение цвета в HEX
                    }
                },
                error_callback: function(error) {
                    //Обработка ошибок инициализации
                }
            });
            
            checkout.on('complete', () => {
                //Код, который нужно выполнить после оплаты.
                checkout.destroy();
                function showNotification(message) {
                    const notification = document.createElement('div');
                    notification.className = 'notification';
                    notification.textContent = message;
                    document.body.appendChild(notification);
                    
                    setTimeout(function () {
                        document.body.removeChild(notification);
                        //location.reload();
                    }, 5000); // Удалить уведомление через 5 секунд (или другой период времени по вашему усмотрению)
                }
                
                // Используйте функцию showNotification() для отображения уведомлений
                showNotification('<?= $data->link->settings->successpayment_block ?>');
                //Удаление инициализированного виджета
                checkout.destroy();
            });
            
            //Отображение платежной формы в контейнере
            checkout.render('payment-form')
            
        }
        
        // Добавьте слушателя события на кнопку
        document.getElementById('open-payment-button').addEventListener('click', openPaymentForm);
    </script>
    
    
    
</div>

