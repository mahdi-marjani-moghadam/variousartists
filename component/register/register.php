<?php


global $admin_info,$PARAM;


if($PARAM[0]  == 'register')
{

    if($_POST){
        $result = $login->register($_POST);
        if($result['result'] == -1)
        {
            $login->showRegisterForm($result['msg']);

        }
        else
        {
            global $messageStack;
            $messageStack->add_session('login',$result['msg'],'success');
            redirectPage(RELA_DIR.'login',$result['msg']);
        }
    }

    $login->showRegisterForm();


}
elseif($PARAM[1]  == 'memberregister')
{
    // don't use

    if($_POST){
        $result = $login->memberregister($_POST);
        if($result['result'] == -1)
        {
            $login->showLoginForm($result['msg']);

        }
        else
        {
            global $messageStack;
            $messageStack->add_session('login',$result['msg'],'success');
            redirectPage(RELA_DIR.'login',$result['msg']);
        }
    }
    $login->showLoginForm();


}

die();
