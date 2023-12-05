@component('mail::message')

Dear Support,

A Support ticket has been created at {{$details['location']}} about an issue with : **{{ $details['equipment_name'] }}**

# Fault Description
{{ $details['fault_description']}}

Please resolve as soon as possible.

@component('mail::button', ['url' => $details['link']])
View Ticket Details
@endcomponent

Thank you.

@endcomponent
