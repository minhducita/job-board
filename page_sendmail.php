<?php 
$emails = Job::GetPostDateend();
$postMan = new Postman();
$ids = $postMan->MailPostDateEnd($emails);

if(!empty($ids))
{
    $job->UpdatePostDateEnd($ids);
}