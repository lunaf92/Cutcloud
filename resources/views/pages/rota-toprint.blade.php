<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/myStyles.css') }}" rel="stylesheet">
    <title>pdf</title>
</head>
<body>
    @php
    $positionsArray = [];
        for ($i = 0; $i < count($positions); $i++){
            $positionsArray[$i] = $positions[$i]{'position'};
        }
    @endphp
    <h1>week from {{$dates[0]}} to {{$dates[6]}}</h1>
    <div class="container">    
        <table>
            <thead class="head">
                <tr>
                    <th scope="row">Name</th>
                    <th scope="row">Sunday</th>
                    <th scope="row">Monday</th>
                    <th scope="row">Tuesday</th>
                    <th scope="row">Wednesday</th>
                    <th scope="row">Thursday</th>
                    <th scope="row">Friday</th>
                    <th scope="row">Saturday</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($positions); $i++)
                    @foreach ($users as $user)
                        @if ($user->position == $positionsArray[$i])
                        <tr class="manager">
                                <th scope="row">
                                    {{$user->first_name}}
                                </th>
                                <th scope="row">
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('sunday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row">
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('monday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row">
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('tuesday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row">
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('wednesday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row">
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('thursday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row">
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('friday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row">
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('saturday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                            </tr>
                        @endif
                    @endforeach
                @endfor
            </tbody>
        </table>
    </div>
</body>
