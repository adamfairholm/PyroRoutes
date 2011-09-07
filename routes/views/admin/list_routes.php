<h3><?php echo lang('pyroroutes.custom_routes'); ?></h3>

<?php if (!empty($routes)): ?>

<ul class="table_actions">
	<li><?php echo anchor('admin/streams/streams/new', lang('streams.add_stream')); ?></li>
</ul>

    <table class="table-list">
		<thead>
			<tr>
			    <th><?php echo lang('pyroroutes.route_name');?></th>
			    <th><?php echo lang('pyroroutes.route_key');?></th>
			    <th><?php echo lang('pyroroutes.route_value');?></th>
			    <th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($routes as $route):?>
			<tr>
				<td><?php echo $route->name; ?></td>
				<td><?php echo $route->route_key; ?></td>
				<td><?php echo $route->route_value; ?></td>
				<td>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<section class="box"> 
    <p><?php echo lang('pyroroutes.no_routes');?> <?php echo anchor('admin/routes/new_route', lang('pyroroutes.here')); ?>.</p>
    </div>
<?php endif;?>