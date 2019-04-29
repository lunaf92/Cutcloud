@extends('/inc.admin-template')

@section('content')
    <?php 
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
    ?>
<div class="wrapper">
    <div class="row">
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
                <a href="{{ action ('DraftsController@show', "$prevW")}}" class="btn btn-outline-secondary mb-3">
                    <span> Past week </span>
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
                <a href="{{ action ('DraftsController@show', "$nextW")}}" class="btn btn-outline-secondary mb-3">
                    <span> Next week </span>
                </a>
            </div>
        </div>
    </div>
    <div class="mr-3 ml-3" id="maintb"> 
        {!! Form::open(['action' => ['DraftsController@update', $currWeek], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="table pr-3 pl-3 mb-1">
            <div class="table-row">
                <div class="head-table-cell">Name</div>
                <div class="head-table-cell">Sunday</div>
                <div class="head-table-cell">Monday</div>
                <div class="head-table-cell">Tuesday</div>
                <div class="head-table-cell">Wednesday</div>
                <div class="head-table-cell">Thursday</div>
                <div class="head-table-cell">Friday</div>
                <div class="head-table-cell">Saturday</div>
            </div>
            <div class="table-row">
                @for ($i = 0; $i < count($dates); $i++)
                    <div class="head-table-cell"> {!!$dates[$i]!!} </div>
                @endfor
            </div>
            <!--
                * create a loop to iterate through each instance in the weekly rota database
                * and create a row for each one; in case the username coincides with the name in the rota
                * add class="active" to each row, so it is easier for the user to identify its own row
                * 
                * inside the loop the ternary operator is used to check the value of the input field.
                * I had to use a ternary operator because blade doesn't allow regular if statements
                * it checks wheter or not a draft has been submitted, if it is it displays it, otherwise
                * the default value is a '.', as few problems arises if all the values of a user stays NULL
                *
            -->
            @csrf
            @for ($j = 0; $j < count($positionsArray); $j++)
                @foreach ($users as $user)
                    @if ($user->position == $positionsArray[$j]) 
                    @php
                        for ($i = 0; $i < count($users); $i++){
                            if(!isset($rotas[$i])){
                                $k = $i;                                    
                            }else{
                                if ($rotas[$i]->user_id == $user->id){
                                    $k = $i;
                                    break;
                                }
                            }
                        }
                    @endphp
                        <div class="table-row">
                            <div class="table-cell">
                                {{$user->first_name}}
                                <input name="{!! $user->id !!}_user_id" type="hidden" value="{{$user->id}}">
                                <input name="{!! $user->id !!}_week_no" type="hidden" value="{{$currWeek}}">
                            </div>
                            <div class="table-cell">
                                <input type="text" name="{!! $user->id !!}_sunday" class="form-control" value="{!! (isset($rotas[$k])) ? (($rotas[$k]->user_id == $user->id) ? $rotas[$k]->sunday : '.' ) : '.' !!}">         
                            </div>
                            <div class="table-cell">
                                <input type="text" name="{!! $user->id !!}_monday" class="form-control" value="{!! (isset($rotas[$k])) ? (($rotas[$k]->user_id == $user->id) ? $rotas[$k]->monday : '.' ) : '.' !!}">      
                            </div>
                            <div class="table-cell">
                                <input type="text" name="{!! $user->id !!}_tuesday" class="form-control" value="{!! (isset($rotas[$k])) ? (($rotas[$k]->user_id == $user->id) ? $rotas[$k]->tuesday : '.' ) : '.' !!}">    
                            </div>
                            <div class="table-cell">
                                <input type="text" name="{!! $user->id !!}_wednesday" class="form-control" value="{!! (isset($rotas[$k])) ? (($rotas[$k]->user_id == $user->id) ? $rotas[$k]->wednesday : '.' ) : '.' !!}">   
                            </div>
                            <div class="table-cell">
                                <input type="text" name="{!! $user->id !!}_thursday" class="form-control" value="{!! (isset($rotas[$k])) ? (($rotas[$k]->user_id == $user->id) ? $rotas[$k]->thursday : '.' ) : '.' !!}">       
                            </div>
                            <div class="table-cell">
                                <input type="text" name="{!! $user->id !!}_friday" class="form-control" value="{!! (isset($rotas[$k])) ? (($rotas[$k]->user_id == $user->id) ? $rotas[$k]->friday : '.' ) : '.' !!}">         
                            </div>
                            <div class="table-cell">
                                <input type="text" name="{!! $user->id !!}_saturday" class="form-control" value="{!! (isset($rotas[$k])) ? (($rotas[$k]->user_id == $user->id) ? $rotas[$k]->saturday : '.' ) : '.' !!}">         
                            </div>    
                        </div>
                    @endif
                @endforeach
                <div class="table-row">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="dark-table-cell bg-dark"></div>
                    @endfor
                </div>
            @endfor
            <div class="text-center pb-3 mt-1">
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Submit Draft', ['class' => 'btn btn-primary text-center'])}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
    
@endsection