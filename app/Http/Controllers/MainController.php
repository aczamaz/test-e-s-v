<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainIndexRequest;
use App\Services\BuildService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct(public BuildService $serivce) { }
    public function index(MainIndexRequest $request)
    {
        return response($this->serivce->handle($request->validated()));
    } 
}
