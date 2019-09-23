<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19-9-23
 * Time: 上午10:31
 */

namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;

class Index extends Controller
{

    function index()
    {
        // TODO: Implement index() method.
        $this->response()->write('hello world');
    }

    function wstool() {
        $this->response()->redirect('/wstool.html');
    }

}