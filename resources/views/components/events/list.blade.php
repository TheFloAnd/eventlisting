@php
use app\controller\events;
use app\controller\group;
$events = events::index();
@endphp
<div class="table-responsive">
  <table class="table table-striped table-hover" id="refresh_edit">
    <thead>
      <tr>
        <th scope="col">{{ lang['project'] }}</th>
        <th scope="col">{{ lang['group'] }}</th>
        <th scope="col">{{ lang['room'] }}</th>
        <th scope="col">{{ lang['from'] }}</th>
        <th scope="col">{{ lang['till'] }}</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($events['result'] as $row)
      @set($start = strftime('%Y-%m-%d', strtotime($row->start)))
      @set($end = strftime('%Y-%m-%d', strtotime($row->end)))
      @if($start >= strftime('%Y-%m-%d') OR $end >= strftime('%Y-%m-%d'))
      @if($row->not_applicable == 1)
      @set($disabled = "class=\"table-danger strikeout\"")
      @else
      @set($disabled = '')
      @endif
      <tr {{ $disabled }}>
        <td>{{ $row->event }}</td>
        <td>
          @set($teams = array_pop(explode(";", {{ $row->team }})))
          @foreach($teams as $team)
          <span class=\"badge text-dark\" style=\"background-color:{{ GROUP::find($team)->color }};\">
            {{ $team }}
          </span>
          @endforeach
        </td>
        <td>{{$row->room}}</td>
        @if(strftime('%d.%m.%Y', strtotime($row->start)) != strftime('%d.%m.%Y', strtotime($row->end)))
        @if(strftime('%H:%M', strtotime($row->start)) == '00:00')
        <td>{{ strftime('%d.%m.%Y', strtotime($row->start)) }}</td>
        @else
        <td>{{ strftime('%d.%m.%Y - %H:%M', strtotime($row->start)) }}</td>
        @endif
        @if(strftime('%H:%M', strtotime($row->end)) == '00:00')
        <td>{{ strftime('%d.%m.%Y ', strtotime($row->end)) }}</td>
        @else
        <td>{{ strftime('%d.%m.%Y - %H:%M', strtotime($row->end)) }}</td>
        @endif
        @endif
        @if(strftime('%d.%m.%Y', strtotime($row->start)) == strftime('%d.%m.%Y', strtotime($row->end)))
        @if(strftime('%H:%M', strtotime($row->start)) == strftime('%H:%M', strtotime($row->end)))
        @if(strftime('%H:%M', strtotime($row->start)) == '00:00')
        <td colspan=\"2\">{{ strftime('%d.%m.%Y ', strtotime($row->start)) }}</td>
        @else
        <td colspan=\"2\">{{ strftime('%d.%m.%Y - %H:%M', strtotime($row->start)) }}</td>
        @endif
        @endif
        @if(strftime('%H:%M', strtotime($row->start)) != strftime('%H:%M', strtotime($row->end)))
        @if(strftime('%H:%M', strtotime($row->start)) == '00:00')
        <td>{{ strftime('%d.%m.%Y', strtotime($row->start)) }}</td>
        @else
        <td>{{ strftime('%d.%m.%Y - %H:%M', strtotime($row->start)) }}</td>
        @endif
        @if(strftime('%H:%M', strtotime($row->end)) == '00:00')
        <td>{{ strftime('%d.%m.%Y', strtotime($row->end)) }}</td>
        @else
        <td>{{ strftime('%H:%M', strtotime($row->end)) }}</td>
        @endif
        @endif
        @endif
        <td>
          <a href=\"?b=events_edit&id={{ $row->id }}\" type=\"button\" class=\"btn btn-sm btn-secondary
            position-relative\">
            <i class=\"bi bi-gear-wide\"></i>
          </a>
        </td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>