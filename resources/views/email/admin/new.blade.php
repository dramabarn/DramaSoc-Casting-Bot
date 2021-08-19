@component('mail::message')
    # Hello!

    Someone has set up an account for you on Casting Bot.
    This is for your {{$showData['type']}}, {{$showData['show']}}, in week {{$showData['week']}}.

    Casting Bot can be found at {{ config('app.url') }}
    Your login information is:
    Username: {{ $showData['email'] }}
    Password: {{ $showData['password'] }}

    When you log in, you will need to:
    1. Add roles for your show
    2. Add a first, second and third choice for each role

    You can add someone to multiple roles, but don't forget you need to fill all your roles!

    There will be a casting meeting soon, please look out for another email from us to let you know when that is.
    If you have any questions about CastingBot or Casting Meeting, please get in touch!

    Thanks,
    {{ config('app.name') }}
@endcomponent
