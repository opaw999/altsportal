<link href="<?php echo base_url('assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/plugins/DataTables/extensions/Scroller/css/scroller.bootstrap.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet" />
<style>
    ul.list-group a:hover {
        background-color: #008cff;
        color: #fff;
    }

    .searchContainer {
        position: relative;
        display: inline-block;
    }



    .masterfile {
        position: absolute;
        z-index: 999;
        max-height: 150px;
        width: 100%;
        overflow-y: auto;
    }

    .font_size {
        font-size: 80%;
    }

    .font_size3 {
        font-size: 90%;
    }

    .font_size2 {
        font-size: 75%;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <!-- <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Masterfile</a></li>
    </ol> -->
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <!-- <h1 class="page-header">Masterfile</h1> -->
    <!-- end page-header -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Masterfile</h4>
                </div>
                <input type="hidden" name="emp_id">
                <input type="hidden" name="record_no">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 searchContainer">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">
                                        <i class="fa fa-server" aria-hidden="true"></i>
                                    </label>
                                </div>
                                <select name="server" class="custom-select" id="inputGroupSelect01" onchange="setServer(this.value)">
                                    <option value="">Select Server</option>
                                    <option value="tagbilaran">Tagbilaran Server</option>
                                    <option value="talibon">Talibon Server</option>
                                    <option value="tubigon">Tubigon Server</option>
                                    <option value="cebu">Cebu Server</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="masterfile" placeholder="Search Name/EmployeeID here..." autocomplete="off" onkeyup="searchMasterfile(this.value, this.name)" aria-describedby="basic-addon1">
                            </div>

                            <div class="dropdown-list masterfile"></div>
                            <div class="row">
                                <div class="col-md-12 masterfileData"></div>
                            </div>
                        </div>
                        <div class="col-md-8 schedules"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="dayoff">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assigned Day Off/No Duty</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body dayoff">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="viewSched">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body viewSched">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="shiftSched">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Default Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body shiftSched">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>