<?php
	$j = new Job($_POST['job_id']);
$data = $j->GetInfo();

	$vali = new Postman();
	$vali->MailPostActivatedToUser($data, BASE_URL_ORIG);
	echo 1;
	exit;
