<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactsImport;
use App\Models\Contact;
use App\Models\ScheduledNotification;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('upload-form');
    }

    public function upload(Request $request)
    { $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');

    try {
      
        Excel::import(new ContactsImport, $file);
        
        return redirect()->route('upload.form')->with('success', 'File uploaded and contacts imported successfully.');
    } catch (\Exception $e) {
        return redirect()->route('upload.form')->with('error', 'Error during import: ' . $e->getMessage());
    }
}



    public function scheduleMassNotification(Request $request)
    {
        $request->validate([
            'scheduled_datetime' => 'required|date_format:Y-m-d H:i:s',
            'message' => 'required|string',
            'contact_id' =>'required|integer',
            'user_id' =>'required|integer',
            'is_read' =>'required|boolean',
            'created_at' =>'required|date_format:Y-m-d H:i:s',
            'updated_at' =>'required|date_format:Y-m-d H:i:s',
        ]);

        $scheduledDateTime = $request->input('scheduled_datetime');
        $message = $request->input('message');
        $createdAt = $request->input('created_at');
        $updateAt = $request->input('updated_at');
        $userId = $request->input('user_id');
        $contactId = $request->input('contact_id');
        $isRead = $request->input('is_read');

        ScheduledNotification::create([
            'scheduled_at' => Carbon::parse($scheduledDateTime),
            'message' => $message,
            'contact_id' =>$contactId,
            'user_id' =>$userId,
            'is_read' => $isRead,
            'created_at' => Carbon::parse($createdAt),
            'updated_at' => Carbon::parse($updateAt)
        
        ]);

        return redirect()->route('upload.form')->with('success', 'Mass notification scheduled.');
    }

    public function cancelSchedule($id)
    {
    
        $scheduledNotification = ScheduledNotification::find($id);

        if (!$scheduledNotification) {
            
            return redirect()->route('upload.form')->with('error', 'Scheduled notification not found.');
        }

        $scheduledNotification->delete(); 

        return redirect()->route('upload.form')->with('success', 'Schedule canceled.');
    }

    public function editSchedule($id)
    {
        $scheduledNotification = ScheduledNotification::find($id);

        if (!$scheduledNotification) {
        
            return redirect()->route('upload.form')->with('error', 'Scheduled notification not found.');
        }

        $scheduledNotification->update([
            'scheduled_at' => now(), 
            'message' => 'New message',
            'contact_id' => 1,
            'user_id' => 1,
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('upload.form')->with('success', 'Schedule edited.');
    }
}