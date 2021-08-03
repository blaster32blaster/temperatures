<?php

namespace App\Services;

use App\Http\Requests\NewTempEntryRequest;
use App\Repositories\TempEntryRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Khsing\World\World;
use stdClass;

class TemperatureService
{
    /**
     * a temp entry repo instance
     *
     * @var TempEntryRepository $tempEntryRepo
     */
    protected $tempEntryRepo;

    public function __construct(TempEntryRepository $teRepo)
    {
        $this->tempEntryRepo = $teRepo;
    }

    /**
     * fetch index view with data
     *
     * @return View
     */
    public function index() : View
    {
        return view('home')
            ->with('title', 'Temp by City')
            ->with('countries', $this->getCountriesAndCities())
            ->with('entries', $this->getCurrentEntries());
    }

    /**
     * store a record and then return the index
     *
     * @param NewTempEntryRequest $request
     * @return View
     */
    public function store(NewTempEntryRequest $request) : View
    {
        try {
            $country = json_decode($request->get('country'), FALSE);
            $date = Carbon::parse($request->get('date'));

            $this->tempEntryRepo->store([
                'country_id' => $country->id,
                'city_id' => $request->get('city'),
                'date' => $date->format('Y-m-d H:i:s'),
                'temperature' => $request->get('temp'),
                'standard' => $request->get('standard')
            ]);
        } catch (Exception $e) {
            logger()->error('error_creating_temperature_entry', [
                'class' => 'TemperatureService',
                'message' => $e->getMessage(),
                'request' => json_encode($request->all()),
                'stack' => $e->getTraceAsString()
            ]);
        }
        return $this->index();
    }

    /**
     * get the current entries
     *
     * @return Collection
     */
    protected function getCurrentEntries() : Collection
    {
        return $this->tempEntryRepo->query()
            ->with([
                'country',
                'city'
            ])
            ->get();
    }

    /**
     * attach cities to countries
     *
     * @return Collection the cities
     */
    protected function getCountriesAndCities() : Collection
    {
        $responseCollect = collect();

        foreach (World::Countries() as $country) {
            $country->cities = $country->children();
            $responseCollect->push($country);
        }
        return $responseCollect;
    }
}
