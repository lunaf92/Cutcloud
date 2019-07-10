@extends('/inc.template')

@section('content')
@php
    $positionsArray = [];
    for ($i = 0; $i < count($positions); $i++){
        $positionsArray[$i] = $positions[$i]{'position'};
    }
    $weekToggler = explode('_', $currWeek);
    $nextW = (((int)$weekToggler[0])+1) . '_' . $weekToggler[1];
    $prevW = (((int)$weekToggler[0])-1) . '_' . $weekToggler[1];
    $yr = new DateTime('December 28th' . ', ' . (string)$weekToggler[1]);
    $limit = (int)$yr->format('W');
    $k=0;
    // add empty element at the beginning of the dates array, for display purposes
    array_unshift($dates, " ");
@endphp 
<div class="wrapper-post">
    {{-- tablet and desktop view --}}
    <div class="d-none d-md-block">
        <div class="row mb-3" >
            <div class="col-6 text-left">   
                <div class="next">
                        @php
                        if((int)$weekToggler[0] <2){
                            $currentY = (((int)$weekToggler[1])-1);
                            $dateTime = new DateTime('December 28th' . ', ' . $currentY);
                            $tempPrevW = $dateTime->format('W');
                            $prevW = $tempPrevW . '_' . $currentY;
                        }
                    @endphp
                    <a href="{{ action ('HomeController@toggleWeek', "$prevW")}}" class="btn btn-outline-secondary mb-3">
                        <span> past week </span>
                    </a>
                </div>
            </div>
            <div class="col-6 text-right">   
                <div class="next">
                        @php
                        if((int)$weekToggler[0] >= $limit){
                            $currentY = (((int)$weekToggler[1])+1);
                            $nextW = '1_' . $currentY;
                        }
                    @endphp
                    <a href="{{ action ('HomeController@toggleWeek', "$nextW")}}" class="btn btn-outline-secondary mb-3">
                        <span> next week </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="mr-3 ml-3">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
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
                        @for ($i = 0; $i < count($dates); $i++)
                            <th scope="row"> {!!$dates[$i]!!} </th>
                        @endfor
                    </tr>
                    <tr>
                        <th> </th>
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
                                @php
                                    for($i=0; $i<count($users); $i++){
                                    if(!isset($rotas[$i])){
                                        if(!isset($draftRotas[$i])){
                                            $k=$i;
                                        }else{
                                                if ($draftRotas[$i]->user_id == $user->id){
                                                    $k = $i;
                                                    break;
                                                }
                                            }
                                        }else{
                                            if ($rotas[$i]->user_id == $user->id){
                                                $k = $i;
                                                break;
                                            }       
                                        }
                                    }
                                @endphp
                            <tr>
                                <th scope="row">
                                    {{$user->first_name}}
                                </th>
                                @php
                                    for($i=0; $i<count($colors); $i++){
                                        if($colors[$i]->user_id == $user->id){
                                            $x = $i;
                                            break;
                                        }
                                    }
                                @endphp
                                <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->sunday : '' !!}" >
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('sunday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->monday : '' !!}" >
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('monday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->tuesday : '' !!}" >
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('tuesday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->wednesday : '' !!}" >
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('wednesday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->thursday : '' !!}" >
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('thursday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->friday : '' !!}" >
                                    <?php
                                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $user->id)->pluck('friday');
                                    $currDay = trim($currDay, "[\"]");
                                    echo($currDay);   
                                    ?>
                                </th>
                                <th scope="row" style="background-color: {!! (isset($colors[$x])) ? $colors[$x]->saturday : '' !!}" >
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
                                <td class="bg-dark" colspan="8"></td>
                            </tr>
                        @endfor
                </tbody>
            </table>
        </div>    
    </div>
</div>

{{-- mobile view of the page --}}
<div class="d-md-none">    
    <h5 class="text-center font-weight-bold mb-3">Week from {!!$dates[1] !!} to {!!$dates[7] !!}</h5>
    <p class="text-center mb-3 "><a href="{{ action ('HomeController@pdf', "$currWeek")}}" class="text-info "><u>download</u></a></p>

    <div class="text-center mx-5">
        <ul class="list-group list-group-flush">
            <li class="list-group-item "><div class="btn btn-block btn-link" onclick="switchClass('sunday-val')"><h3 class="font-weight-bold">sunday</h3></div> </li>
            <li id="sunday-val" class="list-group-item d-none">
                <?php
                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $currentUser)->pluck('sunday');
                    $currDay = trim($currDay, "[\"]");
                    echo($currDay);   
                ?>
            </li>
            <li class="list-group-item"><div class="btn btn-block btn-link" onclick="switchClass('monday-val')"><h3 class="font-weight-bold">monday</h3></div> </li>
            <li id="monday-val" class="list-group-item d-none">
                <?php
                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $currentUser)->pluck('monday');
                    $currDay = trim($currDay, "[\"]");
                    echo($currDay);   
                ?>
            </li>
            <li class="list-group-item"><div class="btn btn-block btn-link" onclick="switchClass('tuesday-val')"><h3 class="font-weight-bold">tuesday</h3></div> </li>
            <li id="tuesday-val" class="list-group-item d-none">
                <?php
                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $currentUser)->pluck('tuesday');
                    $currDay = trim($currDay, "[\"]");
                    echo($currDay);   
                ?>
            </li>
            <li class="list-group-item"><div class="btn btn-block btn-link" onclick="switchClass('wednesday-val')"><h3 class="font-weight-bold">wednesday</h3></div> </li>
            <li id="wednesday-val" class="list-group-item d-none">
                <?php
                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $currentUser)->pluck('wednesday');
                    $currDay = trim($currDay, "[\"]");
                    echo($currDay);   
                ?>
            </li>
            <li class="list-group-item"><div class="btn btn-block btn-link" onclick="switchClass('thursday-val')"><h3 class="font-weight-bold">thursday</h3></div> </li>
            <li id="thursday-val" class="list-group-item d-none">
                <?php
                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $currentUser)->pluck('thursday');
                    $currDay = trim($currDay, "[\"]");
                    echo($currDay);   
                ?>
            </li>
            <li class="list-group-item"><div class="btn btn-block btn-link" onclick="switchClass('friday-val')"><h3 class="font-weight-bold">friday</h3></div> </li>
            <li id="friday-val" class="list-group-item d-none">
                <?php
                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $currentUser)->pluck('friday');
                    $currDay = trim($currDay, "[\"]");
                    echo($currDay);   
                ?>
            </li>
            <li class="list-group-item"><div class="btn btn-block btn-link" onclick="switchClass('saturday-val')"><h3 class="font-weight-bold">saturday</h3></div> </li>
            <li id="saturday-val" class="list-group-item d-none">
                <?php
                    $currDay = (string)$rotas->where('week_no', 'like', $currWeek)->where('user_id', 'like', $currentUser)->pluck('saturday');
                    $currDay = trim($currDay, "[\"]");
                    echo($currDay);   
                ?>    
            </li>
        </ul>
    </div>
</div>
{{-- end of mobile view --}}


@endsection