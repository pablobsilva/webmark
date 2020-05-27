<?php
class Session
{
	public function flash(array $data = array())
	{
		foreach ($data as $key => $value) {
			$_SESSION['khaus']['variables'][$key]['lifetime'] = 2;
			$_SESSION['khaus']['variables'][$key]['value'] = $value;
		}
	}

	public function bootstrap()
	{
		if (isset($_SESSION['khaus'])) {
			if (isset($_SESSION['khaus']['variables'])) {
				foreach ($_SESSION['khaus']['variables'] as $key => $value) {
					$lifetime = $value['lifetime'] - 1;
					$_SESSION['khaus']['variables'][$key]['lifetime'] = $lifetime;
					if ($lifetime == 0) {
						unset($_SESSION['khaus']['variables'][$key]);
					}
				}
			}
		}
	}
}