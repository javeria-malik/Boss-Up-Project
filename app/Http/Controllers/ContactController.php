<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $messages = Contact::latest()->paginate(10); // Latest messages sabse pehle dikhane ke liye
        return view('admin.contact.contact', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
   // Ek specific message ko show karne ka function
   public function show($id)
   {
       $message = Contact::findOrFail($id);
       return view('admin.contact.show', compact('message'));
   }

   // Message delete karne ka function
   public function destroy($id)
   {
       $message = Contact::findOrFail($id);
       $message->delete();

       return redirect()->route('admin.contact')->with('success', 'Message deleted successfully!');
   }
}
