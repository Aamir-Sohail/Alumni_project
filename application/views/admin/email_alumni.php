<!-- begin #content -->
<div id="content" class="content">
    <h1 class="page-header"><?php echo $this->lang->line('alumni'); ?> <small><?php echo $this->lang->line('email_alumni_page'); ?></small></h1>

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-lg-6 offset-lg-3">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-body">
					<?php echo form_open('admin/alumni/email', array('data-parsley-validate' => 'true', 'name' => 'email_alumni')); ?>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('subject'); ?></label>
                            <input class="form-control" type="text" name="subject" placeholder="<?php echo $this->lang->line('ph_alumni_email_subject'); ?>" data-parsley-required="true" />
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('message'); ?></label>
                            <textarea style="resize: none" class="form-control" rows="5" type="text" name="message" placeholder="<?php echo $this->lang->line('ph_alumni_email_body'); ?>" data-parsley-required="true"></textarea>
                        </div>

                        <button type="submit" class="mb-sm btn btn-success"><?php echo $this->lang->line('send'); ?></button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <!-- end panel -->
        </div>
    </div>
    <!-- end row -->

    <hr>

    <h1 class="page-header"><?php echo $this->lang->line('alumni'); ?> <small><?php echo $this->lang->line('email_alumni_page_class_wise'); ?></small></h1>

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-lg-6 offset-lg-3">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-body">
					<?php echo form_open('admin/alumni/email_to_class', array('data-parsley-validate' => 'true', 'name' => 'email_alumni')); ?>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('class'); ?></label>
                            <select class="combobox" name="batch">
                                <option value=""><?php echo $this->lang->line('select_class'); ?></option>
                                <?php for ($start_year = date('Y'); $start_year >= 1900; $start_year--) : ?>
                                    <option value="<?php echo $start_year; ?>"><?php echo $start_year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('subject'); ?></label>
                            <input class="form-control" type="text" name="subject" placeholder="<?php echo $this->lang->line('ph_alumni_email_subject'); ?>" data-parsley-required="true" />
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('message'); ?></label>
                            <textarea style="resize: none" class="form-control" rows="5" type="text" name="message" placeholder="<?php echo $this->lang->line('ph_alumni_email_body'); ?>" data-parsley-required="true"></textarea>
                        </div>

                        <button type="submit" class="mb-sm btn btn-success"><?php echo $this->lang->line('send'); ?></button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <!-- end panel -->
        </div>
    </div>
    <!-- end row -->
</div>
<!-- end #content
