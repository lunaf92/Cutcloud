@extends('/inc.admin-template')

@section('content')
<?php
$currWeek =date("W") . '_' . date("Y");
$nextWeek = (int)date("W")+1 . '_' . date("Y");
?>
<div class="container">
    <ul>
        <li>
    <a href="{{ action ('RotaController@show', "$currWeek")}}">see current week rota</a>
        </li>
        <li>
            <a href="{{ action ('DraftsController@show', "$nextWeek")}}">create draft rota</a>
        </li>
    </ul>
</div>

    @endsection