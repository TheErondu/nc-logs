@component('mail::message')

**A ticket has been raised.:**

Dear Support,

A Support ticket has been created at {{$details['location']}} about an issue with : **{{ $details['equipment_name'] }}**

# Fault Description
{{ $details['fault_description']}}
@endcomponent
