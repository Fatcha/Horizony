
    {{ config('app.name', 'Laravel') }}
    {{$company->name}} invited you on Horizony
    You 'll see the planning of the company

        Go to your Horizon by clicking here :  {{$user->generateUrlConnexion()}}
