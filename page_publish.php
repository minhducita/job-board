<?php
	$job = new Job($id);
	
	$isNewPost = $job->mIsTemp;
//	$postRequiresModeration = !$job->IsApprovedPosterEmail() && ENABLE_NEW_POST_MODERATION;
	$postRequiresModeration = true;

	if ($isNewPost)
		$job->Publish();


	// facebook feed start ------------------

/*

	require('facebook/facebook.php');

	$facebook = new Facebook(array(
		'appId'  => '158074594262625',
		'secret' => '6f0f01822845cc6534f110eca0330bb7',
		'cookie' => true,
	));

	// メモった管理者のアクセストークン
	$user_token = '158074594262625|uB3Xinq5YJPu2UurVFfo9dT28vw';
	$user_token = 'AAACPxJwJZCmEBABLklROKOnD5Yzwh4bjrRIVwLhJ56QY5qJvOxTTacPKxtkbBXB7CK2zaYf3i39ObFC1gUtzbEWYbytyRczOx4QDgiQZDZD';

	// ファンページID
	$pagesId = '257122891001724';

	$facebook->getLoginUrl(array(
		'scope'=>"publish_stream,offline_access,user_status,read_stream,email",
	));

	// ログイン
	$pagesData = $facebook->api('/me/accounts','GET',array('access_token'=>$user_token));
	foreach($pagesData['data'] as $data ){
		if ($data['id'] == $pagesId) {
			$oshimaPages_token = $data['access_token'];
			break 1;
		}
	}

	//以下が投稿する内容。ここをカスタマイズすることでうまく自動化できるといい
	$status = '
JobBoard has a new job offer!! お仕事掲示板に新しい求人が投稿されました。 [ '.$job->mTitle.' ]
  http://japanworkingholiday.org/jobboard/job/'.$job->mId.'
';
	$attachment = array(
		'message'=>$status,
		'name'=>'JobBoard by JAWHM',
		'access_token'=>$oshimaPages_token,
	);

//	$statusUpdate = $facebook->api("/$pagesId/feed", 'post', $attachment);

*/
	// facebook feed end ------------------



	$postMan = new Postman();
	
	$jobInfo = $job->GetInfo();
	$jobInfo['isNewPost'] = $isNewPost;
	$jobInfo['postRequiresModeration'] = $postRequiresModeration;
	
	$postMan->MailPublishToAdmin($jobInfo);
//	if ($postRequiresModeration)
//	{
		if ($isNewPost)
			$postMan->MailPublishPendingToUser($job->mPosterEmail);
		
		$html_title = $translations['jobs']['add_success'];
//	}
//	else
//	{
//		if (!$job->mIsActive)
//			$job->Activate();
//		
//		if ($isNewPost)
//			$postMan->MailPublishToUser($jobInfo);
//		
//		$html_title = $translations['jobs']['publish_success'];
//	}
	
	if($html_title == '')
		$html_title = 'Publish';
	
	$smarty->assign('postRequiresModeration', $postRequiresModeration);
	
	redirect_to($baseUrl.'confirm/' . $job->mId . '/' . ($postRequiresModeration ? 1: 0) . '/');
	exit;
