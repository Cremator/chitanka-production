<?php
if (in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
	apc_clear_cache();
	apc_clear_cache('user');
	apc_clear_cache('opcode');
	echo '1';
} else {
	die('boo');
}
