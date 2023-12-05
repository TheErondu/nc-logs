@component('mail::message')

Dear Support,

An updated has been maden to the Support ticket created at {{$details['location']}} about an issue with : **{{ $details['equipment_name'] }}**

# Fault Description
{{ $details['fault_description']}}

------------

Status has been chaned to {{$details['status']}}

@component('mail::button', ['url' => $details['link']])
View Ticket Details
@endcomponent

Thank you.

@endcomponent
