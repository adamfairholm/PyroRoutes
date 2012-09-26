<section class="title">
<?php if($method == 'new'): ?>
	<h4><?php echo lang('pyroroutes.new_route');?></h4>
<?php else: ?>
	<h4><?php echo lang('pyroroutes.edit_route');?></h4>
<?php endif; ?>
</section>

<section class="item">

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="form_inputs">

<ul>

	<li>
		<label for="name">
			<?php echo lang('pyroroutes.route_name');?> <span>*</span>
			<small><?php echo lang('pyroroutes.instr.route_name');?></small>
		</label>
		<div class="input"><?php echo form_input('name', set_value('name', $route->name), 'maxlength="100"'); ?></div>
	</li>

	<li class="even">
		<label for="route_key">
			<?php echo lang('pyroroutes.route_key');?> <span>*</span>
			<small><?php echo lang('pyroroutes.instr.route_key');?></small>
		</label>
		<div class="input"><?php echo form_input('route_key', set_value('route_key', $route->route_key), 'maxlength="200"'); ?></div>
	</li>

	<li>
		<label for="route_key">
			<?php echo lang('pyroroutes.route_value');?> <span>*</span>
			<small><?php echo lang('pyroroutes.instr.route_value');?></small>
		</label>
		<div class="input"><?php echo form_input('route_value', set_value('route_value', $route->route_value), 'maxlength="200"'); ?></div>
	</li>

</ul>

</div><!--.form_inputs-->

<div class="float-right buttons">

	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	
</div><!--.float-right-->

</form>

</section>