<!-- begin #content -->
<div id="content" class="content">
	<div class="row">
		<div class="col-md-6">
			<h1 class="page-header"><?php echo $this->lang->line('settings'); ?> <small><?php echo $this->lang->line('webiste_settings'); ?></small></h1>
		</div>
	</div>

	<!-- begin row -->
	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<?php if ($this->session->flashdata('success')) : ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<?php echo $this->session->flashdata('success'); ?>
					</div>
				<?php endif; ?>
				<div class="panel-body">
					<?php echo form_open('admin/website_settings/update', array('data-parsley-validate' => 'true', 'name' => 'update_text')); ?>
					<div class="form-group">
						<label><?php echo $this->lang->line('website_title'); ?></label>
						<input value="<?php echo $this->db->get_where('setting', array('setting_id' => 1))->row()->content; ?>" class="form-control" type="text" name="frontend_title" placeholder="<?php echo $this->lang->line('ph_website_title'); ?>" data-parsley-required="true" />
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('admin_title'); ?></label>
						<input value="<?php echo $this->db->get_where('setting', array('setting_id' => 2))->row()->content; ?>" class="form-control" type="text" name="backend_title" placeholder="<?php echo $this->lang->line('ph_admin_title'); ?>" data-parsley-required="true" />
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('copyright_name'); ?></label>
						<input value="<?php echo $this->db->get_where('setting', array('setting_id' => 3))->row()->content; ?>" class="form-control" type="text" name="copyright" placeholder="<?php echo $this->lang->line('ph_copyright_name'); ?>" data-parsley-required="true" />
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('copyright_url'); ?></label>
						<input value="<?php echo $this->db->get_where('setting', array('setting_id' => 9))->row()->content; ?>" class="form-control" type="text" name="copyright_url" placeholder="<?php echo $this->lang->line('ph_copyright_url'); ?>" data-parsley-required="true" />
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('call_us'); ?></label>
						<input value="<?php echo $this->db->get_where('setting', array('setting_id' => 4))->row()->content; ?>" class="form-control" type="text" name="call_us" placeholder="<?php echo $this->lang->line('ph_call_us'); ?>" data-parsley-required="true" />
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('website_language'); ?></label>
						<select class="combobox" name="language">
							<option value=""><?php echo $this->lang->line('select_language'); ?></option>
							<option <?php if ($this->db->get_where('setting', array('setting_id' => 10))->row()->content == 'english') echo 'selected'; ?> value="english">English</option>
							<option <?php if ($this->db->get_where('setting', array('setting_id' => 10))->row()->content == 'french') echo 'selected'; ?> value="french">French</option>
							<option <?php if ($this->db->get_where('setting', array('setting_id' => 10))->row()->content == 'german') echo 'selected'; ?> value="german">German</option>
						</select>
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('currency'); ?></label>
						<select class="combobox" name="currency">
							<option value=""><?php echo $this->lang->line('select_currency'); ?></option>
							<?php
							$currencies = $this->db->get('currency')->result_array();
							foreach ($currencies as $currency) :
							?>
								<option <?php if ($this->db->get_where('setting', array('setting_id' => 11))->row()->content == $currency['code']) echo 'selected'; ?> value="<?php echo html_escape($currency['code']); ?>"><?php echo html_escape($currency['name']); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label><?php echo $this->lang->line('timezone'); ?></label>
						<select class="combobox" name="timezone">
							<option value=""><?php echo $this->lang->line('select_timezone'); ?></option>
							<?php
							$timezones =  DateTimeZone::listIdentifiers(DateTimeZone::ALL);
							foreach ($timezones as $timezone) :
							?>
								<option <?php if ($this->db->get_where('setting', array('setting_id' => 12))->row()->content == $timezone) echo 'selected'; ?> value="<?php echo html_escape($timezone); ?>"><?php echo html_escape($timezone); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<button type="submit" class="md-sm btn btn-success"><?php echo $this->lang->line('update'); ?></button>
					<?php echo form_close(); ?>
				</div>
			</div>
			<!-- end panel -->

			<!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php echo form_open('admin/website_settings/update_smtp', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('smtp_email'); ?></label>
                        <input value="<?php echo html_escape($this->db->get_where('setting', array('name' => 'smtp_user'))->row()->content); ?>" type="text" name="smtp_user" placeholder="Enter SMTP Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('smtp_password'); ?></label>
                        <input value="<?php echo html_escape($this->db->get_where('setting', array('name' => 'smtp_pass'))->row()->content); ?>" type="password" name="smtp_pass" placeholder="Enter SMTP Password" class="form-control">
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span><?php echo $this->lang->line('smtp_note'); ?>: <a href="https://myaccount.google.com/apppasswords"><?php echo $this->lang->line('smtp_link'); ?></a></span>
                    </div>

                    <button type="submit" class="mb-sm btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                    <?php echo form_close(); ?>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
		</div>
	</div>
	<!-- end row -->
</div>
<!-- end #content