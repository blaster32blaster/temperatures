<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewTempEntryRequest;
use App\Services\TemperatureService;
use Illuminate\View\View;

class TemperatureDashboardController extends Controller
{
    /**
     * a temp service instance
     *
     * @var TemperatureServce $tempService
     */
    protected $tempService;

    public function __construct(TemperatureService $ts)
    {
        $this->tempService = $ts;
    }

    /**
     * fetch the index view
     *
     * @return View
     */
    public function index() : View
    {
        return $this->tempService->index();
    }

    /**
     * store the resource
     *
     * @param NewTempEntryRequest $request
     * @return View
     */
    public function store(NewTempEntryRequest $request) : View
    {
        return $this->tempService->store($request);
    }
}
