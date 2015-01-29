<div class="pageheader">
	<h2><i class="fa fa-home"></i> System Admin/Editor</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <?php if(Yii::app()->session['UserTypeID']==1): ?>
            	<li class="active"><a href="<?php echo $this->createUrl("webend/admin"); ?>" title="">System Admin/Editor</a></li>
            <?php else: ?>
            	<li class="active"><a href="<?php echo $this->createUrl("webend/admin"); ?>" title="">System Admin/Editor</a></li>
            <?php endif; ?>
        </ol>
	</div>
</div>
<div class="contentpanel" style="padding-bottom:0px;">
<input type="button" value="Add New System Admin/Editor" class="btn btn-info" style="float:right" onclick="document.location.href='<?php echo $this->createUrl("webend/admins"); ?>'">  
</div>
<div class="contentpanel">
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin Type</th>
                            <th>Last Login Date</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php for($i=0;$i<count($data);$i++):?>
                        <tr>
                            <td><?php echo $data[$i]['adminid']; ?></td>
                            <td><?php echo $data[$i]['firstname']." ".$data[$i]['lastname']; ?></td>
                            <td><?php echo $data[$i]['email']; ?></td>
                            <td><?php echo $data[$i]['UserType']; ?></td>
                            <td><?php if($data[$i]['lastlogindate']!="0000-00-00 00:00:00"): echo date("d M,Y h:i A",strtotime($data[$i]['lastlogindate'])); endif; ?></td>
                            <td><?php 
								if(trim($data[$i]['profilepicture'])!='' && file_exists(YiiBase::getPathOfAlias('webroot')."/assets/users/admin/".$data[$i]['profilepicture'])):
									Yii::import('ext.iwi.Iwi');
									$picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/users/admin/".$data[$i]['profilepicture']);
									$picture->resize(40,0, Iwi::NONE);
								?>
									<img src="<?php echo $picture->cache(); ?>" alt="" />
								<?php else: ?>
								  <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/photos/loggeduser.png" class="media-object" height="40">
								<?php endif; ?>
                			</td>
                            <td><?php if($data[$i]['status']==1): echo "Active"; else: echo "Inactive"; endif; ?></td>
                            <td class="table-action">
                              	<a href="<?php echo $this->createUrl("webend/admins/AdminID/".$data[$i]['adminid']); ?>"><i class="fa fa-pencil"></i></a>
                                <?php if($data[$i]['adminid']!=Yii::app()->session['AdminID']): ?>
                            	<a href="<?php echo $this->createUrl("webend/deleteAdmin/AdminID/".$data[$i]['adminid']); ?>" onclick="if(!confirm('Delete It?')){return false;}" class="delete-row"><i class="fa fa-trash-o"></i></a>
                                <?php endif; ?>
                            </td>
                            
                        </tr>
                      <?php endfor; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>