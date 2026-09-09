<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('email', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('subject', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('message', 'like', "%" . $this->escapeLike($search) . "%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        } else {
            $query->active();
        }

        $messages = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $unreadCount = ContactMessage::unread()->count();
        $filters = $request->only(['search', 'status']);

        return view('admin.messages.index', compact('messages', 'unreadCount', 'filters'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->isUnread()) {
            $contactMessage->markAsRead();
        }

        return view('admin.messages.show', ['message' => $contactMessage]);
    }

    public function update(Request $request, ContactMessage $contactMessage)
    {
        $action = $request->input('action');

        match ($action) {
            'mark_read' => $contactMessage->markAsRead(),
            'mark_unread' => $contactMessage->markAsUnread(),
            'archive' => $contactMessage->archive(),
            'unarchive' => $contactMessage->unarchive(),
            default => null,
        };

        return back()->with('status', 'Message updated.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.messages.index')
            ->with('status', 'Message deleted.');
    }
}
