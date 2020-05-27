<?php
class Helper
{
	public static function getURL()
	{
		$protocolo = isset($_SERVER['REQUEST_SCHEME']) ? strtolower($_SERVER['REQUEST_SCHEME']) : 'http';
		$nombre = $_SERVER['SERVER_NAME'];
		$base = dirname($_SERVER['SCRIPT_NAME']);
		if (substr($base, -1) != '/') {
			$base .= '/';
		}
		$baseFull = sprintf('%s://%s%s', $protocolo, $nombre, $base);
		$solicitud = str_replace($base, '', $_SERVER['REQUEST_URI']);
		$solicitud = $solicitud{0} == '/' ? substr($solicitud, 1) : $solicitud;
		return (object) array(
			'completa' => sprintf('%s://%s/%s', $protocolo, $nombre, $solicitud),
			'base' => $baseFull,
			'protocolo' => $protocolo,
			'nombre' => $nombre,
			'solicitud' => $solicitud,
		);
	}

	public static function redirect($location)
	{
		$location = $location{0} == '/' ? substr($location, 1) : $location;
		header('location: ' . self::getURL()->base . $location);
	}

	public static function url($location = null)
	{
		if (is_null($location)) {
			return self::getURL()->base;
		} else {
			$location = $location{0} == '/' ? substr($location, 1) : $location;
			return self::getURL()->base . $location;
		}
	}
}