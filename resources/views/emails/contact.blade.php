<x-mail::message>
# Новое сообщение из контактной формы

**Имя:** {{ $name }}

**Email:** {{ $email }}

**Сообщение:**
{{ $message }}

<x-mail::button :url="''">
Перейти на сайт
</x-mail::button>

С уважением,<br>
{{ config('app.name') }}
</x-mail::message>
