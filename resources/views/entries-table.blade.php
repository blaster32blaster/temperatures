<div
    id="entries-table-wrapper"
>
    <table>
        <thead>
            <tr>
                <th>
                    Country
                </th>
                <th>
                    City
                </th>
                <th>
                    Date
                </th>
                <th>
                    Farenheit
                </th>
                <th>
                    Celsius
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
                <tr>
                    <td>
                        {{ $entry->country->name }}
                    </td>
                    <td>
                        {{ $entry->city->name }}
                    </td>
                    <td>
                        {{ $entry->date }}
                    </td>
                    <td>
                        {{ $entry->getTheTempDisplay('farenheit') }}
                    </td>
                    <td>
                        {{ $entry->getTheTempDisplay('celsius') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
