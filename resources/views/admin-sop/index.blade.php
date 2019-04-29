@extends('/inc.admin-template')

@section('content')
    <h1 class="text-center ">SOPs</h1>
    @php
    $categoriesArray = [];
        for ($i = 0; $i < count($categories); $i++){
            $categoriesArray[$i] = $categories[$i]{'category'};
        }
    @endphp
    <div class="wrapper">
        <a href="admin-sop/create">add new SOP</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 25%">Title</th>
                    <th style="width: 25%">Date of upload</th>
                    <th style="width: 40%">Action</th>
                </tr>
            </thead>
            @for ($i = 0; $i < count($categories); $i++)
                <tbody>
                    <tr>
                        <td class="head-table-cell text-center" colspan="3" onclick="switchClass('{{$categoriesArray[$i]}}')">{{$categoriesArray[$i]}}</td>
                    </tr>
                </tbody>
                <tbody id="{{$categoriesArray[$i]}}" class="d-none">
                @foreach ($sops as $sop)
                    @if ($sop['category'] == $categoriesArray[$i])
                        <tr>
                            <td style="width: 25%">{!!$sop->name!!}</td>
                            <td style="width: 25%">{!!$sop->created_at!!}</td>
                            <td style="width: 40%">
                                <a href="/storage/SOP_description/{{$sop['SOP_description']}}" class="btn btn-success float-left mr-5" download="{{$sop['SOP_description']}}">
                                    Download
                                </a>
                                <a href="{{ action ('SOPController@edit', "$sop->id")}}" class="btn btn-dark float-left mr-5">
                                    Update
                                </a>
                                {!! Form::open(['action' => ['SOPController@destroy', $sop->id], 'method' => 'POST', 'class' => 'float-left']) !!}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            @endfor
        </table>
    </div>
@endsection