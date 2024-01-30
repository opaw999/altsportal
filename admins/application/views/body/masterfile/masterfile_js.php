<script src="<?php echo base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Scroller/js/dataTables.scroller.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-sweetalert/sweetalert2.all.min.js'); ?>"></script>
<script src=" <?php echo base_url('assets/plugins/bootstrap-sweetalert/polyfill.min.js'); ?>"></script>
<script>
    $(document).ready(function() {

    });

    function searchMasterfile(str) {
        $('input[name="emp_id"],input[name="record_no"]').val('')
        $('div.masterfileData').html('');
        $('div.schedules').html('');
        $('div.searchContainer').removeClass('border-right');
        var server = $('select[name="server"]').val();
        if (server.trim() != '') {
            if (str.trim() != '') {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('masterfile'); ?>",
                    data: {
                        str,
                        server
                    },
                    success: function(data) {
                        $('.dropdown-list').show()
                        $('.dropdown-list').html(data);
                    }
                });
            } else {
                $('.dropdown-list').hide()
            }
        } else {
            Swal({
                title: 'Warning!',
                text: 'Please select a Server!',
                type: 'warning',
                allowOutsideClick: false
            })
            $('input[name="masterfile"]').val('')
            $('select[name="server"]').css("border-color", "#dd4b39");
            $('select[name="server"]').on("focus", function() {
                $(this).css("border-color", "");
            });
        }
    }

    function searchDtr(str) {
        $('input[name="emp_id"],input[name="record_no"]').val('')
        $('div.masterfileData').html('');
        $('div.dtrCutoff').html('');
        $('div.searchContainer').removeClass('border-right');
        var server = $('select[name="server"]').val();
        if (server.trim() != '') {
            if (str.trim() != '') {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('dtrSearch'); ?>",
                    data: {
                        str,
                        server
                    },
                    success: function(data) {
                        $('.dropdown-list').show()
                        $('.dropdown-list').html(data);
                    }
                });
            } else {
                $('.dropdown-list').hide()
            }
        } else {
            Swal({
                title: 'Warning!',
                text: 'Please select a Server!',
                type: 'warning',
                allowOutsideClick: false
            })
            $('input[name="dtr"]').val('')
            $('select[name="server"]').css("border-color", "#dd4b39");
            $('select[name="server"]').on("focus", function() {
                $(this).css("border-color", "");
            });
        }
    }

    function setServer(server) {
        $('div.searchContainer').removeClass('border-right');
        $('input[name="emp_id"],input[name="record_no"]').val('')
        $('div.masterfileData').html('');
        $('div.dtrCutoff,div.schedules').html('');
        $('input[name="dtr"],input[name="masterfile"]').val('')
        $('.dropdown-list').hide()
    }

    function selectDtr(value) {
        var server = $('select[name="server"]').val();
        var [name, emp_id, record_no, statCut] = value.split('*');
        $('input[name="dtr"]').val(name)
        $('input[name="emp_id"]').val(emp_id)
        $('input[name="record_no"]').val(record_no)
        $('input[name="statCut"]').val(statCut)
        $('.dropdown-list').hide()
        $.ajax({
            type: "POST",
            url: "<?= site_url('masterfileData'); ?>",
            data: {
                emp_id,
                record_no,
                server
            },
            beforeSend: function() {
                loader_circle('masterfileData')
            },
            success: function(data) {
                $('div.masterfileData').html(data);
                $('div.searchContainer').addClass('border-right');
                getDtrCutoff(emp_id, record_no, statCut, server)
            }
        });
    }

    function getDtrCutoff(emp_id, record_no, statCut, server) {
        console.log(emp_id, record_no, statCut)
        $.ajax({
            type: "POST",
            url: "<?= site_url('dtrCutoff'); ?>",
            data: {
                emp_id,
                record_no,
                statCut,
                server
            },
            beforeSend: function() {
                loader_circle('dtrCutoff')
            },
            success: function(data) {
                $('div.dtrCutoff').html(data);
                $("#dtrCutoffs").dataTable({
                    "order": [
                        [0, 'desc']
                    ]
                });
            }
        });
    }

    function empDTR2(empId, recordNo, dateFrom, dateTo, statCut, i, server) {

        $('div#promoDtr').modal({
            backdrop: 'static',
            keyboard: false,
        });
        $("div#promoDtr").modal("show");
        $.ajax({
            type: "POST",
            url: "<?= site_url('cutoff'); ?>",
            data: {
                dateFrom,
                dateTo,
            },
            success: function(data) {
                $('span.cutoff').html(data);

            }
        });
        $.ajax({
            type: "POST",
            url: "<?= site_url('promoDtr'); ?>",
            data: {
                empId,
                recordNo,
                dateFrom,
                dateTo,
                statCut,
                i,
                server
            },
            beforeSend: function() {
                loader_circle('promoDtr')
            },
            success: function(data) {
                $('div.promoDtr').html(data);
                $('#dt_dtrEntry').DataTable({
                    "destroy": true,
                    "searching": false,
                    "info": false,
                    "ordering": false,
                    "paging": false,
                    // "scrollY": '40vh',
                    // "scrollCollapse": true,
                });
                $('th.d').css('width', '10%');
            },


        });
    }

    function viewTime(server, empId, dateRendered) {


        $('div#show_entry').modal({
            backdrop: 'static',
            keyboard: false,
        });

        $("#show_entry").modal("show");

        $.ajax({
            type: "POST",
            url: "<?= site_url('vTEntry'); ?>",
            data: {
                server,
                empId,
                dateRendered
            },
            beforeSend: function() {
                loader_circle('show_entry')
            },
            success: function(data) {

                $("div.show_entry").html(data);
            }
        });
    }

    function selectMasterfile(value) {
        var server = $('select[name="server"]').val();
        var [name, emp_id, record_no] = value.split('*');
        $('input[name="masterfile"]').val(name)
        $('input[name="emp_id"]').val(emp_id)
        $('input[name="record_no"]').val(record_no)
        $('.dropdown-list').hide()
        $.ajax({
            type: "POST",
            url: "<?= site_url('masterfileData'); ?>",
            data: {
                emp_id,
                record_no,
                server
            },
            beforeSend: function() {
                loader_circle('masterfileData')
            },
            success: function(data) {
                $('div.masterfileData').html(data);
                $('div.searchContainer').addClass('border-right');
                getSchedules(emp_id, server)
            }
        });
    }

    function getSchedules(emp_id, server) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('multSched'); ?>",
            data: {
                emp_id,
                server
            },
            beforeSend: function() {
                loader_circle('schedules')
            },
            success: function(data) {
                $('div.schedules').html(data);
                $('#multScheds').DataTable({
                    "ordering": false,
                    "pagingType": "simple",
                    "pagingControl": true
                });
            }
        });
    }

    function shiftSched(emp_id) {
        var server = $('select[name="server"]').val();
        console.log(emp_id)
        $('div#shiftSched').modal({
            backdrop: 'static',
            keyboard: false,
        });
        $("div#shiftSched").modal("show");
        $.ajax({
            type: "POST",
            url: "<?= site_url('promoDefSched'); ?>",
            data: {
                emp_id,
                server
            },
            beforeSend: function() {
                loader_circle('shiftSched')
            },
            success: function(data) {
                $('div.shiftSched').html(data);
                $('#promoDefSched').DataTable({
                    "ordering": false,
                    "pageLength": 7,
                    "lengthMenu": [7],
                    initComplete: function(settings, json) {
                        $('th.d').css('width', '5%');
                        $('th.sc').css('width', '10%');
                        $('th.ts').css('width', '35%');
                        $('th.s1').css('width', '25%');
                        $('th.s2').css('width', '25%');
                    }
                });
            }
        });
    }

    function viewSched(emp_id, promo_type, month, year) {
        $('div#viewSched').modal({
            backdrop: 'static',
            keyboard: false,
        });
        $("div#viewSched").modal("show");
        var record_no = $('input[name="record_no"]').val();
        $.ajax({
            type: "POST",
            url: "<?= site_url('viewSched'); ?>",
            data: {
                emp_id,
                record_no,
                promo_type,
                month,
                year
            },
            beforeSend: function() {
                loader_circle('viewSched')
            },
            success: function(data) {
                $('div.viewSched').html(data);
                view_sched(emp_id, record_no, promo_type, month, year);
            }
        });
    }

    function view_sched(emp_id, record_no, promo_type, month, year) {
        var server = $('select[name="server"]').val();
        $.ajax({
            type: "POST",
            url: "<?= site_url('viewSchedPromo'); ?>",
            data: {
                emp_id,
                record_no,
                promo_type,
                month,
                year,
                server
            },
            beforeSend: function() {
                loader_circle('viewSchedPromo')
            },
            success: function(data) {
                $('div.viewSchedPromo').html(data);
                $('#dt_schedule').DataTable({

                    "destroy": true,
                    "autoWidth": true,
                    "searching": false,
                    "info": false,
                    "ordering": false,
                    "paging": false,
                    "scrollY": '45vh',
                    "scrollCollapse": true
                });
            }
        });
    }

    function view_sched2(month, year, datas) {
        var server = $('select[name="server"]').val();
        var [emp_id, record_no, promo_type] = datas.split('*');
        console.log(month, year)
        $.ajax({
            type: "POST",
            url: "<?= site_url('viewSched'); ?>",
            data: {
                emp_id,
                record_no,
                promo_type,
                month,
                year,
                server
            },
            beforeSend: function() {
                loader_circle('viewSched')
            },
            success: function(data) {
                $('div.viewSched').html(data);
                view_sched(emp_id, record_no, promo_type, month, year);
            }
        });
    }

    function month_n(datas) {

        var m_ = $("select[name = 'month_']").val();
        var y_ = $("select[name = 'year_']").val();
        view_sched2(m_, y_, datas);
    }

    function year_n(datas) {

        var m_ = $("select[name = 'month_']").val();
        var y_ = $("select[name = 'year_']").val();
        view_sched2(m_, y_, datas);
    }

    function viewDayoff(emp_id, amsId) {
        var server = $('select[name="server"]').val();
        console.log(emp_id, amsId)
        $('div#dayoff').modal({
            backdrop: 'static',
            keyboard: false,
        });
        $("div#dayoff").modal("show");
        $.ajax({
            type: "POST",
            url: "<?= site_url('dayoff'); ?>",
            data: {
                emp_id,
                amsId,
                server
            },
            beforeSend: function() {
                loader_circle('dayoff')
            },
            success: function(data) {
                $('div.dayoff').html(data);

            }
        });
    }

    function loader_circle(page) {
        $('div.' + page).html(
            '<div style="text-align: center;">' +
            '<img src="<?= base_url('assets/img/gif/loader_seq.gif') ?>">' +
            '</div>'
        );
    }

    function alertRequired(message) {
        Swal.fire({
            title: 'Required!',
            text: message,
            icon: 'warning',
            iconColor: '#fd3550',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#0d6efd',
            customClass: 'required_alert'
        });
    }
</script>