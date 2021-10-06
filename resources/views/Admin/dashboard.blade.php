@extends('Admin.index')
@section('main')
<div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="display-block">
                    <strong>
                        {{ $now->startOfWeek()->format('d') }} - {{ $now->startOfWeek()->addDays(6)->format('d') }}
                        {{ $now->format('F') }}
                        {{ $now->format('Y') }}
                    </strong>
                </div>
                <div>
                    <a href="{{ url('admin/dashboard?week='.(!empty(app('request')->input('week'))?app('request')->input('week')+1:1)) }}" class="btn btn-info float-right m-1">
                        Next Week
                    </a>
                    <a href="{{ url('admin/dashboard?week='.(!empty(app('request')->input('week'))?app('request')->input('week')-1:-1)) }}" class="btn btn-info float-right m-1">
                        Previous Week
                    </a>
                <div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30px">Job</th>
                                @for ($i=0; $i< 7; $i++)
                                    <th>
                                        <small>{{ $now->startOfWeek()->addDays($i)->format('D') }}</small><br>
                                        {{ $now->startOfWeek()->addDays($i)->format('d M Y') }}
                                        @if ($now->startOfWeek()->addDays($i)->diffInDays(now()->startOfDay()) == 0)
                                            (<span class="text-green">Today</span>)
                                        @endif
                                    </th>
                                @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $key=>$schedule)
                            <tr>
                                <td>{{ $key }}</td>
                                @for ($i=0; $i< 7; $i++)
                                    @if ($now->startOfWeek()->addDays($i)->diffInDays(Carbon\Carbon::parse($schedule[0]->set_date)->startOfDay()) == 0)
                                        <td>
                                            <a href="{{ route('admin.schedule.edit',$schedule[0]->uuid) }}" class="btn btn-secondary">
                                                {{ $schedule[0]->name }}
                                            </button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endfor
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
</div>

@endsection
