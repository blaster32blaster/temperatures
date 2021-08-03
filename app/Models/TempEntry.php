<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Khsing\World\Models\City;
use Khsing\World\Models\Country;

class TempEntry extends Model
{
    use HasFactory;

    /**
     * the guarded model atts
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * the fillable model atts
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'city_id',
        'temperature',
        'standard',
        'date'
    ];

    /**
     * get the country relation
     *
     * @return BelongsTo
     */
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * get the city relation
     *
     * @return BelongsTo
     */
    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * get or convert the temperature
     *
     * @param string $standard
     * @return integer
     */
    public function getTheTempDisplay(string $standard) : int
    {
        $theStandard = strtolower($standard);
        if ($theStandard === $this->standard) {
            return $this->temperature;
        }

        if ($theStandard === 'farenheit') {
            return $this->convertCelsiusToFarenheit();
        }

        if ($theStandard === 'celsius') {
            return $this->convertFarenheitToCelsius();
        }
    }

    /**
     * convert farenheit to celsius
     *
     * @return integer
     */
    public function convertFarenheitToCelsius() : int
    {
        return ($this->temperature - 32) / 1.8;
    }

    /**
     * convert celsius temp to farenheit
     *
     * @return integer
     */
    public function convertCelsiusToFarenheit() : int
    {
        return ($this->temperature * 1.8) + 32;
    }
}
