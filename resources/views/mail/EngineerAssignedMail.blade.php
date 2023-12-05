@component('mail::message')

# {{ $details['supervisor'] }} has assigned {{ $details['assigned_engineer'] }} to the ticket raised for Equipment / Item :

{{ $details['equipment_name'] }} with fault description:

"{{ $details['fault_description'] }}"


## Store : {{ $details['location'] }}.

## Review the Ticket by clicking this button

@component('mail::button', ['url' => $details['link']])
View Ticket Details
@endcomponent

Thanks,<br>
@endcomponent
