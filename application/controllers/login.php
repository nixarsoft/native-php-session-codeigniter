<?

class login extends CI_Controller {

  public function index() {

    $fb = new Facebook\Facebook([
      'app_id' => FB_APP_ID,
      'app_secret' => FB_APP_SECRET,
      'default_graph_version' => 'v2.2',
    ]);

    $helper = $fb->getCanvasHelper();

    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (! isset($accessToken)) {
      $helper = $fb->getRedirectLoginHelper();

      $permissions = ['email',"publish_actions"]; // Optional permissions
      $loginUrl = $helper->getLoginUrl('https://www.nixarsoft.com/fb/ExtendedTools/login/fbcb', $permissions);

      //header("Location: " . $loginUrl);
      echo '<script> top.location.href="'. $loginUrl .'"; </script>';
      exit;
    }
  }

  public function fbcb() {
    $fb = new Facebook\Facebook([
      'app_id' => FB_APP_ID,
      'app_secret' => FB_APP_SECRET,
      'default_graph_version' => 'v2.2',
    ]);


    $helper = $fb->getRedirectLoginHelper();

    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (! isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }

    // Logged in
    $this->session->set_userdata( "login", "1" );

    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    // Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId(FB_APP_ID); // Replace {app-id} with your app id
    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();

    if (! $accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
      }
    }

    $this->session->set_userdata("fb_access_token", (string) $accessToken);

    // User is logged in with a long-lived access token.
    // You can redirect them to a members-only page.
    header('Location: ' . site_url());
  }
}
