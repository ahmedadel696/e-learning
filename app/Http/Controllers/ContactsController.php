<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactsController extends Controller
{
    public function getContacts()
    {
        $contacts = Contact::all();
        if ($contacts) {
            $response =  $this->getResponse(1, "", $contacts);
        } else {
            $response =  $this->getResponse(0, "no contacts");
        }

        return response($response)->header('Content-Type', 'application/json');
    }

    public function updateContact(Request $request)
    {
        $contact_id = $request->contact_id;

        $contact = Contact::where('id', $contact_id)->first();

        if ($contact && $contact_id) {
            $contact->name = $request->name ?? $contact->name;
            $contact->number = $request->number ?? $contact->number;
            $contact->image = $request->image ?? $contact->image;
            $contact->save();
            $response =  $this->getResponse(1, 'contact updated succesfully');
        } else {
            $response =  $this->getResponse(0, "notFound");
        }

        return response($response)->header('Content-Type', 'application/json');
    }
    public function addContact(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->number = $request->number;
        $contact->image = $request->image;
        if (empty($contact->image)) {
            $contact->image = "new_contact.png";
        }
        if (empty($contact->name) || empty($contact->number)) {
            $response =  $this->getResponse(0, "Faild , Contact Name or number not valid");
        } else {
            if (strlen($contact->number) < 11 || strlen($contact->number) > 11) {
                $response =  $this->getResponse(0, "Faild , Contact Number must be 11 digits");
            } else {
                if ($contact->save()) {
                    $response =  $this->getResponse(1, 'contact Added succesfully');
                } else {
                    $response =  $this->getResponse(0, "Faild To Add Contact");
                }
            }
        }




        return response($response)->header('Content-Type', 'application/json');
    }

    public function deleteContact(Request $request)
    {
        $contact_id = $request->contact_id;

        if ($contact_id) {
            Contact::findOrFail($contact_id)->delete();
            $response =  $this->getResponse(1, 'contact deleted succesfully');
        } else {
            $response =  $this->getResponse(0, "Faild To Delete Contact");
        }

        return response($response)->header('Content-Type', 'application/json');
    }
}
