<section class="title">
	<h4><?php echo lang('pyroroutes.custom_routes'); ?></h4>
</section>

<section class="item">

<?php if (!empty($routes)): ?>

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
			<td><strong><?php echo $route->name; ?></strong></td>
			<td><?php echo $route->route_key; ?></td>
			<td><?php echo $route->route_value; ?></td>
			<td class="actions"> 
				<a href="<?php echo site_url('admin/routes/edit_route/'.$route->id);?>" class="button edit">Edit</a>
				<a href="<?php echo site_url('admin/routes/delete_route/'.$route->id);?>" class="confirm button delete">Delete</a>
			</td> 
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<div class="no_data"><?php echo lang('pyroroutes.no_routes');?></div>
<?php endif;?>

</section>