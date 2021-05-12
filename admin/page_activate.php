<?php
	$j = new Job($_POST['job_id']);
	$activator = $j->Activate();
	$data = $j->GetInfo();
$data['ACTIVE_EMAIL_MESSAGE'] = 'ご投稿頂きましたお仕事情報の掲載が開始されましたのでご連絡申し上げます。';
 sleep ( 2 );

	$vali = new Postman();
	$vali->MailPostActivatedToUser($data, BASE_URL_ORIG);
	echo 1;
	exit;
?>