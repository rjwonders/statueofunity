<div class="pageheader">
	<h2><i class="fa fa-tags"></i> Category</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/category"); ?>" title="">Project Categories</a></li>
        </ol>
	</div>
</div>
<div class="contentpanel" style="padding-bottom:0px;">
<input type="button" value="Add New Project Category" class="btn btn-info" style="float:right" onclick="document.location.href='<?php echo $this->createUrl("webend/categorys"); ?>'">  
</div>
<input type="hidden" id="AJAXURL" value="<?php echo $this->createUrl("webend/homeCategory"); ?>" />
<div class="contentpanel">
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Parent Category Name</th>
                            <th>Is Home Category</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php for($i=0;$i<count($data);$i++):?>
                        <tr>
                            <td><?php echo $data[$i]['categoryid']; ?></td>
                            <td><?php echo $data[$i]['category']; ?></td>
                            <td><?php echo $data[$i]['parentcategory']; ?></td>
                            <td>
                            	<input type="checkbox" name="IsHomeCategory[]" class="IsHomeCategory" value="<?php echo $data[$i]['categoryslug']; ?>" <?php if($data[$i]['ishomecategory']==1): ?>checked="checked" <?php endif; ?> />
                            </td>
                            <td><?php if($data[$i]['status']==1): echo "Active"; else: echo "Inactive"; endif; ?></td>
                            <td class="table-action">
                              	<a href="<?php echo $this->createUrl("webend/categorys/CategoryID/".$data[$i]['categoryslug']); ?>"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo $this->createUrl("webend/deleteCategory/CategoryID/".$data[$i]['categoryslug']); ?>" onclick="if(!confirm('Delete It?')){return false;}" class="delete-row"><i class="fa fa-trash-o"></i></a>
                           </td>
                            
                        </tr>
                      <?php endfor; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>