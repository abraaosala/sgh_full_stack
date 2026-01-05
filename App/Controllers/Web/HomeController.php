<?php

namespace App\Controllers\Web;

use App\Http\BaseController as Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class HomeController extends Controller
{
    public function index()
    {
        // TODO: implement index method
        $this->render([
            'partials.header-html(medicio)',
            'partials.header(medicio)',
            'home',
            'partials.footer',
            'partials.footer-html(medicio)'
        ], globals([
            'title' => 'Home Page',
            'content' => 'Welcome to the Home Page!'
        ]));
    }

    public function show($id)
    {
        // TODO: implement show method
    }

    public function create()
    {
        // TODO: implement create method
    }

    public function store()
    {
        // TODO: implement store method
    }

    public function edit($id)
    {
        // TODO: implement edit method
    }

    public function update($id)
    {
        // TODO: implement update method
    }

    public function delete($id)
    {
        // TODO: implement delete method
    }

    
}