<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Обрабатывает отправку контактной формы.
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);
        
        // Отправка письма администратору (в реальной системе)
        // Mail::to('admin@example.com')->send(new ContactFormMail($request->all()));
        
        return redirect()->route('home')
            ->with('success', 'Ваше сообщение было успешно отправлено. Мы свяжемся с вами в ближайшее время.');
    }
} 