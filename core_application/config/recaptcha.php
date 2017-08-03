<?
/*
The reCaptcha server keys and API locations

Obtain your own keys from:
http://www.recaptcha.net
*/
$config['recaptcha'] = array(
  'public'=>'6LdmqN4SAAAAAGMtOfll7x402SJAqCd8G_5QML_1',
  'private'=>'6LdmqN4SAAAAABhBAXUU_batJOvJ_hZ_T5ZBhtVC',
  'RECAPTCHA_API_SERVER' =>'http://www.google.com/recaptcha/api',
  'RECAPTCHA_API_SECURE_SERVER'=>'https://www.google.com/recaptcha/api',
  'RECAPTCHA_VERIFY_SERVER' =>'www.google.com',
  'RECAPTCHA_SIGNUP_URL' => 'https://www.google.com/recaptcha/admin/create',
  'theme' => 'red'
);
