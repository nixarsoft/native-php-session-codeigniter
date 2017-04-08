<?

class session {
	public function userdata( $str ) {
		return $_SESSION[$str];
	}

	public function set_userdata( $key, $val ) {
		$_SESSION[$key] = $val;
	}

	public function sess_destroy() {
		session_destroy();
	}
}

