@php
use app\controller\events;
use app\controller\group;

$events = events::index();
@endphp
<form action="{{ $_SERVER['PHP_SELF'] }}" method="POST">
    <div class="row mt-3 g-3 justify-content-center">
        <div class="col-md-10">
            <fieldset>
                <div class="form-floating">
                    <input type="text" class="form-control" name="event" id="event" placeholder="{{ lang['event'] }}"
                        list="event_list" required />
                    <label for="event">
                        {{ lang['event'] }}
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                    <datalist id="event_list">
                        @foreach($events['proposals'] as $row){
                        <option value="{{ $row->event }}">
                            @endforeach
                    </datalist>
                </div>
            </fieldset>
        </div>
        <div class="col-md-10">
            <div class="row g-3" id="groups">
                <div class="col-12">
                    <fieldset>
                        <div class="input-group">
                            <label for="group">
                                {{ lang['group'] }}
                                <span style="color: red;">
                                    *
                                </span>
                            </label>
                            <select class="form-select multiple-select" name="group[]" multiple="multiple" required>

                                @foreach($events['group'] as $row)
                                <option value="{{ $row->alias }}">{{ $row->name }} ({{ $row->alias }})</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-3">
                    <fieldset>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="room" id="room"
                                placeholder="{{ lang['room'] }}">
                            <label for="room">
                                {{ lang['room'] }}
                            </label>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <fieldset>
                <div class="form-floating">
                    <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                        value="{{ strftime('%Y-%m-%dT00:00') }}" required>
                    <label for="start_date">
                        {{ lang['start'] }} {{ lang['date'] }}
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                </div>
            </fieldset>
        </div>
        <div class="col-md-5">
            <fieldset>
                <div class="form-floating">
                    <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                        value="{{ strftime('%Y-%m-%dT00:00') }}" required>
                    <label for="end_date">
                        {{ lang['end'] }} {{ lang['date'] }}
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                </div>
            </fieldset>
        </div>
        <div class="col-md-10">
            <fieldset>
                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="set_repeat" name="set_repeat"
                            data-toggle="toggle" autocomplete="off">
                        <label class="form-check-label" for="set_repeat">
                            {{ lang['repeat'] }}
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <fieldset id="set_repeat_input_1" disabled>
                    <label class="form-label" for="days">
                        {{ lang['days'] }} :
                    </label>
                    <input class="form-control" type="number" placeholder="{{ lang['days'] }}" min="0"
                        name="repeat_days" id="repeat_days" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="In wievielen Tagen sich der Termin wiederholen soll">
                </fieldset>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <fieldset id="set_repeat_input_2" disabled>
                    <label class="form-label" for="repeats">
                        {{ lang['repeat'] }} :
                    </label>
                    <input class="form-control" type="number" placeholder="{{ lang['repeat'] }}" min="0" name="repeats"
                        id="repeats" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Wie oft sich der Termin wiederholen soll">
                </fieldset>
            </div>
        </div>

        <div class="col-8">
            <div class="form-group">
                <button type="submit" class="btn btn-outline-success w-100" name="submit_event" value="submit">
                    {{ lang['add'] }}
                </button>
            </div>
        </div>
    </div>
</form>