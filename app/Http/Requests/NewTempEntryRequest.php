<?php

namespace App\Http\Requests;

use App\Repositories\TempEntryRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class NewTempEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country' => 'required',
            'city' => 'required',
            'date' => ['required', 'not_duplicated'],
            'temp' => 'required',
            'standard' => 'required'
        ];
    }

    /**
     * handle date validation
     *
     * @param $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->addExtension('not_duplicated', function ($attribute, $value, $parameters, $validator) {
                if ($this->request->has('date') &&
                $this->request->has('country') &&
                $this->request->has('city') &&
                !empty($this->request->get('date')) &&
                !empty($this->request->get('country')) &&
                !empty($this->request->get('city'))
            ) {
                $date = Carbon::parse($this->request->get('date'));
                $repo = resolve(TempEntryRepository::class);

                $entry = $repo->query()
                    ->where('country_id', '=', json_decode($this->request->get('country'), FALSE)->id)
                    ->where('city_id', '=', $this->request->get('city'))
                    ->whereRaw('date(date) = ?', [$date->format('Y-m-d')]);
            }
            if ($entry->count() !== 0) {
                $validator->errors()->add('date', 'A city may only have one entry per date!');
                return false;
            } else {
                return true;
            }
        });
    }
}
