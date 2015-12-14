<?php
	$meta_datas = is_array(get_option('more_meta_fields'))? get_option('more_meta_fields'):array();

	$page = get_post_type( get_the_ID() );
	$meta_boxes = array();
	foreach ($meta_datas as $key => $value) {
		if( in_array( $page,$meta_datas[$key]['post_type'] ) )  $meta_boxes[] = $key;

	}
	$meta_boxes[] = "Add New";

?>
<div class="modal fade" id="addMoreFieldsModal" tabindex="-1" role="dialog" aria-labelledby="addMoreFieldsModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header  btn-primary">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add More fields</h4>
      </div>
      <div class="modal-body">
        		<div class="addmorefield-error alert alert-warning hidden"></div>
        		<form name="add-meta" id="uc-meta-form" action="" method = "post" class="form-horizontal">

        			<fieldset class="text-center">

		        		<?php
		   //      			$args = array(
				 //    		'public'   => true,
				 //    		'_builtin' => false
					// );
					// $output = 'names';
					// $operator = 'and';

					//$post_types = get_post_types( $args, $output, $operator );

						?>

					 <input type="hidden" name="page" value="<?=$page?>" />

					<div class="form-group">
						<label class="col-md-3 control-label" for="meta-box">Meta box name:</label>
						 <div class="col-md-5">
							<select name="metabox-dropdown" class="metabox-dropdown form-control" type="text">
								<option value="">Select Meta Box</option>
								<?php foreach ($meta_boxes as $key => $value) { ?>
									<option value="<?=$value?>"><?=ucfirst( $value )?></option>
								<?php }?>
							</select>
							<input type="hidden" class="meta-box form-control" name="meta-box" value="" />

						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="meta-field-title">Field Title:</label>
						 <div class="col-md-5">
							<input type="text" name="meta-field-title" value="" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="meta-field-key">Custom field Key:</label>
						 <div class="col-md-5">
							<input  class="form-control" type="text" name="meta-field-key" value="" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="meta-field-desc">Description:</label>
						 <div class="col-md-5">
							<textarea class="form-control" name="meta-field-desc" ></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="type">Custom field Type:</label>
						 <div class="col-md-5">
							<select name="type" class="form-control">
							<?php
								$support_types = array("text", "radio","textarea","yesno","select","checkbox","image","file","wysiwyg","date","time", "datetime","color","hidden",);
								foreach ($support_types  as $support_type ) {
									echo "<option value='$support_type'>".ucfirst($support_type)."</option>";
								}
							?>


							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="type">Options ( If applicable ):</label>
						 <div class="col-md-5">
							<input type="text" name="options" value=""  class="form-control" /> please enter values by coma seperated
						</div>

					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="type">&nbsp;</label>
						 <div class="col-md-5" style="text-align:right;">
							<input type="submit" id="uc-add-meta-box"  style="" class="btn btn-warning" value="Add">
						</div>

					</div>

				</legend>
			</fieldset>


		</form>

		<h2>Custom field lists :</h2>
		<hr />
		<div class="panel-group" id="accordion">
			<?php

				foreach ($meta_datas as $key => $value) {
					$post_types = @implode(',', $meta_datas[$key]['post_type']);

					if( $post_types != $page ) continue;
					
			?>
					<div class="panel panel-default">
					    	<div class="panel-heading">
					      		<h4 class="panel-title">
					        			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $value['index'];?>"><?php echo $value['label'];?></a>
						        		<input type='text' class="hidden" id="meta-<?php echo $value['index']; ?>"  name='meta-box' value="<?php echo $value['label']; ?>" />
						        		<button type="submit" class="btn btn-warning btn-sm editable-submit hidden" box-id="<?php echo $value['index']; ?>"><i class="glyphicon glyphicon-ok"></i></button>
						        		<button type="button" class="btn btn-warning btn-sm editable-cancel hidden" box-id="<?php echo $value['index']; ?>"><i class="glyphicon glyphicon-remove"></i></button>

						        		<!-- <i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i> -->
						        		<i class="edit-metabox   pull-right glyphicon glyphicon-pencil" box-id="<?php echo $value['index'];?>"></i>
						        		<i class="delete-metabox   pull-right glyphicon glyphicon-remove" box-id="<?php echo $value['index'];?>"></i>

						      	</h4>
						</div>
						<div id="collapse<?php echo $value['index'];?>" class="panel-collapse collapse">
      							<div class="panel-body">
      								<table width="100%" style="font-size:10px;">
									<tr class="btn-warning">
										<th>Label</th><th>Field Id</th><th>Field Desc</th><th>Type</th><th>Action</th>
									</tr>
									<?php
									$post_types = @implode(',', $meta_datas[$key]['post_type']);
									if( $post_types != $page ) continue;
									$row = 0;

									foreach ($meta_datas[$key]['fields']  as $key2 => $value2) {
										if($value2['name']){
											?>

												<?php
												if($row % 2 == 0){
													echo "<tr id='".$value['index']."_".$value2['name']."'>";
												}else{
													echo "<tr id='".$value['index']."_".$value2['name']."' class='even'>";
												}

												 echo "<td><span class='text'>".$value2['label']."</span><input type='text' class= 'hidden' name='meta-field-title' value='".$value2['label']."' /></td>";
												echo "<td><span  class='text'>".$value2['name']."</span><input type='text'  class= 'hidden'  name='meta-field-key' value='".$value2['name']."'/></td>";
												echo "<td><span  class='text'>".$value2['description']."</span><input type='text'   class= 'hidden'  name='meta-field-desc' value='".$value2['description']."'/></td>";
												echo "<td><span  class='text'>".$value2['type']."</span>";
												?>
												<select name="type" class="hidden" type="text">
													<?php foreach ($support_types as $key => $support_type) { ?>
														<option value="<?=$support_type?>"  <?php if($support_type == $value2['type'])echo "selected=selected";?>><?=ucfirst( $support_type )?></option>
													<?php }?>
												</select>
												</td><td>
												<button type="submit" class="btn btn-warning btn-sm field-submit hidden" meta-key="<?php echo $value2['name'];?>" meta-box="<?php echo $value['index'];?>" ><i class="glyphicon glyphicon-ok"></i></button>
						        						<button type="button" class="btn btn-warning btn-sm field-cancel hidden" meta-key="<?php echo $value2['name'];?>" meta-box="<?php echo  $value['index'];?>"><i class="glyphicon glyphicon-remove"></i></button>
												<?php
												echo '<a href="#" class="edit-field"  meta-key="'.$value2['name'].'" meta-box="'.$value['index'].'"><i class="glyphicon glyphicon-pencil"></i></a><a class="delete-field" href="#" meta-key="'.$value2['name'].'" meta-box="'.$value['index'].'"><i class="glyphicon glyphicon-remove"></i></a></td>';
												echo "</tr>";

										$row++;
										}

									}
									?>
								</table>
							</div>
    						</div>
					</div>
				<?php
				}
				?>
		<!-- </table> -->
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
