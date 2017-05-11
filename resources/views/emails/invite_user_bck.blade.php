@extends('emails.layout')

@section('content')
    {{ config('app.name', 'Laravel') }}<br>
    {{$company->name}} invited you on Horizony<br>
    You 'll see the planning of the company<br>

    <a href="{{$user->generateUrlConnexion()}}">Go to your Horizon</a>

    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra lorem nulla, id interdum justo tincidunt at. Vivamus pellentesque condimentum arcu non ornare. Fusce sit amet ullamcorper sapien. Quisque ut nunc sollicitudin, bibendum tortor eget, accumsan nibh. Maecenas maximus nibh a dui lacinia, sit amet interdum dolor vehicula. Vivamus placerat velit justo, in tristique metus iaculis vel. Nam id lectus quis arcu porttitor interdum ut vitae dolor.
    <br><br>
    Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum vel lorem a urna porttitor finibus a eu metus. Pellentesque euismod libero faucibus erat fringilla mollis. Integer pellentesque, augue vitae dapibus rhoncus, nisi justo blandit ligula, a euismod tortor urna vitae orci. Ut viverra neque ut commodo ultrices. Maecenas scelerisque ipsum risus, nec cursus nisi vehicula ut. Mauris sodales tempus tortor eget iaculis. Nunc venenatis facilisis pharetra. Vivamus auctor in massa id semper. Curabitur eget quam non neque accumsan iaculis non malesuada ante.
    <br><br>
    In hac habitasse platea dictumst. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis a risus vel auctor. Phasellus non lobortis mauris, vitae rutrum odio. Maecenas euismod dui et eros pretium, quis pharetra nisl fermentum. Cras tincidunt leo sed nibh lobortis, vitae semper lorem feugiat. Vivamus egestas, eros sit amet volutpat suscipit, augue libero luctus risus, lobortis pharetra velit est non mi. Etiam arcu mi, pretium sed mi ut, imperdiet sagittis elit. Nullam vitae elit ante. Praesent congue hendrerit faucibus. Fusce tellus turpis, commodo luctus lacus in, mattis condimentum sapien. Aenean vel eros ut turpis dapibus vehicula id et neque. Pellentesque rutrum nec sem eget rhoncus. Quisque condimentum tortor velit, vel suscipit purus egestas eu. Maecenas consectetur egestas scelerisque. Vestibulum placerat posuere libero.
    <br><br>
    Nam gravida risus tempus sagittis lacinia. Morbi aliquet, lectus sit amet facilisis cursus, lorem lorem gravida metus, nec euismod erat diam ut purus. Etiam a porttitor nisl, quis mattis velit. Nulla facilisi. Nulla at dignissim velit, quis bibendum nisl. Suspendisse euismod congue elit non ornare. Vivamus quis nisi cursus, rutrum leo at, commodo turpis. Nullam porta nibh ac odio cursus commodo. Phasellus lectus neque, porttitor nec mattis nec, commodo sit amet mi. Proin pulvinar imperdiet risus, sit amet vestibulum odio gravida in. Proin dignissim tellus quis dignissim aliquam. Morbi mollis quam id lacinia volutpat. Aliquam erat volutpat. Nam tortor libero, egestas sit amet odio non, convallis porta eros. In massa lacus, interdum eget sapien id, cursus ultrices lectus.

@endsection
