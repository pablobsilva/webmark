<?php

class Router {

    private $parametros;
    private $rutasRegistradas;
    private $requestMethod;

    public function __construct()
    {
        $this->parametros = array();
        $this->rutasRegistradas = array();
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->obtenerRuta();
    }


    private function obtenerRuta()
    {
        $script = dirname( $_SERVER['SCRIPT_NAME'] ) . '/';
        //$_SERVER[SCRIPT_NAME]: /index.php
		//$script = //
        $request = str_replace( $script, '', $_SERVER['REQUEST_URI'] );
        //$_SERVER[REQUEST_URI] = /auth/login
		//$request = /auth/login
        if ( isset( $_SERVER['QUERY_STRING'] ) ) {
            $query = sprintf( '?%s', $_SERVER['QUERY_STRING'] );
            //$_SERVER[QUERY_sTRING] = '';
			//$query = ?
            $request = str_ireplace( $query, '', $request );
            //$request = /auth/login
        }
        if ( isset( $request {0}) && $request {0}== '/' ) {
                // $request {0}= /;
                $request = substr( $request, 1 );
                //$request = auth/login
            }
            if ( $request == '/' ) {
                $request = array();
                //$request = /;
            } else {
                $request = explode( '/', $request );
                //$request = Array[0]=> auth[1]=>login
            }
            $this->parametros = $request;
    }

    public function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        //echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    public function get( $ruta, $controller )
    {
        $this->debug_to_console($this->parametros);
        //print( '<br>' );
       // print( '|ruta: '.$ruta.'|Controller: '. $controller );
        //ruta: auth/login
        //controller: AuthController@Login
        $get = implode( '/', $this->parametros );
        //parametris: [1]=> auth [2]=>login
        $get = urldecode( $get );
        //urlcode => auth/login
        if ( preg_match_all( '/\{([a-zA-Z0-9-_ ]+)\}/', $ruta, $matches ) ) {
            $regex = preg_quote( $ruta, '@' );
            print( 'Regex: ' . $regex );
            $regex = preg_replace( '/\\\{([a-zA-Z0-9-_.]+)\\\}/', '([a-zA-Z0-9-_. ]+)', $regex );
            $regex = '@' . $regex . '@';
            print( 'regex2: '. $regex );
            if ( preg_match_all( $regex, $get, $matches2 ) ) {
                $variables = array();
                foreach ( $matches[1] as $key => $value ) {
                    $ruta = str_replace( $matches[0][$key], '', $ruta );
                    $variables[$value] = isset( $matches2[$key + 1][0] ) ? $matches2[$key + 1][0] : null;
                }
                $ruta = preg_replace( '/\/+$/', '', $ruta );
                $this->parametros = explode( '/', $ruta );
                $this->rutasRegistradas['GET'][$ruta] = ( object ) array(
                    'controller' => $controller,
                    'variables' => $variables,
                );
            }
        } else {
            $this->rutasRegistradas['GET'][$ruta] = $controller;
           // print '<br>';
            //print_r( $this->rutasRegistradas );
            //$ruta: '';
            //$controller: HomeController@index;
            //rutasRegistras=> Array ( [GET] => Array ( [] => HomeController@index ) )
        }
    }

    public function post( $ruta, $controller )
    {
        $this->rutasRegistradas['POST'][$ruta] = $controller;
    }

    private function direccionar()
    {
        $ruta = implode( '/', $this->parametros );
        //$ruta = auth/login
        if ( isset( $this->rutasRegistradas[$this->requestMethod][$ruta] ) ) {
            //$this->rutasRegistradas[GET][auth/login )
            $router = $this->rutasRegistradas[$this->requestMethod][$ruta];
            //requestmethod: get
            //Router: AuthController@login
            if ( is_object( $router ) ) {
                return $this->controller( $router->controller, $router->variables );
            } else {
                return $this->controller( $router );
                //Router => AuthController@login
            }
        } else {
            header( 'HTTP/1.1 404 Not FoundASDASDASDSA' );
            include( '../public/404.html' );
        }
    }

    private function controller( $controller, array $variables = array() )
    {
        list( $class, $method ) = explode( '@', $controller );
        //$controller: AuthController@login
        require_once '../controllers/' . $class . '.php';
        $element = new $class;
        //$class = AuthController;
        //$element = AuthController;
        require_once '../classes/Request.php';
        $request = new Request;
        $request->capture( $this->requestMethod );
        //$request = GET;
        $element->request = $request;
        //$Authcontroller->controller->request = GET;
        require_once 'View.php';
        $view = new View;
        $element->view = $view;
        //$Authcontroller->controller->view = $view
        return call_user_func_array( array( $element, $method ), $variables );
        //variables o parametros
        //$element = AuthController
        //$method = login
        //$variables =
    }

    public function response()
    {
        print $this->direccionar();
    }

}