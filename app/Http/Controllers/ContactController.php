<?php

namespace App\Http\Controllers;

use Domain\Contact\ViewModels\ContactViewModel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function page()
   {
       $contacts  = ContactViewModel::make()->listContacts();

       return view('pages.contacts',
           [
               'contacts' => $contacts,
           ]);
   }
}
