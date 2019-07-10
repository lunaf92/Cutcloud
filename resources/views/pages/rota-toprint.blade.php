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
                <tr>
                    <th scope="row"></th>
                    @for ($i = 0; $i < count($dates); $i++)
                        <th scope="row"> {!!$dates[$i]!!} </th>
                    @endfor
                </tr>
                <tr>
                    <th> Events of the week </th>
                    <th scope="row"> {!!(isset($event[0]->sunday)) ? $event[0]->sunday : ' '!!} </th>
                    <th scope="row"> {!!(isset($event[0]->monday)) ? $event[0]->monday : ' '!!} </th>
                    <th scope="row"> {!!(isset($event[0]->tuesday)) ? $event[0]->tuesday : ' '!!} </th>
                    <th scope="row"> {!!(isset($event[0]->wednesday)) ? $event[0]->wednesday : ' '!!} </th>
                    <th scope="row"> {!!(isset($event[0]->thursday)) ? $event[0]->thursday : ' '!!} </th>
                    <th scope="row"> {!!(isset($event[0]->friday)) ? $event[0]->friday : ' '!!} </th>
                    <th scope="row"> {!!(isset($event[0]->saturday)) ? $event[0]->saturday : ' '!!} </th>
                </tr>
                </thead>
                <tbody>
                <!--
                    * create a loop to iterate through each instance in the weekly rota database
                    * and create a row for each one; in case the username coincides with the name in the rota
                    * add class="active" to each row, so it is easier for the user to identify its own row
                -->
                @for ($j = 0; $j < count($positions); $j++)
                    @foreach ($users as $user)                
                        @if ($user->position == $positionsArray[$j]) 
                            <tr>
                            <th scope="row">
                                {{$user->first_name}}
                            </th>
                            @php
                                for($i=0; $i<count($users); $i++){
                                    if($users[$i]->id == $user->id){
                                        $x = $i;
                                        break;
                                    }
                                }

                                dd($colors);
                            @endphp
                            <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->sunday : '' !!}" >
                                <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('sunday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                ?>
                            </th>
                            <th scope="row" style="background-color: {!! (isset($color[$x])) ? $color[$x]->monday : '' !!}" >
                                <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('monday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                ?>
                            </th>
                            <th scope="row" style="background-color: {!! (isset($color[$x])) ? $color[$x]->tuesday : 'rgb(255, 255, 255)' !!}" >
                                <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('tuesday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                ?>
                            </th>
                            <th scope="row" style="background-color: {!! (isset($color[$x])) ? $color[$x]->wednesday : 'rgb(255, 255, 255)' !!}" >
                                <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('wednesday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                ?>
                            </th>
                            <th scope="row" style="background-color: {!! (isset($color[$x])) ? $color[$x]->thursday : 'rgb(255, 255, 255)' !!}" >
                                <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('thursday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                ?>
                            </th>
                            <th scope="row" style="background-color: {!! (isset($color[$x])) ? $color[$x]->friday : 'rgb(255, 255, 255)' !!}" >
                                <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('friday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                ?>
                            </th>
                            <th scope="row" style="background-color: {!! (isset($color[$x])) ? $color[$x]->saturday : 'rgb(255, 255, 255)' !!}" >
                                <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('saturday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                ?>
                            </th>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                    <td style="background-color:black" colspan="8">.</td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </body>
</html>