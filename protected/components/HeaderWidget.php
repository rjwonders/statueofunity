<?php
class HeaderWidget extends CWidget {

    public function run() {
		$Admin = Admin::model()->findByPk(Yii::app()->session['AdminID']);
        $this->render('HeaderWidget', array(
            'admins'=>$Admin   
        ));
    }
}
?>