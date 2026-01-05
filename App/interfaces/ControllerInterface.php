<?php

namespace App\interfaces;

interface ControllerInterface
{

    public function index();

    public function show( $params);

    public function create();

    public function store();

    public function save($params);

    public function delete( $params);

    public function edit( $params);
}
