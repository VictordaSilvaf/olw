<x-mail::message>
# Introduction

O total de vendas foi:
{{$user->email}}

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
