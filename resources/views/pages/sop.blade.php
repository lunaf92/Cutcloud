@extends('/inc.template')

@section('content')
<div class="wrapper-post">
    <h1 class="text-center">SOP list</h1>
    @php
    $categoriesArray = [];
        for ($i = 0; $i < count($categories); $i++){
            $categoriesArray[$i] = $categories[$i]{'category'};
        }
    @endphp
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 25%">Title</th>
                <th style="width: 25%">Date of upload</th>
                <th style="width: 30%">Action</th>
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
            @php
                $date = explode(" ",$sop->created_at);
            @endphp
                @if ($sop['category'] == $categoriesArray[$i])
                    <tr>
                        <td>{!!$sop->name!!}</td>
                        <td>{!!$date[0]!!}</td>
                        <td>
                            <a href="/storage/SOP_description/{{$sop['SOP_description']}}" download="{{$sop['SOP_description']}}" class="btn btn-success">
                                Download
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        @endfor
    </table>
</div>

@endsection