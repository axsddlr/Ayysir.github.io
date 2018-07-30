<?php
/**
 * instagram api test script
 */

$client_id = 'CLIENT ID';
$client_secret = 'CLIENT SECRET';
$redirect_uri = 'REDIRECT URI';

if ($_GET['action'] == 'auth')
{
    $auth_uri = sprintf('https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code', $client_id, $redirect_uri);
    header(sprintf('Location: %s', $auth_uri));
    exit;
}
elseif ($_GET['action'] == 'return' && !empty($_GET['code']))
{
    $url = 'https://api.instagram.com/oauth/access_token';
    $params = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $redirect_uri,
        'code' => $_GET['code'],
    );

    $options = array('http' => array(
        'method' => 'POST',
        'content' => http_build_query($params),
    ));

    // get access_token
    $step1_json = json_decode(file_get_contents($url, false, stream_context_create($options)));

    // get photos
    $step2_request = sprintf('https://api.instagram.com/v1/users/self/media/recent?access_token=%s', $step1_json->{'access_token'});
    $step2_json = json_decode(file_get_contents($step2_request));

    echo sprintf('<img src="%s" /><br />', $step1_json->{'user'}->{'profile_picture'});
    echo sprintf('%s<hr />', $step1_json->{'user'}->{'username'});
    foreach ($step2_json->{'data'} as $item)
    {
        $image_url = $item->{'images'}->{'thumbnail'}->{'url'};
        $image_width = $item->{'images'}->{'thumbnail'}->{'width'};
        $image_height = $item->{'images'}->{'thumbnail'}->{'height'};
        $image_link =  $item->{'images'}->{'standard_resolution'}->{'url'}; // original size
        
        echo sprintf('<a href="%s" target="_blank"><img src="%s" width="%s" height="%s" /></a><br />', $image_link, $image_url, $image_width, $image_height);
    }
}
else
{
    echo '<a href="index.php?action=auth">show your instagram</a>';
}
