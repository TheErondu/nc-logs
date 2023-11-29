@component('mail::message')

#  {{ $details['user'] }} has Submitted a new {{ $details['model'] }}!

# Date:
{{ $details['date'] }}

# Problems:
{{ $details['problems'] }}

# Resolutions :
 {{ $details['resolutions'] }}

# New Developments:
 {{ $details['new_development'] }}

# Comments/Recommendations
{{ $details['comments'] }}

{{-- ## Review the Ticket by clicking this button --}}
{{--
@component('mail::button', ['url' => $details['link']])
View in Dashboard
@endcomponent --}}

Thanks,<br>
NC Logger
@endcomponent
