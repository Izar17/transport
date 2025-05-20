<?php
// Determine filter type and value
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'month';
$month = isset($_GET['month']) ? $_GET['month'] : date("Y-m");
$week = isset($_GET['week']) ? $_GET['week'] : '';
$day = isset($_GET['day']) ? $_GET['day'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<div class="content py-3">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Transfer Sales Report</h5>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="callout callout-primary shadow rounded-0">
                    <form action="" id="filter">
                        <div class="row align-items-end">
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="filter_type" class="control-label">Filter By</label>
                                    <select name="filter_type" id="filter_type" class="form-control rounded-0">
                                        <option value="month" <?= $filter_type == 'month' ? 'selected' : '' ?>>Month</option>
                                        <option value="week" <?= $filter_type == 'week' ? 'selected' : '' ?>>Week</option>
                                        <option value="day" <?= $filter_type == 'day' ? 'selected' : '' ?>>Day</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12 filter-input filter-month" style="<?= $filter_type == 'month' ? '' : 'display:none;' ?>">
                                <div class="form-group">
                                    <label for="month" class="control-label">Month</label>
                                    <input type="month" name="month" id="month" value="<?= $month ?>" class="form-control rounded-0" <?= $filter_type == 'month' ? 'required' : '' ?>>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12 filter-input filter-week" style="<?= $filter_type == 'week' ? '' : 'display:none;' ?>">
                                <div class="form-group">
                                    <label for="week" class="control-label">Week</label>
                                    <input type="week" name="week" id="week" value="<?= $week ?>" class="form-control rounded-0" <?= $filter_type == 'week' ? 'required' : '' ?>>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12 filter-input filter-day" style="<?= $filter_type == 'day' ? '' : 'display:none;' ?>">
                                <div class="form-group">
                                    <label for="day" class="control-label">Day</label>
                                    <input type="date" name="day" id="day" value="<?= $day ?>" class="form-control rounded-0" <?= $filter_type == 'day' ? 'required' : '' ?>>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="status" class="control-label">Status</label>
                                    <select name="status" id="status" class="form-control rounded-0">
                                        <option value="">All</option>
                                        <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Unpaid</option>
                                        <option value="1" <?= $status === '1' ? 'selected' : '' ?>>FOC</option>
                                        <option value="2" <?= $status === '2' ? 'selected' : '' ?>>Paid</option>
                                        <option value="3" <?= $status === '3' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-flat btn-sm"><i class="fa fa-filter"></i> Filter</button>
                                    <button class="btn btn-light border btn-flat btn-sm" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clear-fix mb-3"></div>
                    <div id="outprint">
                    <table class="table table-bordered table-stripped">
                        <colgroup>
                            <col width="3%">
                            <col width="12%">
                            <col width="20%">
                            <col width="20%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="">
                                <th class="text-center align-middle py-1">#</th>
                                <th class="text-center align-middle py-1">Date Created</th>
                                <th class="text-center align-middle py-1">Ref. Code</th>
                                <th class="text-center align-middle py-1">Transfer Type</th>
                                <th class="text-center align-middle py-1">Lead Pax</th>
                                <th class="text-center align-middle py-1">Status</th>
                                <th class="text-center align-middle py-1">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $total = 0;
                            // Build WHERE clause based on filter
                            $where = "";
                            if ($filter_type == 'month' && $month) {
                                $where_arr[] = "DATE_FORMAT(created_date, '%Y-%m') = '{$month}'";
                            } elseif ($filter_type == 'week' && $week) {
                                $parts = explode('-W', $week);
                                if (count($parts) == 2) {
                                    $year = $parts[0];
                                    $weeknum = $parts[1];
                                    $where_arr[] = "YEAR(created_date) = '{$year}' AND WEEK(created_date, 1) = '{$weeknum}'";
                                }
                            } elseif ($filter_type == 'day' && $day) {
                                $where_arr[] = "DATE(created_date) = '{$day}'";
                            }
                            if ($status !== '' && $status !== null) {
                                $where_arr[] = "status = '{$status}'";
                            }
                            if (count($where_arr) > 0) {
                                $where = "WHERE " . implode(" AND ", $where_arr);
                            }
                            $orders = $conn->query("SELECT created_date, reserve_num, transfer_type, CONCAT(last_name, ', ', first_name) as guest, status, total_price from booking $where order by unix_timestamp(created_date) desc ");
                            while($row = $orders->fetch_assoc()):
                                $total += $row['total_price'];
                            ?>
                                <tr>
                                    <td class="text-center align-middle px-2 py-1"><?php echo $i++; ?></td>
                                    <td class="align-middle px-2 py-1"><?php echo date("Y-m-d H:i",strtotime($row['created_date'])) ?></td>
                                    <td class="align-middle px-2 py-1"><?= $row['reserve_num'] ?></td>
                                    <td class="align-middle px-2 py-1">
                                        <?php 
                                            switch($row['transfer_type']){
                                                case 1:
                                                    echo 'ARRIVAL';
                                                    break;
                                                case 2:
                                                    echo 'DEPARTURE';
                                                    break;
                                                default:
                                                    echo 'ROUNDTRIP';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td class="align-middle px-2 py-1"><?php echo $row['guest'] ?></td>
                                    <td class="text-center align-middle px-2 py-1">
                                        <?php 
                                            switch($row['status']){
                                                case 0:
                                                    echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Unpaid</span>';
                                                    break;
                                                case 1:
                                                    echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">FOC</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">Paid</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="badge badge-secondary bg-gradient-secondary px-3 rounded-pill">Cancelled</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td class="text-right align-middle px-2 py-1"><?php echo format_num($row['total_price']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center px-1 py-1 align-middel" colspan="6">Total</th>
                                <th class="text-right px-1 py-1 align-middel"><?= format_num($total) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
<style>
    #sys_logo{
        width:5em !important;
        height:5em !important;
        object-fit:scale-down !important;
        object-position:center center !important;
    }
</style>
<div class="d-flex align-items-center">
    <div class="col-auto text-center pl-4">
        <img src="<?= validate_image($_settings->info('logo')) ?>" alt=" System Logo" id="sys_logo" class="img-circle border border-dark">
    </div>
    <div class="col-auto flex-shrink-1 flex-grow-1 px-4">
        <h4 class="text-center m-0"><?= $_settings->info('name') ?></h4>
        <h3 class="text-center m-0"><b>Order Report</b></h3>
        <h5 class="text-center m-0">For the 
            <?php
            if($filter_type == 'month') echo "Month of " . date("F Y", strtotime($month));
            elseif($filter_type == 'week') echo "Week #" . (isset($weeknum) ? $weeknum : '') . " of " . (isset($year) ? $year : '');
            elseif($filter_type == 'day') echo "Day of " . date("F d, Y", strtotime($day));
            ?>
        </h5>
    </div>
</div>
<hr>
</noscript>
<script>
    $(function(){
        // Show/hide filter inputs based on filter type
        $('#filter_type').change(function(){
            var type = $(this).val();
            $('.filter-input').hide();
            $('.filter-' + type).show();
            $('.filter-input input').prop('required', false);
            $('.filter-' + type + ' input').prop('required', true);
        }).trigger('change');

        $('#filter').submit(function(e){
            e.preventDefault()
            location.href = "./?page=reports/transfer_reports&"+$(this).serialize();
        })
        $('#print').click(function(){
            start_loader();
            var head = $('head').clone()
            var p = $('#outprint').clone()
            var el = $('<div>')
            var header =  $($('noscript#print-header').html()).clone()
            head.find('title').text("Transfer Montly Report - Print View")
            el.append(head)
            el.append(header)
            el.append(p)
            var nw = window.open("","_blank","width=1000,height=900,top=50,left=75")
                    nw.document.write(el.html())
                    nw.document.close()
                    setTimeout(() => {
                        nw.print()
                        setTimeout(() => {
                            nw.close()
                            end_loader()
                        }, 200);
                    }, 500);
        })
    })
</script>