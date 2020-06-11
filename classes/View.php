<?php
class View
{
	public $view;

	private $path;
	private $file;
	private $template;
	private $variables;
	public function __construct()
	{
		$this->path = '../views/';
		$this->variables = array();
		if (isset($_SESSION['khaus']['variables'])) {
			foreach ($_SESSION['khaus']['variables'] as $key => $value) {
				$this->variables['khaus'][$key] = $value['value'];
			}
		}
	}

	public function __get($variable)
	{
		if (isset($this->variables[$variable])) {
			return $this->variables[$variable];
		}
	}

	public function make($file)
	{
		$this->file = $file;
		return $this;
	}

	public function with(array $variables = array())
	{
		foreach ($variables as $key => $value) {
			$this->variables[$key] = $value;
		}
		return $this;
	}

	private function loadFunctions()
	{
		if (!function_exists('url')) {
			function url($url = null) {
				return Helper::url($url);
			}
		}
		if (!function_exists('segment')) {
			function segment($posicion) {
				$solicitud = Helper::getURL()->solicitud;
				$solicitud = explode('/', $solicitud);
				return isset($solicitud[$posicion - 1]) ? $solicitud[$posicion - 1] : null;
			}
		}
	}

	private function returnTemplate($file)
	{
		$file = str_replace('.', '/', $file);
		$this->loadFunctions();
		ob_start();
        include $this->path . $file . '.php';
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
	}

	public function render()
	{
		$this->template = $this->returnTemplate($this->file);
		return $this->blade($this->template);
	}

	private function blade($template)
	{
		$parentFile = $this->hasParent($template);
		if ($parentFile) {
			$this->template = str_replace("@extends('$parentFile')", '', $this->template);
			$parentTemplate = $this->returnTemplate($parentFile);
			$template = str_replace("@section('content')", $this->template, $parentTemplate);
		}
		return $template;
	}

	private function hasParent($template)
	{
		preg_match_all('/\@extends\(\'([a-z0-9.]+)\'\)/i', $template, $matches);
		return isset($matches[1][0]) ? $matches[1][0] : false;
	}
}