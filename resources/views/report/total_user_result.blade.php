@extends('layouts.app')

@section('content')

    
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Reporte total de usuarios</h3>
                    @if($_GET['date1'] == $_GET['date2'])
                    <h5>Del {{ $_GET['date1'] }}</h5>
                    @else
                    <h5>Del {{ $_GET['date1'] }} al {{ $_GET['date2'] }}</h5>
                    @endif
                    @if(count($follows) > 0)
                    <h6>{{ count($follows) }} seguimientos en total.</h6>
                    @endif
                </div>
                <div class="card-body">
                @if(count($follows) <= 0)
                @include('layouts.no_records')
                @else
                <table class="table table-striped">
                    @foreach($users as $user)

                    @php
                        if($_GET['date1'] == $_GET['date2'])
                        {
                            $follows = App\AccountFollow::
                            where('author_id',$user->id)
                            ->whereDate('created_at', $_GET['date1'])
                            ->orderBy('created_at','DESC')
                            ->get();
                        }else{
                            $follows = App\AccountFollow::
                            where('author_id',$user->id)
                            ->whereBetween('created_at', [$_GET['date1'], $_GET['date2']])
                            ->orderBy('created_at','DESC')
                            ->get();
                        }
                    @endphp

                    <tr>
                        <th>
                        <b style="color:{{ $user->color }}">{{ $user->name }} {{ $user->middle_name }}</b>
                        <br/>
                        <center><b style="color:#8E44AD">{{ count($follows) }}</b></center>
                        </th>
                        @foreach($options as $option)
                        <td>
                            
                            @php
                            if($_GET['date1'] == $_GET['date2'])
                            {
                                $follows = App\AccountFollow::
                                where('author_id',$user->id)
                                ->where('follow_option_id',$option->id)
                                ->whereDate('created_at', $_GET['date1'])
                                ->orderBy('created_at','DESC')
                                ->get();
                            }else{
                                $follows = App\AccountFollow::
                                where('author_id',$user->id)
                                ->where('follow_option_id',$option->id)
                                ->whereBetween('created_at', [$_GET['date1'], $_GET['date2']])
                                ->orderBy('created_at','DESC')
                                ->get();
                            }
                            @endphp
                            <center><b style="color:#8E44AD">{{ count($follows) }}</b></center>
                            <br/>
                            <small>{{ $option->option }}</small>
                        </td>
                        @endforeach
                        
                    </tr> 
                    @endforeach
                </table>
                @endif
                </div>
            </div>
        </div>


@endsection