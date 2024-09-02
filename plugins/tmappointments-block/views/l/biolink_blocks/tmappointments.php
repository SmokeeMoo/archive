<?php defined('ALTUMCODE') || die() ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .modal-backdrop {
    display: none;
    }
    
    .datepicker td, .datepicker th {
    text-align: center;
    width: 30px;
    height: 30px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 5px;
    border: none;
    }
    
    .datepicker {
    padding: 15px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    background: linear-gradient(to bottom, #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    text-align: center;
    }
    
    .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
    color: #9999997d;
    font-weight: normal;
    }
    
    .datepicker td, .datepicker th {
    font-weight: bold;
    }
    
</style>

<?php 
    $get_time_slots_booking = db()->where('biolink_block_id', $data->link->biolink_block_id)->get('booking');
    $bookedSlots = [];
    foreach($get_time_slots_booking as $booking) {
        $bookedSlots[] = [
        'date' => $booking->booking_date,
        'booking_time' => $booking->booking_time,
        ];
    }
?>

<div id="<?= 'biolink_block_id_' . $data->link->biolink_block_id ?>" data-biolink-block-id="<?= $data->link->biolink_block_id ?>" class="col-12 my-2">
    
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
	
	<a data-toggle="modal" data-target="#bookingModal" class="btn btn-block btn-primary link-btn link-hover-animation <?= 'link-btn-' . $data->link->settings->border_radius ?> <?= $data->link->design->link_class ?>" style="<?= $data->link->design->link_style ?>" data-text-color data-border-width data-border-radius data-border-style data-border-color data-border-shadow data-animation data-background-color data-text-alignment>
        <div class="link-btn-image-wrapper <?= 'link-btn-' . $data->link->settings->border_radius ?>" <?= $data->link->settings->image ? null : 'style="display: none;"' ?>>
            <img src="<?= $data->link->settings->image ? \Altum\Uploads::get_full_url('block_thumbnail_images') . $data->link->settings->image : null ?>" class="link-btn-image" loading="lazy" />
        </div>
        
        <span data-icon>
            <?php if($data->link->settings->icon): ?>
            <i class="<?= $data->link->settings->icon ?> mr-1"></i>
            <?php endif ?>
        </span>
        
        <span data-name><?= $data->link->settings->name ?></span>
    </a>
    
    <div class="modal" id="bookingModal" style="background: #0000009e;">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h4 class="modal-title"><?= $data->link->settings->name ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body">
                    <form id="booking_form" method="post">
                        <input type="hidden" name="biolink_block_id" value="<?= $data->link->biolink_block_id ?>">
                        <input type="hidden" name="link_id" value="<?= $data->link->link_id ?>">
                        <input type="hidden" name="user_id" value="<?= $data->link->user_id ?>">
                        <div class="row g-3">
                            <div class="form-group col-6 mb-md-1 p-2">
                                <input
                                type="text"
                                id="booking_date"
                                name="booking_date"
                                placeholder="<?= l('tmappointment_form.enter_date') ?>"
                                class="datepicker form-control"
                                autocomplete="off"
                                data-daterangepicker
                                >
                            </div>
                            <div class="form-group col-6 mb-md-1 p-2">
                                <select id="booking_time" name="booking_time" class="form-control" style="text-align:center; background: linear-gradient(to bottom, #ffffff 0%,#f6f6f6 47%,#ededed 100%);" disabled>
                                    <option value="">--:--</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="form-group col-12 mb-md-1 p-1">
                                <input type="text" id="name" name="name" class="form-control" placeholder="<?= l('tmappointment_form.enter_name') ?>" required>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            
                            <div class="form-group col-6 mb-md-1 p-1">
                                <input type="email" id="email" name="email" class="form-control" placeholder="<?= l('tmappointment_form.enter_email') ?>" required>
                            </div>
                            <div class="form-group col-6 mb-md-1 p-1">
                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="<?= l('tmappointment_form.enter_phone') ?>" pattern="^\+?\d{0,18}" required>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            
                            <div class="form-group col-12 mb-md-1 p-1">
                                <label><?= l('tmappointment_form.select_service') ?></label>
                                <select id="service" name="service" class="form-control" style="text-align:center; background: linear-gradient(to bottom, #ffffff 0%,#f6f6f6 47%,#ededed 100%);">
                                    <?php foreach($data->link->settings->items as $key => $item): ?>
                                    <option value="<?= $item->title ?>"><?= $item->title ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" style="margin-top: 1rem;"><?= $data->link->settings->button_name ?></button>
                    </form>
                    
                </div>
                
                <div class="modal-footer" style="margin: 0 auto;">
                    <div id="loading_icon" class="spinner-border text-primary" role="status" style="display: none;">
                        <span class="sr-only"><?= l('tmappointment_form_loading') ?></span>
                    </div>
                    <div id="booking_response_message" class="alert alert-success d-none"></div>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        var bookedSlots = <?= json_encode($bookedSlots); ?>;
    </script>
    <script>
        
        let locale = <?= json_encode(require APP_PATH . 'includes/daterangepicker_translations.php') ?>;
        let availableDays = {
            <?php foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day): ?>
            '<?= $day ?>': <?= json_encode(array_map(function($item) { return $item->time_start; }, $data->link->settings->{$day})) ?>,
            <?php endforeach; ?>
        };
        
        
        
        $('[data-daterangepicker]').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            startDate: new Date(),
            weekStart: 1,
            endDate: '+<?= $data->link->settings->max_days ?>d',
            minDate: new Date(),
            beforeShowDay: function(date) {
                var dayOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'][date.getDay()];
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                if(availableDays[dayOfWeek].length > 0)
                return true;
                else
                return false;
            }
            }).on('changeDate', function(e) {
            updateAvailableTimes(e.date);
        });
        
        
        
        function updateAvailableTimes(date) {
            var dayOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'][date.getDay()];
            var nextDay = new Date(date);
            nextDay.setDate(nextDay.getDate() + 1); 
            var dateString = nextDay.toISOString().split('T')[0];
            var bookingTimeSelect = $('#booking_time');
            bookingTimeSelect.empty();
            bookingTimeSelect.prop('disabled', false);
            
            var availableSlots = availableDays[dayOfWeek].filter(function(slot) {
                var isBooked = bookedSlots.some(function(bookedSlot) {
                    var bookedStartTime = bookedSlot.booking_time.substring(0, 5);
                    var slotIsBooked = bookedSlot.date === dateString && bookedStartTime === slot;
                    return slotIsBooked;
                });
                
                return !isBooked;
            });
            availableSlots.forEach(function(slot) {
                bookingTimeSelect.append(new Option(slot, slot));
            });           
        }
        
        
        
        function showSuccessNotification(message) {
            var bookingResponse = document.getElementById('booking_response_message');
            bookingResponse.classList.remove('d-none');
            bookingResponse.textContent = message;
            setTimeout(function () {
                bookingResponse.classList.add('d-none');
                bookingResponse.textContent = '';
            }, 5000);
        }
        
        document.getElementById('booking_form').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            document.getElementById('loading_icon').style.display = 'inline-block';
            document.getElementById('booking_response_message').classList.add('d-none');
            document.getElementById('booking_response_message').textContent = '';
            
            fetch('/source/php/booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Парсим JSON
            .then(data => {
                document.getElementById('loading_icon').style.display = 'none';
                document.getElementById('booking_response_message').classList.remove('d-none');
                document.getElementById('booking_response_message').textContent = data.message;
                showSuccessNotification('<?= $data->link->settings->successful_appointment ?>');
                var biolinkBlockId = data.biolinkBlockId;
                var name = data.name;
                var phone = data.phone;
                var email = data.email;
                var service = data.service;
                var bookingDate = data.bookingDate;
                var bookingTime = data.bookingTime;
                
                $.ajax({
                    type: 'POST',
                    url: `${site_url}l/link/tmappointments`,
                    data: {
                        biolinkBlockId: biolinkBlockId,
                        name: name,
                        phone: phone,
                        email: email,
                        service: service,
                        bookingDate: bookingDate,
                        bookingTime: bookingTime
                    },
                    success: function(response) {
                        
                    },
                    error: function(error) {
                        console.error('Ошибка:', error);
                    }
                })
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</div>                    