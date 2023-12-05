@component('mail::message')

**A ticket has been Escalated:**

Dear Support,

A Support ticket created at {{$issue['location']}} about an issue with : **{{ $issue['equipment_name'] }}** has been escalated to you as it has remained unresolved.

# Fault Description
{{ $issue['fault_description']}}

Please ensure that Follow up actions are taken to mitigate any further downtime.

Best regards,

Ticket Monitoring System.

@endcomponent
