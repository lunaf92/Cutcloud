@extends('/inc.template')

@section('content')
<div class="wrapper-post">
    <h1 class="text-center">Menu descriptions</h1>
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
                    <th style="width: 25%">Action</th>
                </tr>
            </thead>
            @for ($i = 0; $i < count($categories); $i++)
                <tbody>
                    <tr>
                        <td class="head-table-cell text-center" colspan="3" onclick="switchClass('{{$categoriesArray[$i]}}')">{{$categoriesArray[$i]}}</td>
                    </tr>
                </tbody>
                <tbody id="{{$categoriesArray[$i]}}" class="d-none">
                @foreach ($menus as $menu)
                    @if ($menu['category'] == $categoriesArray[$i])
                        <tr>
                            <td>{!!$menu->name!!}</td>
                            <td>{!!$menu->created_at!!}</td>
                            <td>
                                <a href="/storage/menu_description/{{$menu['category']}}/{{$menu['menu_description']}}" download="{{$menu['menu_description']}}" class="btn btn-success">
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