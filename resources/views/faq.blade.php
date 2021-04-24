@extends('layout')

@section('title')
    FAQ
@endsection

@section('header')
    FAQ
@endsection

@section('content')
<article class="bg-white rounded shadow p-4 my-4 dark:bg-gray-800">
    <h3 class="text-lg font-bold">1. How to get my bot on the website?</h3>
    <p class="py-2">Contact an admin on IRC (Sirus, Jenga) or ask on Discord.</p>

    <h3 class="text-lg font-bold">2. Why is a bot down?</h3>
    <p class="py-2">We don't know, we only provide the parser and channel for downloading, we may know the bot owners, but won't help you get the bot up as they're not ours.</p>

    <h3 class="text-lg font-bold">3. Why is the bot sending me the wrong files?</h3>
    <p class="pt-2">Sometimes the bots sort their files upon adding them, causing the packlist on the NIBL website to be wrong.  This is normal behavior and takes around 15 minutes for the nibl listing to be updated. If you run into this issue, please wait 15 minutes and try again.</p>
    <p class="py-2">You can also request a packlist from the bot itself, such as: <span class="font-semibold">msg bot xdcc -1</span>, or possibly <span class="font-semibold">msg bot xdcc list</span> If it supports this, it will be the most accurate and up to date listing possible.</p>

    <h3 class="text-lg font-bold">4. Why is a bot no longer on the parser?</h3>
    <p class="py-2">We tried to contact the owner, but it wasn't answering, so we removed the bot from the list. (We're not gonna chase the bots owners, so don't ask)</p>

    <h3 class="text-lg font-bold">5. Why is X bot this slow?</h3>
    <p class="py-2">Too large of a queue, too many packs or aging server hardware are some of the reasons.</p>
</article>
@endsection
