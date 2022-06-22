<!-- begin #content -->
<div id="content" class="content">
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header"><?php echo $this->lang->line('alumni'); ?> <small><?php echo $this->lang->line('alumni_page'); ?></small></h1>
        </div>
    </div>
<form action=""></form>
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif;?>
                <?php if ($this->session->flashdata('warning')): ?>
                    <div class="alert alert-warning fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?php echo $this->session->flashdata('warning'); ?>
                    </div>
                <?php endif;?>
                <div class="panel-body">
                    <table id="data-table-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th class="text-nowrap"><?php echo $this->lang->line('name'); ?></th>
                                <th class="text-nowrap"><?php echo $this->lang->line('batch'); ?></th>
                                <th class="text-nowrap"><?php echo $this->lang->line('email'); ?></th>
                                <th class="text-nowrap"><?php echo $this->lang->line('mobile'); ?></th>
                                <th class="text-nowrap"><?php echo $this->lang->line('status'); ?></th>
                               <!--  <th class="text-nowrap"><?php echo $this->lang->line('blood_group'); ?></th> -->
                                <th class="text-nowrap"><?php echo $this->lang->line('added_on'); ?></th>
                                <th class="text-nowrap"><?php echo $this->lang->line('documents'); ?>Documents</th>
                                <!-- <th class="text-nowrap">
                                    <img src=".<?php echo $row['documents']; ?>" class="gimg" alt="">
                                </th> -->

                                <th class="text-nowrap"><?php echo $this->lang->line('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$count = 1;
$this->db->order_by('timestamp', 'desc');
$alumni_info = $this->security->xss_clean($this->db->get('alumnus')->result_array());
foreach ($alumni_info as $row):
?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['batch']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['mobile_number']; ?></td>
                                    <td>
                                        <?php if ($row['status'] == 0): ?>
                                            <span class="badge badge-warning"><?php echo $this->lang->line('pending'); ?></span>
                                        <?php elseif ($row['status'] == 1): ?>
                                            <span class="badge badge-success"><?php echo $this->lang->line('active'); ?></span>
                                        <?php elseif ($row['status'] == 2): ?>
                                            <span class="badge badge-inverse"><?php echo $this->lang->line('cancelled'); ?></span>
                                        <?php endif;?>
                                    </td>

                                    <!--<td><?php echo $row['blood_group']; ?></td>-->
                                    <td><?php echo date('d M, Y', $row['timestamp']); ?></td>


                                    <td> <img src="<?php echo base_url('blog/'.$row->documents) ?>" height="50px" width="50px" > </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-white btn-xs">Action</button>
                                            <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/bopup/modal_show_alumnus/<?php echo $row['alumnus_id']; ?>');">
                                                    <?php echo $this->lang->line('details'); ?>
                                                </a>
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/bopup/modal_edit_alumnus/<?php echo $row['alumnus_id']; ?>');">
                                                    <?php echo $this->lang->line('edit'); ?>
                                                </a>
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/bopup/modal_change_alumnus_image/<?php echo $row['alumnus_id']; ?>');">
                                                    <?php echo $this->lang->line('change_image'); ?>
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:;" onclick="confirm_modal('<?php echo base_url(); ?>admin/alumni/delete/<?php echo $row['alumnus_id']; ?>');">
                                                    <?php echo $this->lang->line('remove'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->