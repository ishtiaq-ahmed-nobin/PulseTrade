<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $subscribers = $query->latest()->paginate(15)->withQueryString();

        $total = Subscriber::count();
        $active = Subscriber::where('is_active', true)->count();

        return view('admin.subscribers.index', compact('subscribers', 'total', 'active'));
    }

    public function toggle(Subscriber $subscriber)
    {
        $subscriber->update(['is_active' => !$subscriber->is_active]);
        return back()->with('success', 'Subscriber ' . ($subscriber->is_active ? 'activated' : 'deactivated') . '.');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber deleted.');
    }
}
