@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}&nbsp;&nbsp;&nbsp;<a href="{{ route('logs.create')}}">{{ __('Enter New Log') }}<i class="fas fa-plus"></i></a></div>
                <div class="card-body">
                    {{ __('You are logged in!') }}
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    eventSources: [
                        // your event source
                        {
                            url: 'logs/calendar/',
                            method: 'GET',
                            id: 'id',
                            title: 'title',
                            start: 'start',
                            end: 'end',
                            extendedProps: {
                            new_development: 'new_development'
                                            },
                        }
                        // any other sources...
                    ],
                    eventClick: function(info) {
                        window.location = "/logs/" + info.event.id;
                    },
                    eventMouseEnter: function(info) {
                        console.log('eventMouseEnter');
            var tis=info.el;
            var tooltip = '<div class="tooltipevent" style="top:'+($(tis).offset().top-5)+'px;left:'+($(tis).offset().left+($(tis).width())/2)+'px"><div>' + info.event.title + '</div><div>' + info.event.extendedProps.new_development + '</div></div>';
            var $tooltip = $(tooltip).appendTo('body');
//            If you want to move the tooltip on mouse movement then you can uncomment it
//            $(tis).mouseover(function(e) {
//                $(tis).css('z-index', 10000);
//                $tooltip.fadeIn('500');
//                $tooltip.fadeTo('10', 1.9);
//            }).mousemove(function(e) {
//                $tooltip.css('top', e.pageY + 10);
//                $tooltip.css('left', e.pageX + 20);
//            });
        },
        eventMouseLeave: function(info) {
            console.log('eventMouseLeave');
            $(info.el).css('z-index', 8);
            $('.tooltipevent').remove();
        },
      });
      calendar.render();
    });

  </script>
@endsection

