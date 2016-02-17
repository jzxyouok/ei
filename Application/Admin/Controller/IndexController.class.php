<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller {
	public function index() {
		if (C ( 'NEEDLOGIN' ) == 1) {
			if (! isset ( $_SESSION [C ( 'USER_AUTH_KEY' )] )) {
				$this->redirect ( "Public/login" );
			} elseif (in_array ( $_SESSION ['username'], C ( 'ADMIN_AUTH_KEY' ) )) {
				$this->display ( 'adminindex' );
			} else {
				//
				$this->display ('adminindex' );
			}
		} else {
			$this->display ( 'adminindex' );
		}
	}
}