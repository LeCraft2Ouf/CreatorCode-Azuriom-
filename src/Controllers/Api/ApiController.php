<?php

namespace Azuriom\Plugin\CreatorCodes\Controllers\Api;

use Azuriom\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'ok',
        ]);
    }
}
