<div id="input-form-wrapper">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="/" id="temp-form">
        @csrf
        <div id="country-wrapper">
            <label for="country">
                Country
            </label>
            <select
                class="form-control"
                name="country"
                id="country-select"
            >
                <option
                >
                    Select a Country
                </option>
                @foreach($countries as $country)
                    <option
                        value="{{$country}}"
                    >
                        {{$country->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="city-wrapper">
            <label
                for="city"
            >
                City
            </label>
            <select
                class="form-control"
                name="city"
                id="city-select"
            >
                <option
                    value="selectcountry"
                >
                    Select a Country
                </option>
            </select>
        </div>
        <div id="date-wrapper">
            <label
                for="date"
            >
                Date
            </label>
            <div
                class='input-group date'
                id='datetimepicker'
            >
                <input
                    type='text'
                    class="form-control"
                    name='date'
                />
                <span
                    class="input-group-addon"
                >
                    <span
                        class="glyphicon glyphicon-calendar"
                    >
                    </span>
                </span>
            </div>
        </div>
        <div id="temp-wrapper">
            <label
                for="temp"
            >
                Temperature
            </label>
            <br />
            <input
                type="text"
                name="temp"
                placeholder="Enter a Temperature"
            />
        </div>
        <div id="standard-wrapper">
            <label
                for="standard"
            >
                Standard
            </label>
            <select
                class="form-control"
                name="standard"
                id="standard-select"
            >
                <option
                    value="farenheit"
                >
                    Farenheit
                </option>
                <option
                    value="celsius"
                >
                    Celsius
                </option>
            </select>
        </div>
        <input
            type="submit"
            class="btn btn-primary btn-form"
            value="SUBMIT"
        />
    </form>
</div>
