<tr class='form_list' id='tr_<?php echo $files[file_id]?>' >
	<td>
		<a href="<?php echo (PATH . $files[path])?>" class="highslide" onclick="return hs.expand(this)">
			<img src="<?php echo (PATH . $files[path_small])?>" alt="<?php echo ($files[file_nam])?>"
				title="Нажми для увеличения" />
		</a>
	</td>
	<td>
		<?php echo ($files[file_nam])?>
	</td>
	<td>
		<?php echo ($files[type])?>
	</td>
	<td>
		<?php echo ($files[size])?>
	</td>
	<td>
	</td>
</tr>

