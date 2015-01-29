<?php
class SidebarWidget extends CWidget {

    public function run() {
		$Admin = Admin::model()->findByPk(Yii::app()->session['AdminID']);
        $this->render('SidebarWidget', array(
            'admins'=>$Admin   
        ));
    }
}
?>