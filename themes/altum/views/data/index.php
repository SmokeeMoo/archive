<?php defined('ALTUMCODE') || die() ?>


<section class="container">
    <?= \Altum\Alerts::output_alerts() ?>
    <div class="row mb-4">
        <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0">
            
            <h1 class="h4 m-0"><i class="fas fa-fw fa-xs fa-calendar-check mr-1"></i> <?= l('booking.header') ?></h1>
            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('booking.subheader') ?>">
                    <i class="fas fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>
        <?php
            try {
                $pdo = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $user_id = $this->user->user_id;
                session_start();
                $_SESSION['user_id'] = $this->user->user_id;
                $current_page = $_GET['page'] ?? 1;
                $records_per_page = 25;
                
                $offset = ($current_page - 1) * $records_per_page;
                
                $stmt = $pdo->prepare("SELECT * FROM booking WHERE user_id = :user_id ORDER BY booking_date DESC, booking_time ASC LIMIT :limit OFFSET :offset");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                
                $bookings = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                $total_records_stmt = $pdo->prepare("SELECT COUNT(*) FROM booking WHERE user_id = :user_id");
                $total_records_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $total_records_stmt->execute();
                $total_records = $total_records_stmt->fetchColumn();
                $total_pages = ceil($total_records / $records_per_page);
                $starting_record = ($current_page - 1) * $records_per_page + 1;
                $ending_record = min($starting_record + $records_per_page - 1, $total_records);
                
            if(count($bookings) > 0): ?>
            <table class="table" id="bookingsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><?= l('tmappointment_dataform.name') ?></th>
                        <th><?= l('tmappointment_dataform.email') ?></th>
                        <th><?= l('tmappointment_dataform.phone') ?></th>
                        <th><?= l('tmappointment_dataform.date') ?></th>
                        <th><?= l('tmappointment_dataform.time') ?></th>
                        <th><?= l('tmappointment_dataform.service') ?></th>
                        <th><?= l('tmappointment_dataform.approved') ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $booking): ?>
                    <?php echo '<tr data-booking-id="' . $booking->booking_id . '">'; ?>
                    <td><?= $booking->booking_id ?></td>
                    <td><?= $booking->name ?></td>
                    <td><?= $booking->email ?></td>
                    <td><?= $booking->phone ?></td>
                    <td><?= $booking->booking_date ?></td>
                    <td><?= date('H:i', strtotime($booking->booking_time)) ?></td>
					<td><?= $booking->service ?></td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="approved_<?= $booking->booking_id ?>" <?= $booking->approved ? 'checked' : '' ?> onchange="toggleApproved(<?= $booking->booking_id ?>)">
                            <label class="custom-control-label" for="approved_<?= $booking->booking_id ?>"></label>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $booking->booking_id ?>)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="col-12 mb-3">
            <button type="button" class="btn btn-danger" onclick="confirmMassDelete()"><?= l('tmappointment_dataform.deleteall') ?></button>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="#" onclick="loadPage(<?= $i ?>); return false;"><?= $i ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php echo "<div style=\"width: 100%;\"><p class='showing-info'> " . l('tmappointment_dataform_pagination.showing') . " " . $starting_record . "-" . $ending_record . " " . l('tmappointment_dataform_pagination.out_of') . " " . $total_records . " " . l('tmappointment_dataform_pagination.results') . "</p></div>"; ?>
        <?php else: ?>
        <p><?= l('tmappointment_dataform.no_bookings') ?></p>
        <?php endif;
            
            } catch(PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    ?>
    
    <script>
        function toggleApproved(bookingId) {
            let isChecked = document.getElementById('approved_' + bookingId).checked ? 1 : 0;
            
            fetch('/source/php/toggle_approved.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'booking_id=' + bookingId + '&approved=' + isChecked
            })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    </script>
    
    
    <?php 
        $tmappointment_dataform_name = l('tmappointment_dataform.name');
        $tmappointment_dataform_email = l('tmappointment_dataform.email');
        $tmappointment_dataform_phone = l('tmappointment_dataform.phone');
        $tmappointment_dataform_date = l('tmappointment_dataform.date');
        $tmappointment_dataform_time = l('tmappointment_dataform.time');
        $tmappointment_dataform_service = l('tmappointment_dataform.service');
        $tmappointment_dataform_approved = l('tmappointment_dataform.approved');
    ?>
    <script>
        function loadPage(page) {
            const tmappointment_dataform_name = "<?php echo urlencode($tmappointment_dataform_name); ?>";
            const tmappointment_dataform_email = "<?php echo urlencode($tmappointment_dataform_email); ?>";
            const tmappointment_dataform_phone = "<?php echo urlencode($tmappointment_dataform_phone); ?>";
            const tmappointment_dataform_date = "<?php echo urlencode($tmappointment_dataform_date); ?>";
            const tmappointment_dataform_time = "<?php echo urlencode($tmappointment_dataform_time); ?>";
            const tmappointment_dataform_service = "<?php echo urlencode($tmappointment_dataform_service); ?>";
            const tmappointment_dataform_approved = "<?php echo urlencode($tmappointment_dataform_approved); ?>";
            
            const url = `/source/php/display_bookings.php?page=${page}&tmappointment_dataform_name=${tmappointment_dataform_name}&tmappointment_dataform_email=${tmappointment_dataform_email}&tmappointment_dataform_phone=${tmappointment_dataform_phone}&tmappointment_dataform_date=${tmappointment_dataform_date}&tmappointment_dataform_time=${tmappointment_dataform_time}&tmappointment_dataform_service=${tmappointment_dataform_service}&tmappointment_dataform_approved=${tmappointment_dataform_approved}`;
            
            
            fetch(url)
            .then(response => response.text())
            .then(data => {
                const result = document.createElement('div');
                result.innerHTML = data;
                
                const table = result.querySelector('#bookingsTable');
                const pagination = result.querySelector('.pagination');
                const showingInfo = result.querySelector('.showing-info');
                
                if (table && pagination && showingInfo) {
                    document.getElementById('bookingsTable').innerHTML = table.innerHTML;
                    document.querySelector('.pagination').innerHTML = pagination.innerHTML;
                    document.querySelector('.showing-info').innerHTML = showingInfo.innerHTML;
                    } else {
                    console.error('One or more elements are missing in the response.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    <script>
        function confirmDelete(bookingId) {
            document.getElementById('deleteBookingId').value = bookingId;
            document.getElementById('massDeleteFlag').value = "0";
            document.getElementById('deleteMessage').textContent = "<?= l('delete_modal.subheader2') ?>";
            $('#deleteModal').modal('show');
        }
        
        function confirmMassDelete() {
            document.getElementById('deleteBookingId').value = "";
            document.getElementById('massDeleteFlag').value = "1";
            document.getElementById('deleteMessage').textContent = "<?= l('tmappointment_modal_delete_all') ?>";
            $('#deleteModal').modal('show');
        }
        
        function deleteBooking() {
            var bookingId = document.getElementById('deleteBookingId').value;
            var isMassDelete = document.getElementById('massDeleteFlag').value === "1";
            
            var url = isMassDelete ? '/source/php/delete_unapproved_bookings.php' : '/source/php/delete_booking.php';
            var postData = isMassDelete ? '' : 'booking_id=' + bookingId;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: postData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    if(isMassDelete) {
                        location.reload();
                        } else {
                        document.querySelector('tr[data-booking-id="' + bookingId + '"]').remove();
                    }
                    $('#deleteModal').modal('hide');
                    } else {
                    console.error('Error:', data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    </script>
    
    <script>
        function deleteUnapprovedBookings() {
            if(confirm('Are you sure you want to delete all the disapproved bookings?')) {
                fetch('/source/php/delete_unapproved_bookings.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        alert('All disapproved bookings have been deleted.');
                        location.reload();
                        } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        }
    </script>
</section>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="deleteModalLabel"><?= l('global.delete') ?></h5>
                <p class="text-muted" id="deleteMessage"><?= l('delete_modal.subheader2') ?></p>
                <input type="hidden" id="deleteBookingId">
                <input type="hidden" id="massDeleteFlag" value="0">
                <div class="mt-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= l('global.cancel') ?></button>
                    <button type="button" class="btn btn-danger" onclick="deleteBooking()"><?= l('global.delete') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<section class="container">
    <?= \Altum\Alerts::output_alerts() ?>
    
    <div class="row mb-4">
        <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0 text-truncate">
            <h1 class="h4 m-0 text-truncate"><i class="fas fa-fw fa-xs fa-database mr-1"></i> <?= l('data.header') ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('data.subheader') ?>">
                    <i class="fas fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <div class="col-12 col-lg-auto d-flex">
            <div class="">
                <div class="dropdown">
                    <button type="button" class="btn btn-light dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" data-tooltip title="<?= l('global.export') ?>">
                        <i class="fas fa-fw fa-sm fa-download"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a href="<?= url('data?' . $data->filters->get_get() . '&export=csv')  ?>" target="_blank" class="dropdown-item">
                            <i class="fas fa-fw fa-sm fa-file-csv mr-2"></i> <?= sprintf(l('global.export_to'), 'CSV') ?>
                        </a>
                        <a href="<?= url('data?' . $data->filters->get_get() . '&export=json') ?>" target="_blank" class="dropdown-item">
                            <i class="fas fa-fw fa-sm fa-file-code mr-2"></i> <?= sprintf(l('global.export_to'), 'JSON') ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="ml-3">
                <div class="dropdown">
                    <button type="button" class="btn <?= $data->filters->has_applied_filters ? 'btn-dark' : 'btn-light' ?> filters-button dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" data-tooltip title="<?= l('global.filters.header') ?>">
                        <i class="fas fa-fw fa-sm fa-filter"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right filters-dropdown">
                        <div class="dropdown-header d-flex justify-content-between">
                            <span class="h6 m-0"><?= l('global.filters.header') ?></span>

                            <?php if($data->filters->has_applied_filters): ?>
                                <a href="<?= url('data') ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
                            <?php endif ?>
                        </div>

                        <div class="dropdown-divider"></div>

                        <form action="" method="get" role="form">
                            <div class="form-group px-4">
                                <label for="type" class="small">
                                    <?= l('global.type') ?>
                                </label>
                                <select name="type" id="type" class="custom-select custom-select-sm">
                                    <option value=""><?= l('global.all') ?></option>
                                    <?php foreach(['email_collector', 'phone_collector'] as $value): ?>
                                        <option value="<?= $value ?>" <?= isset($data->filters->filters['type']) && $data->filters->filters['type'] == $value ? 'selected="selected"' : null ?>><?= l('link.biolink.blocks.' . $value) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <div class="d-flex justify-content-between">
                                    <label for="filters_project_id" class="small"><?= l('projects.project_id') ?></label>
                                    <a href="<?= url('projects') ?>" target="_blank" class="small mb-2"><i class="fas fa-fw fa-sm fa-plus mr-1"></i> <?= l('global.create') ?></a>
                                </div>
                                <select name="project_id" id="filters_project_id" class="custom-select custom-select-sm">
                                    <option value=""><?= l('global.all') ?></option>
                                    <?php foreach($data->projects as $row): ?>
                                        <option value="<?= $row->project_id ?>" <?= isset($data->filters->filters['project_id']) && $data->filters->filters['project_id'] == $row->project_id ? 'selected="selected"' : null ?>><?= $row->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                                <select name="order_by" id="filters_order_by" class="custom-select custom-select-sm">
                                    <option value="datetime" <?= $data->filters->order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_type" class="small"><?= l('global.filters.order_type') ?></label>
                                <select name="order_type" id="filters_order_type" class="custom-select custom-select-sm">
                                    <option value="ASC" <?= $data->filters->order_type == 'ASC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_asc') ?></option>
                                    <option value="DESC" <?= $data->filters->order_type == 'DESC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_desc') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_results_per_page" class="small"><?= l('global.filters.results_per_page') ?></label>
                                <select name="results_per_page" id="filters_results_per_page" class="custom-select custom-select-sm">
                                    <?php foreach($data->filters->allowed_results_per_page as $key): ?>
                                        <option value="<?= $key ?>" <?= $data->filters->results_per_page == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4 mt-4">
                                <button type="submit" name="submit" class="btn btn-sm btn-primary btn-block"><?= l('global.submit') ?></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(count($data->data)): ?>

        <?php foreach($data->data as $row): ?>
            <div class="custom-row mb-4">
                <div class="row">
                    <div class="col-4 col-lg-3 d-flex align-items-center">
                        <div class="d-flex flex-column small">
                            <?php foreach($row->data as $key => $value): ?>
                                <div><span class="font-weight-bold"><?= $key ?>:</span> <?= $value ?></div>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <div class="col-2 col-lg-2 d-flex align-items-center">
                        <a href="<?= url('link/' . $row->link_id . '?tab=blocks') ?>" class="mr-2" data-toggle="tooltip" title="<?= l('data.biolink') ?>">
                            <?= l('link.biolink.blocks.' . $row->type) ?>
                        </a>
                    </div>

                    <div class="col-4 col-lg-3 d-flex flex-column flex-lg-row align-items-center">
                        <?php if($row->project_id && isset($data->projects[$row->project_id])): ?>
                            <a href="<?= url('data?project_id=' . $row->project_id) ?>" class="text-decoration-none" data-toggle="tooltip" title="<?= l('projects.project_id') ?>">
                                <span class="badge badge-light" style="color: <?= $data->projects[$row->project_id]->color ?> !important;">
                                    <?= $data->projects[$row->project_id]->name ?>
                                </span>
                            </a>
                        <?php endif ?>
                    </div>

                    <div class="col-2 col-lg-2 d-none d-lg-flex justify-content-center justify-content-lg-end align-items-center">
                        <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>') ?>">
                            <i class="fas fa-fw fa-calendar text-muted"></i>
                        </span>
                    </div>

                    <div class="col-2 col-lg-2 d-flex justify-content-center justify-content-lg-end align-items-center">
                        <div class="dropdown">
                            <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
                                <i class="fas fa-fw fa-ellipsis-v"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" data-toggle="modal" data-target="#datum_delete_modal" data-datum-id="<?= $row->datum_id ?>" class="dropdown-item"><i class="fas fa-fw fa-sm fa-trash-alt mr-2"></i> <?= l('global.delete') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

        <div class="mt-3"><?= $data->pagination ?></div>

    <?php else: ?>
        <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
            'filters_get' => $data->filters->get ?? [],
            'name' => 'data',
            'has_secondary_text' => false,
        ]); ?>
				  
			  
		  
    <?php endif ?>

</section>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'datum',
    'resource_id' => 'datum_id',
    'has_dynamic_resource_name' => false,
    'path' => 'data/delete'
]), 'modals'); ?>
