<div class="pageheader">
	<h2><i class="fa fa-home"></i> Languages</h2>
    <div class="breadcrumb-wrapper">
    	<span class="label">You are here:</span>
        <ol class="breadcrumb">
        	<li><a href="<?php echo $this->createUrl("webend/dashboard"); ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo $this->createUrl("webend/language"); ?>" title="">Languages</a></li>
        </ol>
	</div>
</div>
<div class="contentpanel" style="padding-bottom:0px;">
<input type="button" value="Add New Language" class="btn btn-info" style="float:right" onclick="document.location.href='<?php echo $this->createUrl("webend/languages"); ?>'">  
</div>
<input type="hidden" id="AJAXURL" value="<?php echo $this->createUrl("webend/defaultLanguages"); ?>" />
<div class="contentpanel">
	<div class="panel panel-default">
    	<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hidaction table-hover mb30" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Is Default Language</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($rsData as $Data):?>
                        <tr>
                            <td><?php echo $Data->languageid; ?></td>
                            <td><?php echo $Data->language; ?></td>
                            <td>
                            	<input type="radio" name="IsDefault" class="IsDefault" value="<?php echo $Data->languageid; ?>" <?php if($Data->isdefault==1): ?>checked="checked" <?php endif; ?> />
                            </td>
                             <td><?php if($Data->status==1): echo "Active"; else: echo "Inactive"; endif; ?></td>
                            <td class="table-action">
                            	<a href="<?php echo $this->createUrl("webend/languages/LanguageID/".$Data->languageid); ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="<?php echo $this->createUrl("webend/languageText/LanguageID/".$Data->languageid); ?>" title="Edit Translation"><i class="fa fa-exchange"></i></a>
                                <a href="<?php echo $this->createUrl("webend/deleteLanguages/LanguageID/".$Data->languageid); ?>" title="Delete" onclick="if(!confirm('Delete It?')){return false;}" class="delete-row"><i class="fa fa-trash-o"></i></a>
                           </td>
                            
                        </tr>
                      <?php endforeach; ?>
        			</tbody>
				</table>
			</div>
		</div>
	</div>
</div>