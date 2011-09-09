<?php if($method == 'new'): ?>
	<h3><?php echo lang('pyroroutes.new_route');?></h3>
<?php else: ?>
	<h3><?php echo lang('pyroroutes.edit_route');?></h3>
<?php endif; ?>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<ul>

	<li>
		<label for="name"><?php echo lang('pyroroutes.route_name');?></label>
		<?php echo form_input('name', set_value('name', $route->name), 'maxlength="100"'); ?>
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		<div class="clear-both text-small1" style="margin-left: 160px;"><?php echo lang('pyroroutes.instr.route_name');?></div>
	</li>

	<li class="even">
		<label for="route_key"><?php echo lang('pyroroutes.route_key');?></label>
		<?php echo form_input('route_key', set_value('route_key', $route->route_key), 'maxlength="200"'); ?>
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		<div class="clear-both text-small1" style="margin-left: 160px;"><?php echo lang('pyroroutes.instr.route_key');?></div>
	</li>

	<li>
		<label for="route_key"><?php echo lang('pyroroutes.route_value');?></label>
		<?php echo form_input('route_value', set_value('route_value', $route->route_value), 'maxlength="200"'); ?>
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		<div class="clear-both text-small1" style="margin-left: 160px;"><?php echo lang('pyroroutes.instr.route_value');?></div>
	</li>

</ul>

<div class="float-right buttons">

	<button type="submit" name="btnAction" value="save" class="button"><span><?php echo lang('buttons.save'); ?></span></button>	
	
	<a href="<?php echo site_url('admin/routes'); ?>" class="button cancel"><?php echo lang('buttons.cancel'); ?></a>	
</div><!--.float-right-->

</form>